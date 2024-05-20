<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account; 

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'dob' => 'required|date',
            'address' => 'required',
        ]);
    
        
        $account = Account::where('email', $request->email)
            ->where('dob', $request->dob)
            ->where('address', $request->address)
            ->first();
    
        if (!$account) {
            return back()->withErrors(['message' => 'Invalid credentials.']);
        }
    
       
        $request->session()->put('forgot_password_email', $account->email);
    
        return redirect()->route('update-password');
    }
    
}
