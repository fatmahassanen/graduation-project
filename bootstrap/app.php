<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register global middleware
        $middleware->append(\App\Http\Middleware\SecurityHeadersMiddleware::class);
        $middleware->append(\App\Http\Middleware\SetLocaleMiddleware::class);
        
        // Register middleware aliases
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'faculty.scope' => \App\Http\Middleware\FacultyAdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Environment-aware error handling
        // Development: Show detailed errors with stack traces
        // Production: Log errors and show generic error pages
        
        if (config('app.env') === 'production') {
            // Production: Generic error messages for security
            $exceptions->respond(function (\Symfony\Component\HttpFoundation\Response $response) {
                if ($response->getStatusCode() === 500) {
                    return response()->view('errors.500', [], 500);
                }
                
                if ($response->getStatusCode() === 404) {
                    return response()->view('errors.404', [], 404);
                }
                
                if ($response->getStatusCode() === 403) {
                    return response()->view('errors.403', [], 403);
                }
                
                return $response;
            });
        }
        
        // Development: Detailed errors are shown by default via APP_DEBUG=true
    })->create();
