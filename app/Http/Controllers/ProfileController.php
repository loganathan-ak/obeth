<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
{
    return view('profilepage');
}

public function update(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'first_name'     => 'required|string|max:255',
        'last_name'      => 'nullable|string|max:255',
        'email'          => 'required|email|unique:users,email,' . $user->id,
        'mobile_number'  => 'nullable|string|max:20',
        'office_number' => 'nullable|string|max:20',
        'company_name' => 'nullable|string|max:255',
        'country'        => 'nullable|string|max:100',
        'other_country'  => 'nullable|string|max:100',
        'address'        => 'nullable|string',
    ]);

    // If country is not "Other", reset the other_country field
    if ($validated['country'] !== 'Other') {
        $validated['other_country'] = null;
    }

    $user->update($validated);

    return back()->with('success', 'Profile updated successfully.');
}


public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|confirmed|min:6',
    ]);

    if (!Hash::check($request->current_password, Auth::user()->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect']);
    }

    Auth::user()->update(['password' => Hash::make($request->new_password)]);
    return back()->with('success', 'Password updated successfully.');
}

}
