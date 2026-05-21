<?php

use App\Http\Controllers\Api\Pages\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('events', EventController::class);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
