<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has admin role
        if (auth()->user()->role !== 'admin') {
            // Redirect non-admin users to student portal
            return redirect()->route('student.portal')
                ->with('error', 'Unauthorized access. You do not have permission to access the admin panel.');
        }

        return $next($request);
    }
}
