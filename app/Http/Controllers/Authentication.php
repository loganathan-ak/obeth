<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Authentication extends Controller
{

    public function userRegister(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);
        $latestId = User::max('obeth_id');
        $nextNumber = $latestId ? intval(str_replace('OBE-', '', $latestId)) + 1 : 1000;
        // Create the new user record
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Make sure to hash the password
            'obeth_id' => 'OBE-' . $nextNumber,
        ]);
    
        // Optionally log the user in after registration (if needed)
        // Auth::login($user);
    
        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }


    public function userLogin(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6', // no 'confirmed' here for login
        ]);
    
        // Attempt to log the user in with the validated credentials
        if (Auth::attempt([
            'email' => $validated['email'], 
            'password' => $validated['password']
        ])) {
            $request->session()->regenerate();

                $user = Auth::user();

                // Redirect based on role
                if ($user->role === 'superadmin') {
                    return redirect()->route('superadmin.dashboard');
                } elseif ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('subscribers.dashboard'); // For subscriber or default
                }
        }

        // If authentication fails, return back with error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function userLogout(Request $request) {
        Auth::logout();
        return redirect('/login');
      }
}
