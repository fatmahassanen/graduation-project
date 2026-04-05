# Implementation Plan: University CMS Upgrade

## Overview

This implementation plan transforms a static 70+ page university website into a dynamic Laravel 13.x CMS application. The approach follows a layered architecture: database schema first, then models and services, followed by admin panel functionality, frontend rendering, and finally optimization and testing. Each task builds incrementally to ensure the system remains functional throughout development.

## Tasks

- [x] 1. Set up database schema and migrations
  - Create all database tables following the design schema
  - Set up indexes, foreign keys, and constraints
  - Create database seeders for initial admin user and test data
  - _Requirements: 1.1, 2.2, 3.2, 4.2, 5.1, 7.7, 8.2, 13.1, 14.1, 15.4, 16.9, 17.1, 18.1_

- [x] 2. Create Eloquent models with relationships
  - [x] 2.1 Implement Page model with relationships and scopes
    - Define fillable fields, casts, and timestamps
    - Add relationships: contentBlocks, creator, updater, revisions
    - Add scopes: published, byLanguage, byCategory
    - _Requirements: 1.1, 1.5, 1.6, 1.7, 1.8_
  
  - [x] 2.2 Implement ContentBlock model with polymorphic relationships
    - Define fillable fields and JSON casting for content
    - Add relationships: page, creator, revisions
    - _Requirements: 2.1, 2.2, 2.6_
  
  - [x] 2.3 Implement Revision model with polymorphic relationships
    - Define fillable fields and JSON casting for old_values/new_values
    - Add relationship to User model
    - _Requirements: 3.2, 3.5_
  
  - [x] 2.4 Implement Media, Event, News, ContactSubmission, AuditLog models
    - Create Media model with file metadata fields
    - Create Event model with date fields and recurrence support
    - Create News model with fulltext search support
    - Create ContactSubmission model with read tracking
    - Create AuditLog model with polymorphic relationships
    - _Requirements: 7.7, 13.1, 14.1, 15.4, 8.2_
  
  - [x] 2.5 Update User model with role and faculty_category fields
    - Add role enum field with super_admin, content_editor, faculty_admin
    - Add faculty_category field for faculty_admin role
    - Add failed_login_attempts and locked_until fields
    - _Requirements: 5.1, 5.3, 6.9_

- [x] 3. Implement core service layer
  - [x] 3.1 Create PageService with CRUD operations
    - Implement getPublishedPageBySlug with caching
    - Implement createPage, updatePage with revision tracking
    - Implement publishPage, unpublishPage, archivePage
    - Implement generateUniqueSlug with numeric suffix logic
    - _Requirements: 1.3, 1.4, 1.5, 1.7, 9.1, 9.7, 9.8_
  
  - [x] 3.2 Write property tests for PageService
    - **Property 1: Slug Generation Validity**
    - **Validates: Requirements 1.3**
    - **Property 2: Slug Uniqueness with Suffixes**
    - **Validates: Requirements 1.4**
    - **Property 4: Page Serialization Round-Trip**
    - **Validates: Requirements 1.9**
    - **Property 12: Slug-Language Uniqueness**
    - **Validates: Requirements 4.3**
  
  - [x] 3.3 Create ContentBlockService with validation
    - Implement createBlock, updateBlock, deleteBlock
    - Implement reorderBlocks for display_order management
    - Implement validateBlockContent with JSON schema validation
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5_
  
  - [x] 3.4 Write property tests for ContentBlockService
    - **Property 3: Content Block Display Ordering**
    - **Validates: Requirements 1.7, 2.3**
    - **Property 5: Content Block JSON Schema Validation**
    - **Validates: Requirements 2.4**
    - **Property 7: Content Block Serialization Round-Trip**
    - **Validates: Requirements 2.9**
    - **Property 6: Reusable Block Update Propagation**
    - **Validates: Requirements 2.7**
  
  - [x] 3.4 Create RevisionService for version tracking
    - Implement createRevision capturing old/new values
    - Implement getRevisionHistory ordered by timestamp
    - Implement restoreRevision with new revision creation
    - Implement compareRevisions for diff view
    - _Requirements: 3.1, 3.3, 3.4, 3.5, 3.6, 3.7, 3.8, 3.9_
  
  - [x] 3.5 Write property tests for RevisionService
    - **Property 8: Revision Creation on Changes**
    - **Validates: Requirements 3.1**
    - **Property 9: Revision Change Tracking**
    - **Validates: Requirements 3.3, 3.4**
    - **Property 10: Revision Restoration Correctness**
    - **Validates: Requirements 3.7**
    - **Property 11: Revision Creation on Restore**
    - **Validates: Requirements 3.8**
  
  - [x] 3.6 Create MediaService for file management
    - Implement uploadFile with validation and unique filename generation
    - Implement deleteFile with reference checking
    - Implement isFileReferenced to prevent deletion of used media
    - Implement searchMedia with filters
    - _Requirements: 7.2, 7.3, 7.4, 7.5, 7.6, 7.8, 7.9, 7.10_
  
  - [x] 3.7 Write property tests for MediaService
    - **Property 18: File Upload Validation**
    - **Validates: Requirements 7.3**
    - **Property 19: Unique Filename Generation**
    - **Validates: Requirements 7.6**
    - **Property 21: Media Reference Integrity**
    - **Validates: Requirements 7.10**

