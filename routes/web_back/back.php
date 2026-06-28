<?php

use App\Http\Controllers\Back\ActivitiesController;
use App\Http\Controllers\Back\AdminController;
use App\Http\Controllers\Api\AdmissionsApiController;
use App\Http\Controllers\Back\AdmissionsController;
use App\Http\Controllers\Back\CompetitionsController;
use App\Http\Controllers\Back\DeansController;
use App\Http\Controllers\Back\DepartmentsController;
use App\Http\Controllers\Back\EventsController;
use App\Http\Controllers\Back\ExternalProtocolsController;
use App\Http\Controllers\Back\GalleryController;
use App\Http\Controllers\Back\GraduatesController;
use App\Http\Controllers\Back\InternalProtocolsController;
use App\Http\Controllers\Back\NewsController;
use App\Http\Controllers\Back\PresidentController;
use App\Http\Controllers\Back\TestimonialsController;
use App\Http\Controllers\Back\TrainingsController;
use App\Http\Controllers\Back\TuitionFeesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Admissions Management
    Route::get('/admissions/pending', [AdmissionsController::class, 'pending'])->name('admissions.pending');
    Route::get('/admissions/accepted', [AdmissionsController::class, 'accepted'])->name('admissions.accepted');
    Route::get('/admissions/rejected', [AdmissionsController::class, 'rejected'])->name('admissions.rejected');
    Route::get('/admissions/{admission}', [AdmissionsController::class, 'show'])->name('admissions.show');
    Route::get('/admissions/{admission}/generate-code', [AdmissionsApiController::class, 'generateCode'])
        ->name('admissions.generate-code');
    Route::post('/admissions/{admission}/approve', [AdmissionsController::class, 'approve'])->name('admissions.approve');
    Route::post('/admissions/{admission}/reject', [AdmissionsController::class, 'reject'])->name('admissions.reject');

    // Events CRUD
    Route::resource('events', EventsController::class);

    // News CRUD
    Route::resource('news', NewsController::class);

    // Departments Management (Edit-Only)
    Route::get('/departments', [DepartmentsController::class, 'index'])->name('departments.index');
    Route::get('/departments/{department}/edit', [DepartmentsController::class, 'edit'])->name('departments.edit');
    Route::put('/departments/{department}', [DepartmentsController::class, 'update'])->name('departments.update');

    // Gallery CRUD
    Route::resource('gallery', GalleryController::class);

    // Trainings CRUD
    Route::resource('trainings', TrainingsController::class);

    // Activities CRUD
    Route::resource('activities', ActivitiesController::class);

    // President Page Content
    Route::get('/president', [PresidentController::class, 'edit'])->name('president.edit');
    Route::put('/president', [PresidentController::class, 'update'])->name('president.update');

    // Deans Management
    Route::get('/deans', [DeansController::class, 'index'])->name('deans.index');
    Route::get('/deans/{dean}/edit', [DeansController::class, 'edit'])->name('deans.edit');
    Route::put('/deans/{dean}', [DeansController::class, 'update'])->name('deans.update');

    // External Protocols CRUD
    Route::resource('external-protocols', ExternalProtocolsController::class);

    // Internal Protocols CRUD
    Route::resource('internal-protocols', InternalProtocolsController::class);

    // Competitions CRUD
    Route::resource('competitions', CompetitionsController::class);
    Route::put('/competitions-video', [CompetitionsController::class, 'updateVideo'])->name('competitions.update-video');

    // Graduates CRUD
    Route::resource('graduates', GraduatesController::class);
    Route::put('/graduates-hero', [GraduatesController::class, 'updateHero'])->name('graduates.update-hero');

    // Tuition Fees Management
    Route::get('/tuition-fees', [TuitionFeesController::class, 'index'])->name('tuition-fees.index');
    Route::get('/tuition-fees/{tuitionFee}/edit', [TuitionFeesController::class, 'edit'])->name('tuition-fees.edit');
    Route::put('/tuition-fees/{tuitionFee}', [TuitionFeesController::class, 'update'])->name('tuition-fees.update');
    Route::put('/tuition-fees-settings', [TuitionFeesController::class, 'updateSettings'])->name('tuition-fees.update-settings');

    // Testimonials Management (Edit-Only)
    Route::get('/testimonials', [TestimonialsController::class, 'index'])->name('testimonials.index');
    Route::get('/testimonials/{testimonial}/edit', [TestimonialsController::class, 'edit'])->name('testimonials.edit');
    Route::put('/testimonials/{testimonial}', [TestimonialsController::class, 'update'])->name('testimonials.update');
    Route::post('/testimonials/update-order', [TestimonialsController::class, 'updateOrder'])->name('testimonials.update-order');



    Route::get('/students', function () {
        return view('admin.students.index');
    })->name('students.index');

    // Route::get('/settings', function () {
    //     return view('admin.settings.index');
    // })->name('settings.index');
        // Placeholder routes (to be removed once resource routes are fully implemented)
    // Route::get('/media', function () {
    //     return view('admin.media.index');
    // })->name('media.index');
});
