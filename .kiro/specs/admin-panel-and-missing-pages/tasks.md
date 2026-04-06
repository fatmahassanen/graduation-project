# Implementation Plan: Admin Panel and Missing Pages

## Overview

This implementation adds 29 missing pages to the PageSeeder (bringing total from 25 to 54 pages) and creates a complete admin routing structure in routes/web.php to make existing admin controllers accessible. All admin routes will be protected with authentication and role-based authorization middleware.

## Tasks

- [x] 1. Update PageSeeder with 29 missing page definitions
  - Add page definitions for: president, dean1, dean2, dean3, campus, internal-protocols, external-protocols, reasons, competitions, graduates, digital-transformation, international-cooperation, quality, evaluation, women, faculty-health, how-apply, faculties-requirements, postgraduate-studies, fees, entrepreneur, activities, staff-lms, profile, members, student-booking, trainings, and contact
  - Ensure each page has correct title, slug, category, status='published', language='en', meta_title, meta_description, and published_at timestamp
  - Maintain existing 25 pages without modification
  - Use firstOrCreate to ensure idempotency
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 1.6, 6.1, 6.2, 6.3, 6.4_

- [ ]* 1.1 Write unit tests for PageSeeder
  - Test seeder creates exactly 54 pages for English language
  - Test seeder is idempotent (running twice creates 54 pages, not 108)
  - Test all required slugs are present
  - Test all pages have status='published' and published_at timestamp
  - Test all pages have created_by and updated_by set to super_admin
  - _Requirements: 1.1, 1.6, 6.1, 6.2, 6.3, 6.4_

- [x] 2. Create admin dashboard controller
  - Create app/Http/Controllers/Admin/DashboardController.php
  - Implement index method that displays summary statistics (page count, event count, news count, media count)
  - Return admin.dashboard view
  - _Requirements: 3.1, 3.3, 3.4_

- [x] 3. Create admin dashboard view
  - Create resources/views/admin/dashboard.blade.php
  - Display summary statistics cards
  - Include quick links to common admin tasks
  - Use existing admin layout if available, or create minimal layout
  - _Requirements: 3.3, 3.4_

- [x] 4. Add admin route group to routes/web.php
  - [x] 4.1 Create admin login routes with guest middleware
    - Add GET /admin/login route to LoginController@showLoginForm
    - Add POST /admin/login route to LoginController@login
    - Apply guest middleware to redirect authenticated users
    - Use route names: admin.login
    - _Requirements: 5.1, 5.2, 5.5_
  
  - [x] 4.2 Create authenticated admin route group
    - Add route prefix 'admin' with name prefix 'admin.'
    - Apply middleware: ['auth', 'role:super_admin,content_manager,faculty_admin']
    - Add comment explaining middleware stack
    - _Requirements: 2.1, 2.2, 2.3_
  
  - [x] 4.3 Add admin dashboard route
    - Add GET /admin route to DashboardController@index
    - Route name: admin.dashboard
    - _Requirements: 3.1, 3.2_
  
  - [x] 4.4 Add resource routes for all admin controllers
    - Add Route::resource for pages, events, news, media, content-blocks, users, contacts
    - Add Route::resource for audit-logs (only: ['index', 'show'])
    - Add Route::resource for revisions (only: ['index', 'show'])
    - Organize with comments by resource type
    - _Requirements: 2.4, 7.1, 7.3_
  
  - [x] 4.5 Add custom action routes for pages
    - Add POST /admin/pages/{page}/publish route to PageController@publish
    - Add POST /admin/pages/{page}/unpublish route to PageController@unpublish
    - Add POST /admin/pages/{page}/archive route to PageController@archive
    - Route names: admin.pages.publish, admin.pages.unpublish, admin.pages.archive
    - _Requirements: 4.1, 4.2, 4.3_
  
  - [x] 4.6 Add custom action routes for other resources
    - Add POST /admin/news/{news}/toggle-featured route to NewsController@toggleFeatured
    - Add POST /admin/content-blocks/reorder route to ContentBlockController@reorder
    - Add POST /admin/contacts/{contact}/mark-as-read route to ContactController@markAsRead
    - Add POST /admin/revisions/{revision}/restore route to RevisionController@restore
    - Add GET /admin/revisions/{revision}/compare route to RevisionController@compare
    - _Requirements: 2.4, 7.1, 7.3_

- [ ]* 4.7 Write route tests
  - Test admin routes require authentication (redirect to login)
  - Test admin routes require admin role (return 403 for non-admin)
  - Test all resource routes are registered
  - Test custom action routes are registered
  - Test route names follow convention (admin.{resource}.{action})
  - Test login routes use guest middleware
  - _Requirements: 2.5, 2.6, 5.4, 5.5_

- [x] 5. Update LoginController for admin redirect
  - Modify app/Http/Controllers/Auth/LoginController.php
  - Set redirectTo property or redirectPath method to return '/admin' for admin users
  - Ensure successful login redirects to admin dashboard
  - _Requirements: 5.3_

- [x] 6. Add route documentation comments
  - Add section comments in routes/web.php: Dashboard, Pages, Events, News, Media, Content Blocks, Users, System
  - Add comment explaining admin middleware stack at top of admin group
  - Ensure routing structure is clear and maintainable
  - _Requirements: 7.1, 7.2, 7.3, 7.4_

- [x] 7. Checkpoint - Run seeder and verify routes
  - Run `php artisan db:seed --class=PageSeeder` to create missing pages
  - Verify 54 pages exist in database
  - Run `php artisan route:list --path=admin` to verify all admin routes registered
  - Ensure all tests pass, ask the user if questions arise

- [ ]* 8. Write integration tests for admin access flow
  - Test complete login → dashboard → resource access flow
  - Test role-based access for different user types (super_admin, content_manager, faculty_admin)
  - Test unauthenticated access redirects to login
  - Test non-admin access returns 403
  - Test publish/unpublish/archive actions work for pages
  - _Requirements: 2.5, 2.6, 4.4, 4.5, 4.6, 5.3, 5.4_

- [x] 9. Final checkpoint - Verify complete functionality
  - Ensure all tests pass
  - Verify admin panel is accessible at /admin
  - Verify all 54 pages are created and accessible
  - Ask the user if questions arise

## Notes

- Tasks marked with `*` are optional and can be skipped for faster MVP
- Each task references specific requirements for traceability
- Checkpoints ensure incremental validation
- All admin controllers already exist, no controller modifications needed
- PageSeeder uses firstOrCreate for idempotency
- Admin routes follow Laravel resource routing conventions
