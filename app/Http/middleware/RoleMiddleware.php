<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: Route::middleware(['role:admin']) or Route::middleware(['role:admin,superadmin'])
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (! in_array($user->role, $roles)) {
            // If authenticated but wrong role, redirect to their proper dashboard
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