- [x] 4. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [x] 5. Implement authentication and authorization
  - [x] 5.1 Create Laravel Policies for Page, ContentBlock, Media models
    - Implement PagePolicy with role-based permissions
    - Implement faculty_admin scope restrictions
    - Implement content_editor publish restrictions
    - _Requirements: 5.4, 5.5, 5.6, 5.7, 5.8_
  
  - [x] 5.2 Create RoleMiddleware and FacultyAdminMiddleware
    - Implement role checking middleware
    - Implement faculty category scope enforcement
    - _Requirements: 5.6, 5.7, 5.9_
  
  - [x] 5.3 Implement account lockout logic in LoginController
    - Track failed_login_attempts on User model
    - Lock account for 15 minutes after 5 failed attempts
    - _Requirements: 6.9_
  
  - [x] 5.4 Write property tests for authorization
    - **Property 13: Super Admin Permission Completeness**
    - **Validates: Requirements 5.4**
    - **Property 14: Content Editor Permission Restrictions**
    - **Validates: Requirements 5.5**
    - **Property 15: Faculty Admin Scope Enforcement**
    - **Validates: Requirements 5.6**
    - **Property 16: Admin Route Authentication Requirement**
    - **Validates: Requirements 5.9**
    - **Property 17: CSRF Protection on Admin Forms**
    - **Validates: Requirements 6.4**
    - **Property 20: Media Ownership Deletion Rights**
    - **Validates: Requirements 7.9**

- [x] 6. Create Form Request validation classes
  - Create PageRequest with validation rules for page fields
  - Create ContentBlockRequest with JSON schema validation
  - Create MediaUploadRequest with file type and size validation
  - Create EventRequest and NewsRequest with date validation
  - _Requirements: 1.1, 2.4, 2.5, 7.3, 7.4, 13.1, 14.1_

