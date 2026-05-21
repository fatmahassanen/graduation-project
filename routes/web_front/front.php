<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\Pages\PageController;
use App\Http\Controllers\StudentPortalController;
use Illuminate\Support\Facades\Route;

// Public Pages - Main Navigation
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/events', [PageController::class, 'events'])->name('events');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/news', [PageController::class, 'news'])->name('news');
Route::get('/departments', [PageController::class, 'departments'])->name('departments');

// Admission Application (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/apply', [AdmissionController::class, 'create'])->name('admission.create');
    Route::post('/apply', [AdmissionController::class, 'store'])->name('admission.store');

    // Student Portal
    Route::get('/student/portal', [StudentPortalController::class, 'index'])->name('student.portal');
    Route::get('/student/profile/edit', [StudentPortalController::class, 'editProfile'])->name('student.profile.edit');
    Route::put('/student/profile', [StudentPortalController::class, 'updateProfile'])->name('student.profile.update');
    Route::get('/student/password/edit', [StudentPortalController::class, 'editPassword'])->name('student.password.edit');
    Route::put('/student/password', [StudentPortalController::class, 'updatePassword'])->name('student.password.update');
    Route::delete('/student/application', [StudentPortalController::class, 'deleteApplication'])->name('student.application.delete');
});

// About Dropdown Pages
Route::get('/president', [PageController::class, 'president'])->name('president');
Route::get('/dean1', [PageController::class, 'dean1'])->name('dean1');
Route::get('/dean2', [PageController::class, 'dean2'])->name('dean2');
Route::get('/dean3', [PageController::class, 'dean3'])->name('dean3');
Route::get('/campus', [PageController::class, 'campus'])->name('campus');
Route::get('/internalprotocols', [PageController::class, 'internalProtocols'])->name('internalprotocols');
Route::get('/externalprotocols', [PageController::class, 'externalProtocols'])->name('externalprotocols');
Route::get('/reasons', [PageController::class, 'reasons'])->name('reasons');
Route::get('/competitions', [PageController::class, 'competitions'])->name('competitions');
Route::get('/graduates', [PageController::class, 'graduates'])->name('graduates');

// Units Dropdown Pages
Route::get('/digitaltrans', [PageController::class, 'digitalTrans'])->name('digitaltrans');
Route::get('/internationalcoop', [PageController::class, 'internationalCoop'])->name('internationalcoop');
Route::get('/quality', [PageController::class, 'quality'])->name('quality');
Route::get('/evaluation', [PageController::class, 'evaluation'])->name('evaluation');
Route::get('/women', [PageController::class, 'women'])->name('women');

// Faculties Dropdown Pages
Route::get('/facultyit', [PageController::class, 'facultyIt'])->name('facultyit');
Route::get('/facultyhealth', [PageController::class, 'facultyHealth'])->name('facultyhealth');

// Admissions Dropdown Pages
Route::get('/admissions', [PageController::class, 'admissions'])->name('admissions');
// Route::get('/howapply', [PageController::class, 'howApply'])->name('howapply');
Route::get('/faculties-requirements', [PageController::class, 'facultiesRequirements'])->name('faculties-requirements');
Route::get('/postgraduate-studies', [PageController::class, 'postgraduateStudies'])->name('postgraduate-studies');
Route::get('/fees', [PageController::class, 'fees'])->name('fees');

// Campus Dropdown Pages
Route::get('/entrepreneur', [PageController::class, 'entrepreneur'])->name('entrepreneur');
Route::get('/activities', [PageController::class, 'activities'])->name('activities');

// Staff Dropdown Pages
Route::get('/stafflms', [PageController::class, 'staffLms'])->name('stafflms');
Route::get('/staff-profile', [PageController::class, 'profile'])->name('staff.profile');
Route::get('/members', [PageController::class, 'members'])->name('members');

// Student Services Dropdown Pages
Route::get('/student-service', [PageController::class, 'studentService'])->name('student-service');
Route::get('/student-booking', [PageController::class, 'studentBooking'])->name('student-booking');
Route::get('/library', [PageController::class, 'library'])->name('library');
Route::get('/trainings', [PageController::class, 'trainings'])->name('trainings');

// Quality Assurance Unit - Dynamic Routes
Route::get('/quality/{slug}', [PageController::class, 'showQualityPage'])->name('quality.show');

// postgraduate dynamic routes
Route::get('/it', [PageController::class, 'itPostgraduate'])->name('itPostgraduate');
Route::get('/mechatronics', [PageController::class, 'mechatronicsPostgraduate'])->name('mechatronicsPostgraduate');
Route::get('/energy', [PageController::class, 'energyPostgraduate'])->name('energyPostgraduate');
Route::get('/petroleum', [PageController::class, 'petroleumPostgraduate'])->name('petroleumPostgraduate');
Route::get('/prosthetics', [PageController::class, 'prostheticsPostgraduate'])->name('prostheticsPostgraduate');
Route::get('/autotronics', [PageController::class, 'autotronicsPostgraduate'])->name('autotronicsPostgraduate');
Route::get('/postgraduate-apply', [PageController::class, 'postgraduateApply'])->name('postgraduate-apply');

// Dynamic page route (catch-all for other pages)
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
