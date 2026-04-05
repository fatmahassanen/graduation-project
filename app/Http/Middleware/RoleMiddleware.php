<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $roles  Comma-separated list of allowed roles
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            abort(403, 'Unauthorized access');
        }

        // Parse comma-separated roles
        $allowedRoles = array_map('trim', explode(',', $roles));

        // Check if user has one of the required roles
        if (!in_array($request->user()->role, $allowedRoles)) {
            abort(403, 'You do not have permission to access this resource');
        }

        return $next($request);
    }
}
