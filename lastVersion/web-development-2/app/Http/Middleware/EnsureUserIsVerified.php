<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // If not logged in, or not verified → redirect to login page
        if (!$user || !$user->is_verified) {
            return redirect('/login')->with('error', 'Please verify your email before accessing this page.');
        }

        return $next($request);
    }
}
