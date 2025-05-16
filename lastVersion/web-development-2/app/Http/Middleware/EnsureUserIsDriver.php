<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EnsureUserIsDriver
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->role === 'driver') {
            return $next($request);
        }
    
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Access denied: Drivers only.'], 403);
        }
    
        abort(403, 'Access denied: Drivers only.');
    }
}