- [x] 7. Implement admin panel controllers
  - [x] 7.1 Create Admin\PageController with CRUD operations
    - Implement index, create, store, edit, update, destroy
    - Implement publish, unpublish, archive actions
    - Integrate PageService and RevisionService
    - _Requirements: 1.1, 1.5, 9.1, 9.3, 9.7, 9.8_
  
  - [x] 7.2 Create Admin\ContentBlockController
    - Implement CRUD operations for content blocks
    - Implement reorder action for display_order
    - Integrate ContentBlockService
    - _Requirements: 2.1, 2.2, 2.3_
  
  - [x] 7.3 Create Admin\MediaController with upload and browser
    - Implement upload action with validation
    - Implement index with search and filters
    - Implement destroy with reference checking
    - _Requirements: 7.1, 7.2, 7.3, 7.8, 7.9, 7.10_
  
  - [x] 7.4 Create Admin\UserController for user management
    - Implement CRUD operations (Super_Admin only)
    - Implement role assignment
    - _Requirements: 5.1, 5.3, 5.4_
  
  - [x] 7.5 Create Admin\EventController and Admin\NewsController
    - Implement CRUD operations for events
    - Implement CRUD operations for news articles
    - Implement featured news toggle
    - _Requirements: 13.1, 13.2, 13.4, 14.1, 14.2, 14.4, 14.7_
  
  - [x] 7.6 Create Admin\AuditLogController and Admin\RevisionController
    - Implement audit log viewer with filters
    - Implement revision history viewer
    - Implement revision comparison and restore
    - _Requirements: 3.6, 3.7, 3.8, 3.9, 8.4, 8.5, 8.6, 8.9_
  
  - [x] 7.7 Create Admin\ContactController for contact submissions
    - Implement index view for submissions
    - Implement mark as read action
    - _Requirements: 15.8, 15.9_

- [x] 8. Create admin panel Blade views
  - [x] 8.1 Create admin layout and dashboard
    - Create resources/views/admin/layouts/app.blade.php
    - Create resources/views/admin/dashboard.blade.php with statistics
    - Include navigation sidebar with role-based menu items
    - _Requirements: 6.1, 6.5, 6.6_
  
  - [x] 8.2 Create admin page management views
    - Create resources/views/admin/pages/index.blade.php with filters
    - Create resources/views/admin/pages/create.blade.php
    - Create resources/views/admin/pages/edit.blade.php with content block builder
    - Integrate WYSIWYG editor (TinyMCE or CKEditor)
    - _Requirements: 1.1, 1.2, 9.3, 9.4, 10.1, 10.2_
  
  - [x] 8.3 Create admin content block management views
    - Create resources/views/admin/content-blocks/create.blade.php
    - Create resources/views/admin/content-blocks/edit.blade.php
    - Implement dynamic form fields based on block type
    - _Requirements: 2.1, 2.2_
  
  - [x] 8.4 Create admin media library views
    - Create resources/views/admin/media/index.blade.php with grid layout
    - Create resources/views/admin/media/upload.blade.php
    - Implement media browser modal for WYSIWYG integration
    - _Requirements: 7.1, 7.8, 10.3_
  
  - [x] 8.5 Create admin event and news management views
    - Create resources/views/admin/events/index.blade.php
    - Create resources/views/admin/events/create.blade.php with date picker
    - Create resources/views/admin/news/index.blade.php
    - Create resources/views/admin/news/create.blade.php
    - _Requirements: 13.1, 13.4, 14.1, 14.4_
  
  - [x] 8.6 Create admin audit log and revision views
    - Create resources/views/admin/audit-logs/index.blade.php with filters
    - Create resources/views/admin/revisions/index.blade.php
    - Create resources/views/admin/revisions/compare.blade.php with diff view
    - _Requirements: 3.6, 3.9, 8.4, 8.9_

- [x] 9. Checkpoint - Test admin panel functionality
  - Ensure all tests pass, ask the user if questions arise.

- [x] 10. Create reusable Blade components for frontend
  - [x] 10.1 Create Navbar component with active link highlighting
    - Create app/View/Components/Navbar.php
    - Create resources/views/components/navbar.blade.php
    - Implement menu structure from static HTML
    - Implement language switcher
    - _Requirements: 11.1, 12.1, 12.7, 4.4_
  
  - [x] 10.2 Create Footer component
    - Create app/View/Components/Footer.php
    - Create resources/views/components/footer.blade.php
    - Preserve gallery images and social media links
    - _Requirements: 11.2, 12.8_
  
  - [x] 10.3 Create content block components
    - Create Hero, CardGrid, VideoSection, FaqSection components
    - Create TestimonialCarousel, GalleryGrid, ContactForm components
    - Preserve all CSS classes and Bootstrap structure
    - _Requirements: 11.3, 12.2, 12.3, 12.4, 12.5, 12.6_
  
  - [x] 10.4 Write property tests for Blade components
    - **Property 27: Blade Component HTML Validity**
    - **Validates: Requirements 11.9**
    - **Property 28: Component Type Selection**
    - **Validates: Requirements 12.2**
    - **Property 29: Active Navigation Link Highlighting**
    - **Validates: Requirements 12.7**

