<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'showHome'])->name('home');

// Language switching route
Route::get('/language/{lang}', [LanguageController::class, 'switch'])->name('language.switch');

// Search route
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Contact form route
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Sitemap route
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Robots.txt route
Route::get('/robots.txt', function () {
    $content = "User-agent: *\n";
    $content .= "Allow: /\n";
    $content .= "Disallow: /admin/\n";
    $content .= "\n";
    $content .= "Sitemap: " . url('/sitemap.xml') . "\n";
    
    return response($content, 200)
        ->header('Content-Type', 'text/plain');
})->name('robots');

// Event routes
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}/export', [EventController::class, 'exportIcal'])->name('events.export');
Route::get('/events/export/all.ics', [EventController::class, 'exportAllIcal'])->name('events.export.all');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// News routes
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/rss', [NewsController::class, 'rss'])->name('news.rss');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// Public page routes
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
