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
    Route::post('/student/update-photo', [StudentPortalController::class, 'updatePhoto'])->name('student.update-photo');
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
// Route::get('/quality', [PageController::class, 'quality'])->name('quality');
Route::get('/evaluation', [PageController::class, 'evaluation'])->name('evaluation');
Route::get('/women', [PageController::class, 'women'])->name('women');

// Faculties Dropdown Pages
Route::get('/facultyit', [PageController::class, 'facultyIt'])->name('facultyit');
Route::get('/facultyhealth', [PageController::class, 'facultyHealth'])->name('facultyhealth');

// Admissions Dropdown Pages
Route::get('/admissions', [PageController::class, 'admissions'])->name('admissions');
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
// Route::get('/quality/{slug}', [PageController::class, 'showQualityPage'])->name('quality.show');

// postgraduate dynamic routes
Route::get('/it', [PageController::class, 'itPostgraduate'])->name('itPostgraduate');
Route::get('/mechatronics-postgrad', [PageController::class, 'mechatronicsPostgraduate'])->name('mechatronicsPostgraduate');
Route::get('/energy', [PageController::class, 'energyPostgraduate'])->name('energyPostgraduate');
Route::get('/petroleum-postgrad', [PageController::class, 'petroleumPostgraduate'])->name('petroleumPostgraduate');
Route::get('/prosthetics-postgrad', [PageController::class, 'prostheticsPostgraduate'])->name('prostheticsPostgraduate');
Route::get('/autotronics-postgrad', [PageController::class, 'autotronicsPostgraduate'])->name('autotronicsPostgraduate');
Route::get('/postgraduate-apply', [PageController::class, 'postgraduateApply'])->name('postgraduate-apply');

// Department Detail Pages - Undergraduate Programs
Route::get('/information-technology', function () {
    return view('pages.departments.information-technology');
})->name('dept.ict');

Route::get('/mechatronics', function () {
    return view('pages.departments.mechatronics');
})->name('dept.mechatronics');

Route::get('/autotronics', function () {
    return view('pages.departments.autotronics');
})->name('dept.autotronics');

Route::get('/petroleum', function () {
    return view('pages.departments.petroleum');
})->name('dept.petroleum');

Route::get('/renewable-energy', function () {
    return view('pages.departments.renewable');
})->name('dept.renewable');

Route::get('/prosthetics', function () {
    return view('pages.departments.prosthetics');
})->name('dept.prosthetics');

// Quality Assurance Sub-Pages (MUST BE BEFORE CATCH-ALL ROUTE)
Route::prefix('quality')->name('quality.')->group(function () {
    Route::view('/', 'pages.quality.index')->name('index');
    Route::view('/introduction', 'pages.quality.intro')->name('intro');
    Route::view('/vision-mission', 'pages.quality.vision')->name('vision');
    Route::view('/periodical-publication', 'pages.quality.periodical-pub')->name('periodical-pub');
    Route::view('/tasks', 'pages.quality.tasks')->name('tasks');
    Route::view('/internal-regulations', 'pages.quality.regulations')->name('regulations');
    Route::view('/organizational-structure', 'pages.quality.org-structure')->name('org-structure');
    Route::view('/executive-council', 'pages.quality.executive-council')->name('executive-council');
    Route::view('/administrative-council', 'pages.quality.admin-council')->name('admin-council');
    Route::view('/academic-standards', 'pages.quality.academic-standards')->name('academic-standards');
    Route::view('/activities', 'pages.quality.activities')->name('activities');
    Route::view('/courses-workshops', 'pages.quality.courses-workshops')->name('courses-workshops');
});

// Dynamic page route (catch-all for other pages) - MUST BE LAST
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
