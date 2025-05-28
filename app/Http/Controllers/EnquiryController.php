<?php

namespace App\Http\Controllers;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnquiryController extends Controller
{
   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'file' => 'nullable|file|max:2048',
    ]);

    

    // Handle file upload
    if ($request->hasFile('file')) {
        $validated['file'] = $request->file('file')->store('enquiries', 'public');
    }

    // Set user-related fields safely
    $user = Auth::user();
    $validated['created_by'] = $user ? $user->id : null;
    $validated['obeth_id'] = $user ? $user->obeth_id : null;

    Enquiry::create($validated);

    return back()->with('success', 'Enquiry submitted successfully!');
}

}
