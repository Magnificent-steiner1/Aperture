<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPhotographer
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->account_type === 'photographer') {
            return $next($request);
        }

        return redirect('/')->with('error', 'You are not authorized to access this page.');
    }
}
