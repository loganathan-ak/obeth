<?php

namespace App\Http\Controllers;
use App\Models\Enquiry;
use App\Models\User;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\EnquirySubmittedMail;
use Illuminate\Support\Facades\Mail;

class EnquiryController extends Controller
{
   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'company_name' => 'required|string|max:20',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'file' => 'nullable|file|max:2048',
    ]);

    

    // Handle file upload
    if ($request->hasFile('file')) {
        $validated['file'] = $request->file('file')->store('enquiries', 'public');
    }

// Save enquiry
$user = Auth::user();
$validated['created_by'] = $user?->id;
$validated['obeth_id'] = $user?->obeth_id;

$enquiry = Enquiry::create($validated);

        // Superadmin (first one only)
        $superadmin = User::where('role', 'superadmin')->first();

        // Optional: get assigned designer (if exists), else null
        $designerId = $user?->designer_id;
        $designer = $designerId ? User::find($designerId) : null;

        // Create notification
        Notifications::create([
            'designer_id'   => $designer?->id,
            'client_id'     => $user?->id,
            'message'       => "A new enquiry has been submitted by \"{$user->name}\".",
            'purpose'       => 'enquiry_quote',
            'superadmin_id' => $superadmin?->id,
        ]);

        // Prepare recipients list
        $recipients = collect([
            $user?->email,
            $superadmin?->email,
            $designer?->email,
        ])->filter()->unique();

        // Send email to all
        foreach ($recipients as $email) {
            Mail::to($email)->send(new EnquirySubmittedMail($enquiry));
        }

    return back()->with('success', 'Enquiry submitted successfully!');
}

}
