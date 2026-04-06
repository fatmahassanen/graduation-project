# Design Document: Admin Panel and Missing Pages

## Overview

This feature addresses two critical infrastructure issues in the NCTU CMS: (1) completing the PageSeeder to create all 54 required pages instead of only 25, and (2) establishing the admin routing structure to make existing admin controllers accessible. The solution involves updating the PageSeeder with 29 missing page definitions and creating a comprehensive admin route group in routes/web.php with proper authentication and authorization middleware.

The design follows Laravel conventions for resource routing, middleware application, and database seeding. All admin routes will be protected by authentication middleware and role-based authorization, ensuring only authorized users can access admin functionality. The PageSeeder will use firstOrCreate to ensure idempotency, preventing duplicate pages on multiple runs.

## Architecture

### Component Structure

```
routes/
  └── web.php                    # Admin route definitions added here

database/seeders/
  └── PageSeeder.php             # Updated with 29 missing pages

app/Http/Controllers/Admin/     # Existing controllers (no changes)
  ├── PageController.php
  ├── EventController.php
  ├── NewsController.php
  ├── MediaController.php
  ├── ContentBlockController.php
  ├── UserController.php
  ├── ContactController.php
  ├── AuditLogController.php
  └── RevisionController.php

app/Http/Middleware/            # Existing middleware (no changes)
  ├── RoleMiddleware.php
  └── FacultyAdminMiddleware.php
```

### Route Organization

Admin routes will be organized in a single route group with the following structure:

```
/admin
  ├── / (dashboard)
  ├── /login (GET, POST)
  ├── /pages (resource routes + publish/unpublish/archive)
  ├── /events (resource routes)
  ├── /news (resource routes + toggle-featured)
  ├── /media (resource routes)
  ├── /content-blocks (resource routes + reorder)
  ├── /users (resource routes)
  ├── /contacts (resource routes + mark-as-read)
  ├── /audit-logs (index, show only)
  └── /revisions (index, show, compare, restore)
```

### Middleware Stack

All admin routes (except login) will apply:
1. `auth` - Ensures user is authenticated
2. `role:super_admin,content_manager,faculty_admin` - Ensures user has admin role

Login routes will use `guest` middleware to redirect authenticated users.

## Components and Interfaces

### 1. Admin Route Group

**Location:** `routes/web.php`

**Structure:**
```php
// Admin routes group
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes (guest middleware)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
    });

    // Authenticated admin routes
    Route::middleware(['auth', 'role:super_admin,content_manager,faculty_admin'])->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Resource routes
        Route::resource('pages', PageController::class);
        Route::resource('events', EventController::class);
        // ... etc
    });
});
```

**Responsibilities:**
- Define URL structure for admin panel
- Apply authentication and authorization middleware
- Map URLs to controller methods
- Provide named routes for URL generation

### 2. Updated PageSeeder

**Location:** `database/seeders/PageSeeder.php`

**Changes:**
- Add 29 missing page definitions to the `$pages` array
- Maintain existing 25 pages without modification
- Use `firstOrCreate` for idempotency
- Set all pages to 'published' status with current timestamp
- Assign created_by and updated_by to super_admin user

**Page Definitions to Add:**
```php
[
    'president', 'dean1', 'dean2', 'dean3', 'campus',
    'internal-protocols', 'external-protocols', 'reasons',
    'competitions', 'graduates', 'digital-transformation',
    'international-cooperation', 'quality', 'evaluation',
    'women', 'faculty-health', 'how-apply', 'faculties-requirements',
    'postgraduate-studies', 'fees', 'entrepreneur', 'activities',
    'staff-lms', 'profile', 'members', 'student-booking',
    'trainings', 'contact'
]
```

### 3. Admin Controllers (Existing)

**No modifications required** - All admin controllers already exist with proper methods:

- **PageController**: index, create, store, edit, update, destroy, publish, unpublish, archive
- **EventController**: index, create, store, edit, update, destroy
- **NewsController**: index, create, store, edit, update, destroy, toggleFeatured
- **MediaController**: index, create, store, show, destroy
- **ContentBlockController**: index, create, store, edit, update, destroy, reorder
- **UserController**: index, create, store, edit, update, destroy
- **ContactController**: index, show, markAsRead, destroy
- **AuditLogController**: index, show
- **RevisionController**: index, show, compare, restore

## Data Models

### Page Model Structure

