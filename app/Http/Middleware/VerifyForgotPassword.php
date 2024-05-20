<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyForgotPassword
{

    public function handle($request, Closure $next)
    {
        if ($request->session()->has('forgot_password_email')) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'You are not authorized to access this page.');
    }
}
