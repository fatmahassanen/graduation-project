<?php

use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\ContentBlockController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\RevisionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
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

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| All admin routes are prefixed with '/admin' and use the 'admin.' name prefix.
|
| Middleware Stack:
| - 'auth': Ensures user is authenticated (redirects to login if not)
| - 'role:super_admin,content_manager,faculty_admin': Ensures user has admin role (403 if not)
|
| Route Organization:
| - Dashboard: Admin landing page with statistics
| - Pages: CMS page management with publish/unpublish/archive actions
| - Events: Event management (create, edit, delete)
| - News: News article management with featured toggle
| - Media: Media library management (upload, view, delete)
| - Content Blocks: Reusable content blocks with reordering
| - Users: User account management (super_admin only)
| - System: Contact submissions, audit logs, and content revisions
|
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // ============================================================================
    // Authentication Routes
    // ============================================================================
    // Login routes use 'guest' middleware to redirect already-authenticated users
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
    });

    // ============================================================================
    // Authenticated Admin Routes
    // ============================================================================
    // All routes below require authentication and admin role
    Route::middleware(['auth', 'role:super_admin,content_manager,faculty_admin'])->group(function () {
        
        // ------------------------------------------------------------------------
        // Dashboard
        // ------------------------------------------------------------------------
        // Admin landing page showing summary statistics and quick actions
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Logout
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        // ------------------------------------------------------------------------
        // Pages
        // ------------------------------------------------------------------------
        // CMS page management with full CRUD operations
        // Additional actions: publish, unpublish, archive for workflow management
        Route::resource('pages', AdminPageController::class);
        Route::post('/pages/{page}/publish', [AdminPageController::class, 'publish'])->name('pages.publish');
        Route::post('/pages/{page}/unpublish', [AdminPageController::class, 'unpublish'])->name('pages.unpublish');
        Route::post('/pages/{page}/archive', [AdminPageController::class, 'archive'])->name('pages.archive');

        // ------------------------------------------------------------------------
        // Events
        // ------------------------------------------------------------------------
        // Event management with full CRUD operations
        Route::resource('events', AdminEventController::class);

        // ------------------------------------------------------------------------
        // News
        // ------------------------------------------------------------------------
        // News article management with full CRUD operations
        // Additional action: toggle-featured for homepage display
        Route::resource('news', AdminNewsController::class);
        Route::post('/news/{news}/toggle-featured', [AdminNewsController::class, 'toggleFeatured'])->name('news.toggle-featured');

        // ------------------------------------------------------------------------
        // Media
        // ------------------------------------------------------------------------
        // Media library management (upload, view, delete)
        // Note: No edit/update routes - media files are immutable after upload
        Route::resource('media', MediaController::class)->except(['edit', 'update']);

        // ------------------------------------------------------------------------
        // Content Blocks
        // ------------------------------------------------------------------------
        // Reusable content block management with full CRUD operations
        // Additional action: reorder for managing display sequence on pages
        Route::resource('content-blocks', ContentBlockController::class);
        Route::post('/pages/{page}/content-blocks/reorder', [ContentBlockController::class, 'reorder'])->name('content-blocks.reorder');

        // ------------------------------------------------------------------------
        // Users
        // ------------------------------------------------------------------------
        // User account management (super_admin only)
        // Manages admin users, content managers, and faculty admins
        Route::resource('users', UserController::class);

        // ------------------------------------------------------------------------
        // System - Contact Submissions
        // ------------------------------------------------------------------------
        // View and manage contact form submissions
        // Read-only with mark-as-read action for tracking
        Route::resource('contacts', AdminContactController::class)->only(['index', 'show', 'destroy']);
        Route::post('/contacts/{contact}/mark-as-read', [AdminContactController::class, 'markAsRead'])->name('contacts.mark-as-read');

        // ------------------------------------------------------------------------
        // System - Audit Logs
        // ------------------------------------------------------------------------
        // View audit trail of all admin actions
        // Read-only for compliance and security monitoring
        Route::resource('audit-logs', AuditLogController::class)->only(['index', 'show']);

        // ------------------------------------------------------------------------
        // System - Revisions
        // ------------------------------------------------------------------------
        // Content revision history and restoration
        // View, compare, and restore previous versions of content
        Route::get('/revisions', [RevisionController::class, 'index'])->name('revisions.index');
        Route::get('/revisions/{revision}', [RevisionController::class, 'show'])->name('revisions.show');
        Route::get('/revisions/compare', [RevisionController::class, 'compare'])->name('revisions.compare');
        Route::post('/revisions/{revision}/restore', [RevisionController::class, 'restore'])->name('revisions.restore');
    });
});

// Public page routes
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