Each page in PageSeeder will have:

```php
[
    'title' => string,           // Display title
    'slug' => string,            // URL-friendly identifier (unique per language)
    'category' => string,        // Page category (about, admissions, faculties, etc.)
    'status' => 'published',     // All new pages published
    'language' => 'en',          // English language
    'meta_title' => string,      // SEO title
    'meta_description' => string, // SEO description
    'published_at' => timestamp, // Current timestamp
    'created_by' => int,         // Super admin user ID
    'updated_by' => int,         // Super admin user ID
]
```

### Route Naming Convention

All admin routes follow the pattern: `admin.{resource}.{action}`

Examples:
- `admin.dashboard` → `/admin`
- `admin.pages.index` → `/admin/pages`
- `admin.pages.create` → `/admin/pages/create`
- `admin.pages.store` → `/admin/pages` (POST)
- `admin.pages.edit` → `/admin/pages/{page}/edit`
- `admin.pages.update` → `/admin/pages/{page}` (PUT/PATCH)
- `admin.pages.destroy` → `/admin/pages/{page}` (DELETE)
- `admin.pages.publish` → `/admin/pages/{page}/publish` (POST)

## Error Handling

### Authentication Errors

**Scenario:** Unauthenticated user accesses admin route

**Handling:**
- Laravel's `auth` middleware automatically redirects to login page
- Session stores intended URL for post-login redirect
- Flash message: "Please log in to access this page"

**Implementation:** Built into Laravel's authentication system

### Authorization Errors

**Scenario:** Authenticated user without admin role accesses admin route

**Handling:**
- `RoleMiddleware` returns 403 Forbidden response
- Error page displays: "You do not have permission to access this page"
- User remains on current page or redirected to home

**Implementation:** Existing `RoleMiddleware` handles this

### Seeder Errors

**Scenario:** PageSeeder runs without super_admin user

**Handling:**
```php
if (!$admin) {
    $this->command->warn('Super admin not found. Please run UserSeeder first.');
    return;
}
```

**Scenario:** Duplicate page creation attempt

**Handling:**
- `firstOrCreate` method prevents duplicates
- Matches on `['slug' => $slug, 'language' => $language]`
- Existing pages remain unchanged

### Route Errors

**Scenario:** Invalid resource ID in URL

**Handling:**
- Laravel's route model binding throws `ModelNotFoundException`
- Automatically converted to 404 response
- Error page displays: "Page not found"

**Scenario:** Invalid HTTP method

**Handling:**
- Laravel returns 405 Method Not Allowed
- Lists allowed methods in response header

## Testing Strategy

This feature involves infrastructure configuration (routes and database seeding) rather than business logic with testable properties. Property-based testing is not applicable. Testing will focus on:

### Unit Tests

**PageSeeder Tests:**
- Test seeder creates exactly 54 pages for English language
- Test seeder is idempotent (running twice creates 54 pages, not 108)
- Test all required slugs are present
- Test all pages have correct status ('published')
- Test all pages have published_at timestamp
- Test all pages have created_by and updated_by set to super_admin
- Test seeder handles missing super_admin gracefully

**Route Tests:**
- Test admin routes require authentication
- Test admin routes require admin role
- Test unauthenticated access redirects to login
- Test non-admin access returns 403
- Test all resource routes are registered
- Test custom action routes (publish, unpublish, archive) are registered
- Test route names follow convention
- Test login routes use guest middleware

### Integration Tests

**Admin Access Flow:**
- Test complete login → dashboard → resource access flow
- Test role-based access for different user types
- Test faculty_admin can only access their category pages
- Test super_admin can access all resources

**Page Creation Flow:**
- Test running UserSeeder then PageSeeder creates all pages
- Test pages are accessible via public routes
- Test pages can be edited via admin routes

### Manual Testing Checklist

**Admin Routes:**
- [ ] Access /admin without login redirects to /admin/login
- [ ] Login with admin credentials redirects to /admin
- [ ] All resource index pages load correctly
- [ ] Create, edit, delete operations work for each resource
- [ ] Publish/unpublish/archive actions work for pages
- [ ] Non-admin user gets 403 on admin routes

**PageSeeder:**
- [ ] Run `php artisan db:seed --class=PageSeeder`
- [ ] Verify 54 pages exist in database
- [ ] Run seeder again, verify still 54 pages (no duplicates)
- [ ] Check all new page slugs are present
- [ ] Verify all pages have status='published'
- [ ] Verify all pages have published_at timestamp

