<?php

use App\Http\Controllers\Api\AdmissionsApiController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/web_front/pages_api.php';

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
