<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;
class LoginController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    // Show the login form
    public function showLoginForm()
    {
        $user = Auth::user();
        if($user){
            return redirect('/');
        }
        return view('login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        Log::info('Login attempt with email: ' . $request->email);

        $user = Account::where('email', $request->email)->first();

        // If user exists, log the hashed password and check if it matches the input password
        if ($user) {
            Log::info('Stored hash for email ' . $request->email . ': ' . $user->password);
            if (Hash::check($request->password, $user->password)) {
                Log::info('Password matches for email ' . $request->email);
            } else {
                Log::warning('Password does not match for email ' . $request->email);
            }
        } else {
            Log::warning('No user found with email ' . $request->email);
        }
        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Redirect based on user type
            Log::info('Login successful');
            return redirect()->intended('/');
        }
        Log::warning('Login failed for email: ' . $request->email);
        // If login attempt was unsuccessful, redirect back with error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Handle the logout request
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
