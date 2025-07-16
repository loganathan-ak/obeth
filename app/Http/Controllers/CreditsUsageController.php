<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditsUsage;
use App\Models\Orders;
use App\Models\User;
use App\Models\Notifications;
use App\Mail\QuoteUpdates;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreditsUsageController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'complexity' => 'required|array',
            'rush_credits' => 'nullable|integer|min:0',
        ]);
    
        $order = Orders::findOrFail($request->order_id);

    
        $complexities = $request->input('complexity');
        $customCredits = $request->input('custom_credits', []);
        $rushCredits = $request->input('rush_credits', 0);
    
        $totalCredits = 0;
        $imageDescriptions = [];
    
        $creditValues = [
            'S' => ['label' => 'Simple', 'credits' => 1],
            'M' => ['label' => 'Medium', 'credits' => 2],
            'C' => ['label' => 'Complex', 'credits' => 3],
            'SC' => ['label' => 'Super Complex', 'credits' => 5],
        ];
    
        $images = json_decode($order->reference_files, true);
    
        foreach ($complexities as $index => $value) {
            if ($value === 'custom') {
                $credits = isset($customCredits[$index]) ? (int)$customCredits[$index] : 0;
                $label = "Custom";
            } else {
                $credits = $creditValues[$value]['credits'] ?? 0;
                $label = $creditValues[$value]['label'] ?? 'Unknown';
            }
    
            $totalCredits += $credits;
    
            $imageDescriptions[] = [
                'path' => $images[$index]['path'] ?? '',
                'original_name' => $images[$index]['original_name'] ?? 'Image',
                'credits' => $credits,
                'label' => $label,
            ];
        }
    
        // ✅ Add rush credits to total credits
        $totalCredits += $rushCredits;
    
        $quote = CreditsUsage::create([
            'user_id' => $order->created_by,
            'order_id' => $order->id,
            'job_id' => $order->order_id,
            'credits_used' => $totalCredits,
            'rush' => $rushCredits,
            'description' => json_encode($imageDescriptions),
            'status' => 'pending',
        ]);
         
        $order->status = 'Approval Pending';
        $order->save();


        Notifications::create([
            'created_by' => Auth::user()->id,
            'client_id'  => $order->created_by,
            'message'    => "You received a quote request for \"{$order->project_title}\".",
            'purpose'    => 'quote',
            'order_id'   => $order->id,
        ]);

        // Get the user who should receive the email (client)
        $client = User::find($order->created_by);
       
       // Ensure client exists and has an email before sending
        if ($client && $client->email) {
            Mail::to($client->email)->send(new QuoteUpdates($quote));
        }
    
        return back()->with('success', 'Credits quote submitted successfully.');
    }
    



public function approve(Orders $order)
{
    $creditsUsage = CreditsUsage::where('order_id', $order->id)->first();



    if (!$creditsUsage) {
        return back()->with('error', 'No credits usage found for this order.');
    }

    $currentUser = auth()->user();

    // Allow only the order creator, superadmin, or admin
    if ($currentUser->id !== $order->created_by && !in_array($currentUser->role, ['superadmin', 'admin'])) {
        abort(403);
    }

    $user = User::find($order->created_by);

    if (!$user) {
        return back()->with('error', 'User not found.');
    }

    if ($user->credits < $creditsUsage->credits_used) {
        return back()->with('error', 'Insufficient credits.');
    }

    $user->credits -= $creditsUsage->credits_used;
    $user->save();

    $creditsUsage->status = 'approved';
    $creditsUsage->save();

    Notifications::create([
            'designer_id' =>  $order->assigned_to,
            'client_id'  => Auth::user()->id,
            'message'    => "Quote approved for \"{$order->project_title}\".",
            'purpose'    => 'quote',
            'order_id'   => $order->id,
        ]);

     // Get the user who should receive the email (client)
    $designer = User::find($order->assigned_to);

    //for sending mail same query with different variable name
    $quote = CreditsUsage::where('order_id', $order->id)->first();

    // Ensure client exists and has an email before sending
    if ($designer && $designer->email) {
        Mail::to($designer->email)->send(new QuoteUpdates($quote));
    }
        

    return back()->with('success', "Ratings approved. {$creditsUsage->credits_used} credits deducted from {$user->name}.");
}


public function destroy(CreditsUsage $usage, Request $request)
{
    $user = auth()->user();

    // Permission check
    if ( $user->id !== $usage->user_id && !in_array($user->role, ['superadmin', 'admin'])) {
        abort(403, 'Unauthorized action.');
    }

    $order = Orders::findOrFail($usage->order_id);
    $order->status = 'In Progress';
     $order->save();

    // Delete the credits usage record
    $usage->delete();

    // Delete associated notification if ID is provided
    if ($request->filled('notification')) {
        Notifications::find($request->notification)?->delete();
    }

    return back()->with('success', 'Rating deleted successfully.');
}





}
