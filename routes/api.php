<?php

use App\Http\Controllers\Api\AdmissionsApiController;
use App\Http\Controllers\Api\MediaApiController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/web_front/pages_api.php';

/*
|--------------------------------------------------------------------------
| Media Center API Routes
|--------------------------------------------------------------------------
|
| Public API endpoints for Events, Gallery, and News.
| Rate-limited to 60 requests per minute.
|
*/

Route::middleware('throttle:60,1')->group(function () {
    // Events
    Route::get('/events', [MediaApiController::class, 'events'])->name('api.events');
    Route::get('/events/{id}', [MediaApiController::class, 'event'])->name('api.events.show');
    
    // Gallery
    Route::get('/gallery', [MediaApiController::class, 'gallery'])->name('api.gallery');
    Route::get('/gallery/{id}', [MediaApiController::class, 'galleryItem'])->name('api.gallery.show');
    
    // News
    Route::get('/news', [MediaApiController::class, 'news'])->name('api.news');
    Route::get('/news/{id}', [MediaApiController::class, 'newsItem'])->name('api.news.show');
});

/*
|--------------------------------------------------------------------------
| Student Code Auto-Generation API Routes
|--------------------------------------------------------------------------
|
| API endpoint for generating unique student codes for admission approvals.
| Protected by authentication, admin role, and rate limiting.
|
*/

Route::middleware(['auth', 'admin', 'throttle:60,1'])->group(function () {
    Route::get('/admissions/{admission}/generate-code', [AdmissionsApiController::class, 'generateCode'])
        ->name('api.admissions.generate-code');
});
