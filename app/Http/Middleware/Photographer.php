<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Photographer
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->account_type == 'photographer') {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Access denied. Only photographers can access this page.');
    }
}
