<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsPhotographer
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->photographer) {
            return $next($request);
        }
        return redirect()->route('home')->with('error', 'Access denied.');
    }
}