- [x] 11. Create master layout and page rendering
  - [x] 11.1 Create master layout template
    - Create resources/views/layouts/app.blade.php
    - Include CSS files: bootstrap.min.css, style.css
    - Include JavaScript libraries: jQuery, Bootstrap, WOW.js, Owl Carousel
    - Implement SEO meta tags section
    - _Requirements: 11.4, 12.4, 12.5, 17.3_
  
  - [x] 11.2 Create PageController for public pages
    - Implement show method with slug and language parameters
    - Integrate PageService with caching
    - Eager load contentBlocks and media relationships
    - _Requirements: 1.7, 12.1, 18.3, 18.4_
  
  - [x] 11.3 Create page show view with dynamic content block rendering
    - Create resources/views/pages/show.blade.php
    - Loop through content blocks and render appropriate components
    - _Requirements: 12.1, 12.2_
  
  - [x] 11.4 Create 404 error page with university branding
    - Create resources/views/errors/404.blade.php
    - Preserve Bootstrap styling
    - _Requirements: 12.9_
  
  - [x] 11.5 Write property tests for page rendering
    - **Property 24: Published Content Filtering**
    - **Validates: Requirements 9.6, 9.9, 16.8**

- [x] 12. Implement search functionality
  - [x] 12.1 Create SearchService with fulltext search
    - Implement search across pages, news, events
    - Implement relevance scoring
    - Implement filters: category, language, content type
    - Implement search query logging
    - _Requirements: 16.1, 16.2, 16.3, 16.5, 16.6, 16.8, 16.9_
  
  - [x] 12.2 Create SearchController
    - Implement search action with query and filters
    - Integrate SearchService
    - _Requirements: 16.1, 16.2_
  
  - [x] 12.3 Create search results view
    - Create resources/views/search/results.blade.php
    - Display results with highlighted search terms
    - Display filters and "no results" message
    - _Requirements: 16.3, 16.4, 16.7_
  
  - [x] 12.4 Write property tests for search
    - **Property 30: Search Query Matching and Filtering**
    - **Validates: Requirements 16.2, 16.6, 16.8**
    - **Property 31: Search Results Relevance Ordering**
    - **Validates: Requirements 16.5**
    - **Property 32: Search Query Logging**
    - **Validates: Requirements 16.9**

- [x] 13. Implement contact form functionality
  - [x] 13.1 Create ContactController with store method
    - Implement form validation
    - Store submission in contact_submissions table
    - Send email notification
    - Implement reCAPTCHA validation
    - _Requirements: 15.1, 15.2, 15.3, 15.4, 15.5, 15.6, 15.7_
  
  - [x] 13.2 Create contact form Blade component
    - Create resources/views/components/contact-form.blade.php
    - Implement client-side validation
    - Display success/error messages
    - _Requirements: 15.1, 15.3, 15.6_

- [x] 14. Implement content versioning and audit logging
  - [x] 14.1 Create AuditLog observer for models
    - Attach observer to Page, ContentBlock, Media, User models
    - Capture created, updated, deleted events
    - Store old_values and new_values as JSON
    - Capture IP address and user agent
    - _Requirements: 8.1, 8.2, 8.3, 8.8_
  
  - [x] 14.2 Integrate RevisionService into PageService and ContentBlockService
    - Call createRevision on every update
    - Call createRevision on restore operations
    - _Requirements: 3.1, 3.8_
  
  - [x] 14.3 Write property tests for audit logging
    - **Property 22: Audit Log Creation on Actions**
    - **Validates: Requirements 8.1**
    - **Property 23: Audit Log Chronological Ordering**
    - **Validates: Requirements 8.6**

