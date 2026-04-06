# Requirements Document

## Introduction

The NCTU CMS currently has two critical issues that prevent full functionality: (1) The PageSeeder only creates 25 pages but the system requires 54 pages as defined in CompleteNavigationPagesSeeder, leaving 29 pages missing from the database, and (2) Admin controllers exist for managing content but no admin routes are defined in routes/web.php, making the entire admin panel inaccessible. This feature addresses both issues by adding the missing pages to PageSeeder and creating a complete admin routing structure with proper authentication and authorization.

## Glossary

- **PageSeeder**: Database seeder class that creates initial page records in the database
- **CompleteNavigationPagesSeeder**: Database seeder that defines all 54 required pages with content blocks
- **Admin_Panel**: Web interface for authenticated administrators to manage CMS content
- **Admin_Routes**: URL routing definitions that map admin URLs to controller methods
- **Admin_Controllers**: Controller classes in app/Http/Controllers/Admin/ that handle admin operations
- **Route_Group**: Laravel routing feature that applies middleware and prefixes to multiple routes
- **Authentication_Middleware**: Middleware that verifies user is logged in before accessing routes
- **Authorization_Middleware**: Middleware that verifies user has required role/permissions
- **Resource_Routes**: Laravel routing pattern that creates standard CRUD routes for a controller

## Requirements

### Requirement 1: Complete Page Creation

**User Story:** As a system administrator, I want all 54 required pages created by PageSeeder, so that the navigation menu and content structure are complete.

#### Acceptance Criteria

1. THE PageSeeder SHALL create all 29 missing page records with correct slug, title, category, and metadata
2. WHEN PageSeeder runs, THE PageSeeder SHALL create pages for: president, dean1, dean2, dean3, campus, internal-protocols, external-protocols, reasons, competitions, graduates, digital-transformation, international-cooperation, quality, evaluation, women, faculty-health, how-apply, faculties-requirements, postgraduate-studies, fees, entrepreneur, activities, staff-lms, profile, members, student-booking, trainings, and contact
3. THE PageSeeder SHALL maintain all existing 25 pages without modification
4. FOR ALL created pages, THE PageSeeder SHALL set status to 'published' and published_at to current timestamp
5. FOR ALL created pages, THE PageSeeder SHALL assign created_by and updated_by to the super_admin user
6. WHEN PageSeeder completes, THE database SHALL contain exactly 54 pages for English language

### Requirement 2: Admin Route Structure

**User Story:** As a system administrator, I want admin routes defined in routes/web.php, so that I can access the admin panel to manage content.

#### Acceptance Criteria

1. THE routes/web.php file SHALL define an admin route group with '/admin' prefix
2. THE Admin_Route_Group SHALL apply 'auth' middleware to all admin routes
3. THE Admin_Route_Group SHALL apply 'role:super_admin,content_manager,faculty_admin' middleware to all admin routes
4. THE routes/web.php file SHALL define resource routes for pages, events, news, media, content-blocks, users, contacts, audit-logs, and revisions
5. WHEN an unauthenticated user accesses any admin route, THE system SHALL redirect to the login page
6. WHEN an authenticated user without admin role accesses any admin route, THE system SHALL return a 403 Forbidden response

### Requirement 3: Admin Dashboard Route

**User Story:** As an administrator, I want an admin dashboard route, so that I have a landing page after logging into the admin panel.

#### Acceptance Criteria

1. THE routes/web.php file SHALL define a route for '/admin' that maps to an admin dashboard view
2. THE Admin_Dashboard_Route SHALL apply 'auth' and role middleware
3. WHEN an authenticated admin accesses '/admin', THE system SHALL display the admin dashboard page
4. THE Admin_Dashboard SHALL show summary statistics for pages, events, news, and media

### Requirement 4: Additional Admin Action Routes

**User Story:** As a content manager, I want routes for publish, unpublish, and archive actions, so that I can manage content status without full editing.

#### Acceptance Criteria

1. THE routes/web.php file SHALL define POST routes for publishing pages: '/admin/pages/{page}/publish'
2. THE routes/web.php file SHALL define POST routes for unpublishing pages: '/admin/pages/{page}/unpublish'
3. THE routes/web.php file SHALL define POST routes for archiving pages: '/admin/pages/{page}/archive'
4. WHEN a content manager posts to a publish route, THE system SHALL update the page status to 'published'
5. WHEN a content manager posts to an unpublish route, THE system SHALL update the page status to 'draft'
6. WHEN a content manager posts to an archive route, THE system SHALL update the page status to 'archived'

### Requirement 5: Admin Login Route

**User Story:** As an administrator, I want a login route that redirects to the admin panel, so that I can access admin features after authentication.

#### Acceptance Criteria

1. THE routes/web.php file SHALL define a GET route for '/admin/login' that displays the login form
2. THE routes/web.php file SHALL define a POST route for '/admin/login' that processes login credentials
3. WHEN login is successful, THE system SHALL redirect authenticated users to '/admin'
4. WHEN login fails, THE system SHALL redirect back to login form with error message
5. IF user is already authenticated, WHEN accessing '/admin/login', THE system SHALL redirect to '/admin'

### Requirement 6: Page Seeder Idempotency

**User Story:** As a developer, I want PageSeeder to be idempotent, so that running it multiple times does not create duplicate pages.

#### Acceptance Criteria

1. THE PageSeeder SHALL use firstOrCreate method for all page creation
2. WHEN PageSeeder runs multiple times, THE database SHALL contain exactly 54 unique pages
3. THE PageSeeder SHALL match pages by slug and language combination
4. WHEN a page already exists, THE PageSeeder SHALL not modify its content or metadata

### Requirement 7: Admin Route Documentation

**User Story:** As a developer, I want admin routes organized with comments, so that the routing structure is clear and maintainable.

#### Acceptance Criteria

1. THE routes/web.php file SHALL include comments grouping admin routes by resource type
2. THE routes/web.php file SHALL include a comment explaining the admin middleware stack
3. THE Admin_Route_Group SHALL organize routes in logical sections: Dashboard, Pages, Events, News, Media, Content Blocks, Users, System
4. WHEN a developer reads routes/web.php, THE admin routing structure SHALL be immediately understandable
