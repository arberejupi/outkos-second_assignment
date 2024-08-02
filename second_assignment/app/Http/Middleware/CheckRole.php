<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $userRole = Auth::user()->role;
        if (!in_array($userRole, $roles)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        // Debugging info
        return $next($request);
    }
}