### Test Data

**Test Users:**
- Super admin: full access to all admin routes
- Content manager: access to content routes (pages, events, news, media, content-blocks)
- Faculty admin: access to pages in their assigned category only
- Regular user: no access to admin routes

**Test Pages:**
- Verify presence of all 29 new slugs
- Verify existing 25 pages remain unchanged
- Test pages across different categories

## Implementation Notes

### Route Definition Order

Routes must be defined in specific order to prevent conflicts:

1. Login routes (most specific)
2. Custom action routes (publish, unpublish, archive)
3. Resource routes (catch-all patterns)
4. Dashboard route (least specific)

### PageSeeder Data Source

Page definitions should match CompleteNavigationPagesSeeder structure but simplified:
- Include only essential fields (title, slug, category, meta fields)
- Omit content blocks (handled by CompleteNavigationPagesSeeder)
- Focus on creating page records for navigation

### Middleware Application

The middleware stack applies in order:
1. Global middleware (web, session, CSRF)
2. Route group middleware (auth, role)
3. Controller middleware (if any)
4. Policy authorization (in controller methods)

### Dashboard Controller

A new DashboardController will need to be created to handle the `/admin` route:

**Location:** `app/Http/Controllers/Admin/DashboardController.php`

**Responsibilities:**
- Display summary statistics (page count, event count, news count, media count)
- Show recent activity
- Provide quick links to common admin tasks

### Login Controller

The existing `LoginController` at `app/Http/Controllers/Auth/LoginController.php` will be used for admin login. It may need configuration to:
- Redirect authenticated users to `/admin` instead of `/home`
- Customize login view for admin panel branding

## Security Considerations

### Authentication

- All admin routes protected by `auth` middleware
- Session-based authentication using Laravel's built-in system
- CSRF protection on all POST/PUT/PATCH/DELETE requests

### Authorization

- Role-based access control via `RoleMiddleware`
- Three admin roles: super_admin, content_manager, faculty_admin
- Policy-based authorization in controllers for fine-grained control
- Faculty admins restricted to their assigned category

### Input Validation

- All form requests use existing validation classes
- PageRequest, EventRequest, NewsRequest, etc. validate input
- Sanitization handled by ContentSanitizer service

### SQL Injection Prevention

- Eloquent ORM used throughout (no raw SQL)
- Query builder with parameter binding
- firstOrCreate uses parameterized queries

### XSS Prevention

- Blade template engine auto-escapes output
- Content sanitization for rich text fields
- CSP headers via SecurityHeadersMiddleware

## Performance Considerations

### Route Caching

- Admin routes can be cached with `php artisan route:cache`
- Named routes improve performance
- Route model binding reduces database queries

### Seeder Performance

- PageSeeder creates 54 pages in single run
- firstOrCreate performs one query per page (54 queries)
- Acceptable for one-time seeding operation
- Could be optimized with bulk insert if needed

### Database Indexing

- Existing indexes on pages table:
  - `slug` and `language` (composite unique index)
  - `status` (for filtering)
  - `category` (for faculty admin filtering)

## Deployment Considerations

### Migration Steps

1. Pull latest code with updated routes/web.php and PageSeeder.php
2. Run `php artisan route:clear` to clear route cache
3. Run `php artisan db:seed --class=PageSeeder` to create missing pages
4. Run `php artisan route:cache` to cache new routes
5. Verify admin panel is accessible at /admin

### Rollback Plan

If issues occur:
1. Revert code changes to routes/web.php
2. Run `php artisan route:clear`
3. Delete newly created pages: `DELETE FROM pages WHERE slug IN ('president', 'dean1', ...)`
4. Run `php artisan route:cache`

### Environment Configuration

No environment-specific configuration required. Routes and seeder work identically across dev, test, and production environments.

## Future Enhancements

### Admin Dashboard

- Add charts and graphs for statistics
- Show recent user activity
- Display system health metrics
- Quick actions for common tasks

### Page Management

- Bulk operations (publish multiple pages)
- Page templates for consistent structure
- Page duplication feature
- Advanced search and filtering

### Audit Trail

- Log all admin actions
- Track who accessed what and when
- Export audit logs for compliance

### API Routes

- RESTful API for admin operations
- Token-based authentication
- Rate limiting for API endpoints
