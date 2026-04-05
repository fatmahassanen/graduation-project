<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get language from URL parameter first
        $language = $request->input('language');
        
        // If not in URL, try session (if available)
        if (!$language && $request->hasSession()) {
            $language = $request->session()->get('locale');
        }
        
        // Fall back to default locale
        if (!$language) {
            $language = config('app.locale', 'en');
        }

        // Validate language is supported (en or ar)
        if (!in_array($language, ['en', 'ar'])) {
            $language = 'en';
        }

        // Set application locale
        app()->setLocale($language);

        // Store in session for future requests (if session is available)
        if ($request->hasSession()) {
            $request->session()->put('locale', $language);
        }

        return $next($request);
    }
}
