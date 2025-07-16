<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notifications;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewUserRegistered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Mail\ForgotPassword;


class Authentication extends Controller
{

    // public function userRegister(Request $request)
    // {
    //     // Validate the incoming request data
    //     $validated = $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|confirmed|min:6',
    //     ]);
    //     $latestId = User::max('obeth_id');
    //     $nextNumber = $latestId ? intval(str_replace('OBE-', '', $latestId)) + 1 : 1000;
    //     // Create the new user record
    //     $user = User::create([
    //         'name' => $validated['name'],
    //         'email' => $validated['email'],
    //         'password' => Hash::make($validated['password']), // Make sure to hash the password
    //         'obeth_id' => 'OBE-' . $nextNumber,
    //     ]);
    
    //     // Optionally log the user in after registration (if needed)
    //     // Auth::login($user);
    
    //     return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    // }


   public function userRegister(Request $request)
{

    // Check if email already exists
    $existingUser = User::where('email', $request->email)->first();

    if ($existingUser) {
        if (!$existingUser->is_active) {
            // User exists but hasn't completed payment — let them continue
            Auth::login($existingUser);
            return redirect()->route('paypal.create', ['plan_id' => $request->plan_id])
                ->with('info', 'You already registered. Please complete your payment to activate your account.');
        }

        // Email exists and user is active → throw error
        throw ValidationException::withMessages([
            'email' => 'This email is already registered.',
        ]);
    }

    // Validate the incoming request data
    $validated = $request->validate([
        'first_name' => 'required|string|max:100',
        'last_name' => 'nullable|string|max:100',
        'mobile_number' => 'nullable|string|max:20',
        'country' => 'required|string|max:100',
        'other_country' => 'nullable|string|max:100',
        'company_name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
        'plan_id' => 'required',
    ]);

    // Determine final country value
    $finalCountry = $validated['country'] === 'Other'
        ? $validated['other_country']
        : $validated['country'];

    // Generate custom obeth_id
    $latestId = User::max('obeth_id');
    $nextNumber = $latestId ? intval(str_replace('OBE-', '', $latestId)) + 1 : 1000;

    // ROUND ROBIN: Assign this user to a designer
    $designers = User::where('role', 'admin')->get();
    $designerCount = $designers->count();

    if ($designerCount > 0) {
        $assignedCount = User::whereNotNull('designer_id')
            ->selectRaw('designer_id, COUNT(*) as count')
            ->groupBy('designer_id')
            ->orderBy('count')
            ->get()
            ->pluck('count', 'designer_id');

        $designerToAssign = $designers->sortBy(function ($designer) use ($assignedCount) {
            return $assignedCount[$designer->id] ?? 0;
        })->first();

        $designerId = $designerToAssign->id;
    } else {
        $designerId = null;
    }

    // Create new user
    $user = User::create([
        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
        'mobile_number' => $validated['mobile_number'],
        'country' => $finalCountry,
        'other_country' => $validated['country'] === 'Other' ? $validated['other_country'] : null,
        'email' => $validated['email'],
        'company_name' => $validated['company_name'],
        'password' => Hash::make($validated['password']),
        'obeth_id' => 'OBE-' . $nextNumber,
        'designer_id' => $designerId,
        'is_active' => false,
    ]);

        // 🔔 Send mail to superadmins
        $superadmins = User::where('role', 'superadmin')->get();
        foreach ($superadmins as $admin) {
            Mail::to($admin->email)->send(new NewUserRegistered($user));

            Notifications::create([
                'designer_id'    =>  $designerId, 
                'client_id'      => 0, 
                'message'        => "A new user \"{$user->first_name} {$user->last_name}\" has registered.",
                'purpose'        => 'order_created',
                'superadmin_id'  => $admin->id,
            ]);
        }
    
        // 🔔 Send mail to assigned designer (if exists)
        if ($designerId) {
            $designer = User::find($designerId);
            if ($designer) {
                Mail::to($designer->email)->send(new NewUserRegistered($user));
            }
        }
     
            // Log in the newly registered user
        Auth::login($user);

        // Redirect to createPayment route with selected plan_id (you can default or use a form value)
        return redirect()->route('paypal.create', ['plan_id' => $request->plan_id]);

    //return redirect()->route('login')->with('success', 'Registration successful! Please login.');
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
                } elseif ($user->role === 'qualitychecker') {
                    return redirect()->route('qc.dashboard');
                }  elseif ($user->role === 'subscriber' && $user->is_active) {
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

    
    public function forgotPassword(){
        return view('auth.forgot-password');
    }


    public function sendNewPassword(Request $request)
      {
          // 1. Validate the email: Ensures it's required, a valid email format, and exists in the users table.
          $request->validate(['email' => 'required|email|exists:users,email']);
  
          // 2. Find the user by their email address.
          $user = User::where('email', $request->email)->first();
  
          // Fallback check: If the user is somehow not found (though 'exists' validation should prevent this),
          // redirect back with an error.
          if (!$user) {
              return back()->withErrors(['email' => 'We could not find a user with that email address.']);
          }
  
          // 3. Generate a new, random, and strong password.
          // Str::random(12) creates a 12-character alphanumeric string. You can adjust the length.
          $newPassword = Str::random(6);
  
          // 4. Hash the new password and save it to the user's record in the database.
          // It's crucial to always hash passwords before storing them.
          $user->password = Hash::make($newPassword);
          $user->save(); // Save the updated user record to the database.
  
          // 5. Send the new password to the user's email using Laravel's Mail Facade and your Mailable class.
          try {
              // Ensure your mail settings are correctly configured in your .env file
              // (e.g., MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD).
              Mail::to($user->email)->send(new ForgotPassword($user, $newPassword));
          } catch (\Exception $e) {
              // If there's an error sending the email (e.g., mail server issues),
              // log the error for debugging and inform the user.
              \Log::error('Failed to send new password email: ' . $e->getMessage());
              return back()->withErrors(['email' => 'Could not send the new password email. Please try again later.']);
          }
  
          // 6. Redirect the user to the login page with a success message.
          // They will then use the newly received password to log in.
          return redirect()->route('login')->with('status', 'A new password has been sent to your email address. Please check your inbox and spam folder.');
      }
}