- [x] 15. Checkpoint - Test core functionality
  - Ensure all tests pass, ask the user if questions arise.

- [x] 16. Implement SEO and sitemap generation
  - [x] 16.1 Add SEO metadata fields to page forms
    - Add meta_title, meta_description, meta_keywords, og_image fields
    - Implement character counter for meta_description
    - _Requirements: 17.1, 17.2, 17.9_
  
  - [x] 16.2 Create SitemapController for sitemap.xml generation
    - Generate sitemap from published pages
    - Include lastmod, changefreq, priority
    - Cache sitemap for 1 hour
    - _Requirements: 17.5, 17.6_
  
  - [x] 16.3 Update master layout with SEO meta tags
    - Render meta_title, meta_description, meta_keywords
    - Render Open Graph tags
    - Render canonical URL
    - _Requirements: 17.3, 17.4, 17.8_
  
  - [x] 16.4 Create robots.txt route
    - Generate robots.txt with sitemap reference
    - _Requirements: 17.7_

- [x] 17. Implement caching and performance optimization
  - [x] 17.1 Create CacheService for cache management
    - Implement page caching with 1 hour TTL
    - Implement cache invalidation on content update
    - Implement fragment caching for reusable blocks
    - _Requirements: 18.1, 18.2_
  
  - [x] 17.2 Integrate caching into PageService
    - Wrap getPublishedPageBySlug with cache
    - Invalidate cache on updatePage, publishPage, unpublishPage
    - _Requirements: 18.1, 18.2_
  
  - [x] 17.3 Implement image optimization in MediaService
    - Compress images on upload (80% quality)
    - Generate WebP versions for modern browsers
    - _Requirements: 18.5, 18.6_
  
  - [x] 17.4 Implement lazy loading for images
    - Add loading="lazy" attribute to img tags in components
    - _Requirements: 18.8_
  
  - [x] 17.5 Write property tests for caching
    - **Property 33: Cache Invalidation on Content Update**
    - **Validates: Requirements 18.2**
    - **Property 34: Image Compression on Upload**
    - **Validates: Requirements 18.5**

- [x] 18. Implement HTML sanitization and security
  - [x] 18.1 Create ContentSanitizer service
    - Integrate HTML Purifier
    - Configure allowed HTML tags and attributes
    - Remove dangerous tags and event handlers
    - _Requirements: 10.4, 10.5_
  
  - [x] 18.2 Integrate ContentSanitizer into ContentBlockService
    - Sanitize HTML content before saving
    - _Requirements: 10.4_
  
  - [x] 18.3 Add security headers middleware
    - Add X-Frame-Options, X-Content-Type-Options headers
    - Add Content-Security-Policy header
    - _Requirements: 6.4_
  
  - [x] 18.4 Write property tests for HTML sanitization
    - **Property 25: HTML Sanitization Security**
    - **Validates: Requirements 10.4**
    - **Property 26: HTML Formatting Preservation**
    - **Validates: Requirements 10.6**

- [x] 19. Create static file migration command
  - [x] 19.1 Create MigrationService for parsing static HTML
    - Implement parseHtmlFile to extract metadata
    - Implement identifyContentSections using DOM parsing
    - Implement extractMediaFiles to copy to storage
    - _Requirements: 19.1, 19.2, 19.3, 19.7_
  
  - [x] 19.2 Create Artisan command cms:migrate-static-files
    - Loop through old_files/ directory
    - Call MigrationService for each HTML file
    - Create Page and ContentBlock records
    - Generate slugs from filenames
    - Output migration summary report
    - _Requirements: 19.1, 19.4, 19.5, 19.6, 19.8, 19.9_

