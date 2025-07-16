<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BrandsProfile;
use App\Models\Orders;
use App\Models\Enquiry;
use App\Models\Notifications;
use App\Models\CreditsUsage;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderStatusUpdatedMail;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function adminViewOrders($id){
        $user = auth()->user();

        
        $subscribers = User::where('role', 'subscriber')->get();
       $creditsUsage = CreditsUsage::where('order_id', $id)->first();
        $admins = User::where('role', 'admin')->get();

        $order = Orders::findOrFail($id);
        $order->seen = 1;
        $order->save();
            // Load associated brand
        $brand = BrandsProfile::find($order->brands_profile_id);  
        $quoteNotification = Notifications::where('order_id', $id)->where('purpose', 'quote')->first();

        return view('designers&admin.orders.view-order', compact('order', 'brand', 'subscribers', 'admins', 'quoteNotification', 'creditsUsage'));
        
    }

    public function adminEditOrders($id){

        $user = auth()->user();

        $brands = BrandsProfile::get();

        $subscribers = User::where('role', 'subscriber')->get();

        $admins = User::where('role', 'admin')->get();

        $order = Orders::findOrFail($id);

        return view('designers&admin.orders.edit-order', compact('order', 'brands', 'subscribers', 'admins'));
    
    }


    public function updateOrder(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,In Progress,Completed,Cancelled',
        ]);
    
        $order = Orders::findOrFail($id);
        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

       // Get recipients
        $designer   = Auth::user(); // Or $order->assignedDesigner if set
        $client     = User::find($order->created_by);
        $superadmin = User::where('role', 'superadmin')->first();

        // Create DB notification
        Notifications::create([
            'designer_id'   => $designer->id,
            'client_id'     => $client->id,
            'message'       => "Job \"{$order->project_title}\" status has been updated to \"{$order->status}\".",
            'purpose'       => 'status',
            'superadmin_id' => $superadmin->id,
        ]);

        // Send status email to all 3 users
        $recipients = collect([$designer->email, $client->email, $superadmin->email])->unique()->filter();

        foreach ($recipients as $email) {
            Mail::to($email)->send(new OrderStatusUpdatedMail($order));
        }



    
        // ✅ Check if we need to promote a queued order (only when status is changed to Completed)
        if ($oldStatus !== 'Completed' && $request->status === 'Completed') {
            // Count active orders for the user
            $activeCount = Orders::where('created_by', $order->created_by)
                ->whereIn('status', ['Pending', 'In Progress'])
                ->count();
    
            if ($activeCount < 5) {
                // Promote oldest queued order (if any)
                $nextInQueue = Orders::where('created_by', $order->created_by)
                    ->where('status', 'Queued')
                    ->orderBy('created_at')
                    ->first();
    
                if ($nextInQueue) {
                    $nextInQueue->status = 'Pending';
                    $nextInQueue->save();
    
                    // Optional: notify client that their order moved to active
                    // Notifications::create([
                    //     'created_by' => Auth::id(),
                    //     'client_id'  => $nextInQueue->created_by,
                    //     'message'    => "Your queued job \"{$nextInQueue->project_title}\" is now active.",
                    //     'purpose'    => 'promotion',
                    // ]);
                }
            }
        }
    
        return back()->with('success', 'Status updated successfully!');
    }
    


    public function adminEnquires(Request $request)
    {
        $currentUserId = Auth::id();
    
        // Get all subscriber IDs assigned to this designer/admin
        $userIds = User::where('designer_id', $currentUserId)->pluck('id');
    
        $query = Enquiry::whereIn('created_by', $userIds);
    
        // Filter by from_date
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
    
        // Filter by to_date
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
    
        $enquiries = $query->latest()->get();
    
        return view('designers&admin.enquires', compact('enquiries'));
    }
    


public function adminSearchEnquires(Request $request)
{
    $currentUserId = Auth::id();
    $query = $request->query('query'); // get the 'query' from ?query=...

    // Get all user IDs where designer_id equals the current user's ID
    $userIds = User::where('designer_id', $currentUserId)->pluck('id');

    // Search enquiries created by those users and filter by name, email, subject, or phone
    $enquiries = Enquiry::whereIn('created_by', $userIds)
        ->where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('email', 'like', "%{$query}%")
              ->orWhere('phone', 'like', "%{$query}%")
              ->orWhere('subject', 'like', "%{$query}%");
        })
        ->latest()
        ->get();

    return response()->json([
        'enquiries' => $enquiries,
    ]);
}

public function adminSearchjobs(Request $request)
{
    $user = auth()->user();


    $query = Orders::where('assigned_to', $user->id);
   

    // Apply job name filter
    if ($request->filled('jobname')) {
        $query->where(function ($q) use ($request) {
            $q->where('project_title', 'like', '%' . $request->jobname . '%')
              ->orWhere('order_id', 'like', '%' . $request->jobname . '%');
        });
    }

    // Apply status filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Fetch results
    $orders = $query->latest()->get();

    return response()->json(['orders' => $orders]);
}


}
