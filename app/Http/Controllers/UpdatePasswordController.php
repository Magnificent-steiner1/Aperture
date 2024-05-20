<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class UpdatePasswordController extends Controller
{
    public function showUpdatePasswordForm(Request $request)
    {
        if (!$request->session()->has('forgot_password_email')) {
            return redirect()->route('forgot-password');
        }
        
        $email = $request->session()->get('forgot_password_email');
        
        $account = Account::where('email', $email)->first();

        return view('update-password', compact('account'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = $request->session()->get('forgot_password_email');

        $account = Account::where('email', $email)->first();

        $account->password = Hash::make($request['password']);
        $account->save();

        $request->session()->forget('forgot_password_email');

        return redirect()->route('login')->with('success', 'Password updated successfully. Please login with your new password.');
    }
}
