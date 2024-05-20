<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsClient
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->client) {
            return $next($request);
        }
        return redirect()->route('home')->with('error', 'Access denied.');
    }
}