- [x] 20. Implement event calendar and news feed
  - [x] 20.1 Create EventService with calendar logic
    - Implement getUpcomingEvents ordered by start_date
    - Implement getPastEvents
    - Implement recurring event generation
    - Implement iCalendar export
    - _Requirements: 13.2, 13.3, 13.7, 13.8, 13.9_
  
  - [x] 20.2 Create NewsService with feed logic
    - Implement getPublishedNews ordered by published_at
    - Implement getRelatedNews by category
    - Implement getFeaturedNews
    - Implement RSS feed generation
    - _Requirements: 14.2, 14.6, 14.7, 14.9_
  
  - [x] 20.3 Create EventController and NewsController for public pages
    - Implement index and show methods
    - Implement category filtering
    - _Requirements: 13.2, 13.4, 13.5, 14.2, 14.4, 14.5_
  
  - [x] 20.4 Create event and news views
    - Create resources/views/events/index.blade.php
    - Create resources/views/events/show.blade.php
    - Create resources/views/news/index.blade.php
    - Create resources/views/news/show.blade.php
    - _Requirements: 13.2, 13.6, 14.2, 14.5_

- [x] 21. Implement multi-language support
  - [x] 21.1 Create language switcher in Navbar component
    - Display available languages (en, ar)
    - Link to translated pages
    - _Requirements: 4.4, 4.5, 4.9_
  
  - [x] 21.2 Implement language detection and fallback
    - Detect language from URL or session
    - Display "translation not available" message if missing
    - _Requirements: 4.5, 4.6_
  
  - [x] 21.3 Add RTL support for Arabic content
    - Add dir="rtl" attribute for Arabic pages
    - Adjust CSS for RTL layout
    - _Requirements: 10.7_

- [x] 22. Create database seeders for testing
  - Create PageSeeder with sample pages in all categories
  - Create UserSeeder with all three roles
  - Create MediaSeeder with sample images
  - Create EventSeeder and NewsSeeder with sample data
  - _Requirements: 20.2_

- [x] 23. Configure environment-aware settings
  - [x] 23.1 Update .env.example with all required variables
    - Document database, cache, queue, mail settings
    - _Requirements: 20.1, 20.2, 20.6, 20.7_
  
  - [x] 23.2 Configure cache drivers based on environment
    - Use Redis in production, file in development
    - _Requirements: 20.6_
  
  - [x] 23.3 Configure error handling based on environment
    - Detailed errors in development, generic in production
    - _Requirements: 20.3, 20.4, 20.5_
  
  - [x] 23.4 Configure asset compilation with Vite
    - Hot reload in development, minified in production
    - _Requirements: 20.8_

- [x] 24. Write integration tests for key workflows
  - [x] 24.1 Write integration test for page creation workflow
    - Test creating page with content blocks
    - Test revision creation
    - Test audit log creation
  
  - [x] 24.2 Write integration test for media upload workflow
    - Test file upload with validation
    - Test media reference in content blocks
    - Test deletion prevention for referenced media
  
  - [x] 24.3 Write integration test for publish workflow
    - Test draft to published transition
    - Test cache invalidation
    - Test public visibility
  
  - [x] 24.4 Write integration test for search workflow
    - Test search across multiple content types
    - Test filtering and relevance ordering
    - Test search query logging

- [x] 25. Final checkpoint - Comprehensive testing
  - Run all unit tests, property tests, and integration tests
  - Test admin panel functionality manually
  - Test public website rendering
  - Test performance with sample data
  - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for faster MVP
- Each task references specific requirements for traceability
- Checkpoints ensure incremental validation at key milestones
- Property tests validate universal correctness properties from the design document
- Integration tests validate end-to-end workflows
- The implementation follows Laravel best practices: Eloquent ORM, service layer pattern, Blade components
- All code should be environment-aware (dev/test/prod)
- No raw SQL - use Eloquent exclusively
- Preserve existing Bootstrap styling and JavaScript functionality
