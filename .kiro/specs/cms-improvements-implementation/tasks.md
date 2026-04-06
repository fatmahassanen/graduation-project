# Implementation Plan: CMS Improvements Implementation

## Overview

This implementation addresses 13 requirements for improving the NCTU Graduation Project Laravel CMS. The work includes database seeder orchestration, featured image support for events and news, gallery enhancements with lightbox functionality, calendar integration improvements, staff portal enhancements, SQLite compatibility fixes, view template updates, and debug message removal.

The implementation follows Laravel best practices with separation of concerns: migrations for schema changes, seeders for data population, models for business logic, and Blade templates for presentation.

## Tasks

- [x] 1. Create database migrations for featured images
  - [x] 1.1 Create migration to add featured_image column to events table
    - Add nullable string column `featured_image` after `image_id` column
    - _Requirements: 2.1_
  
  - [x] 1.2 Create migration to add featured_image column to news table
    - Add nullable string column `featured_image` after `featured_image_id` column
    - _Requirements: 3.1_
  
  - [x] 1.3 Update existing content_blocks migration for SQLite compatibility
    - Add database driver detection to skip MODIFY COLUMN on SQLite
    - Log warning message when skipping SQLite-incompatible operations
    - _Requirements: 9.1, 9.2, 9.3, 9.4_

- [x] 2. Update Event and News models to support featured images
  - [x] 2.1 Update Event model with featured_image support
    - Add `featured_image` to fillable array
    - Add `featured_image` string cast to casts method
    - _Requirements: 12.1, 12.3_
  
  - [x] 2.2 Update News model with featured_image support
    - Add `featured_image` to fillable array
    - Add `featured_image` string cast to casts method
    - _Requirements: 12.2, 12.4_

- [x] 3. Create and update database seeders
  - [x] 3.1 Update DatabaseSeeder to orchestrate all content seeders
    - Call HomePageContentSeeder, AllPagesContentSeeder, CompleteNavigationPagesSeeder
    - Call GalleryContentSeeder and StaffPagesContentSeeder
    - Ensure execution order: UserSeeder, MediaSeeder, PageSeeder, then content seeders, then EventSeeder and NewsSeeder
    - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 1.6_
  
  - [x] 3.2 Create GalleryContentSeeder with 18 image content blocks
    - Create helper method to generate gallery blocks with title, description, and image path
    - Create 18 image content blocks for gallery page with proper display_order
    - Include error handling for missing gallery page
    - _Requirements: 6.1, 10.4_
  
  - [x] 3.3 Create StaffPagesContentSeeder for enhanced staff portal
    - Create profile page content with hero section and 6 service cards
    - Create staff-lms page content with login form, features list, and quick links
    - Service cards: Staff Portal, Update Profile, Academic Resources, Research Portal, HR Services, Support
    - _Requirements: 8.1, 8.2, 8.3, 8.4, 8.5, 10.5_
  
  - [x] 3.4 Update EventSeeder to assign featured_image paths
    - Assign image paths from public/img/Events/ directory to all events
    - Use firstOrCreate to prevent duplicates
    - _Requirements: 2.2_
  
  - [x] 3.5 Update NewsSeeder to assign featured_image paths
    - Assign image paths to all news articles
    - Use firstOrCreate to prevent duplicates
    - _Requirements: 3.2_

- [x] 4. Checkpoint - Run migrations and seeders
  - Ensure migrations run successfully on both MySQL and SQLite
  - Ensure all seeders execute without errors
  - Verify 18 gallery images, enhanced staff pages, and featured images are created
  - Ask the user if questions arise

- [x] 5. Update event view templates for featured images and calendar integration
  - [x] 5.1 Update events/index.blade.php for featured images
    - Add image display logic: check featured_image, then image relationship, then default
    - Use asset() helper for featured_image and default images
    - _Requirements: 2.3, 2.4, 2.5, 13.1, 13.5_
  
  - [x] 5.2 Update events/show.blade.php for featured images
    - Add same image display logic as index view
    - _Requirements: 2.3, 2.4, 2.5, 13.2, 13.5_
  
  - [x] 5.3 Add calendar integration dropdown to events/show.blade.php
    - Create dropdown with Google Calendar, Outlook, and ICS download options
    - Add explanatory text for ICS file option
    - Generate proper calendar URLs with event details
    - _Requirements: 7.1, 7.2, 7.3, 7.4, 7.5_
  
  - [x] 5.4 Add calendar integration dropdown to events/index.blade.php
    - Add same calendar dropdown as show view for each event card
    - _Requirements: 7.1, 7.2, 7.3, 7.4, 7.5_

- [x] 6. Update news view templates for featured images
  - [x] 6.1 Update news/index.blade.php for featured images
    - Add image display logic: check featured_image, then featuredImage relationship, then default
    - Use asset() helper for featured_image and default images
    - _Requirements: 3.3, 3.4, 3.5, 13.3, 13.5_
  
  - [x] 6.2 Update news/show.blade.php for featured images
    - Add same image display logic as index view
    - _Requirements: 3.3, 3.4, 3.5, 13.4, 13.5_

- [x] 7. Update navbar component to fix logo display
  - [x] 7.1 Update navbar.blade.php logo path
    - Change logo path from 'uni/img.png' to 'img/logo.png'
    - Ensure alt text is present for accessibility
    - _Requirements: 4.1, 4.2, 4.3_

- [x] 8. Remove debug messages from page view
  - [x] 8.1 Remove debug output from pages/show.blade.php
    - Remove debug block displaying page title, block count, and block types
    - _Requirements: 5.1, 5.2, 5.3_

- [x] 9. Enhance gallery component with lightbox functionality
  - [x] 9.1 Update gallery-grid.blade.php component
    - Add hover overlay with title and description
    - Add click handler to open lightbox modal
    - Create lightbox modal structure with close button, image, title, and description
    - Add responsive grid layout with CSS
    - Add JavaScript for lightbox open/close functionality
    - _Requirements: 6.2, 6.3, 6.4, 6.5_

- [x] 10. Add ICS export route and controller method
  - [x] 10.1 Add export route to web.php
    - Add GET route: /events/{event}/export
    - Name route: events.export
    - _Requirements: 7.3_
  
  - [x] 10.2 Add export method to EventController
    - Generate ICS file content with event details
    - Return response with proper headers (text/calendar, attachment)
    - Add error handling for missing event dates
    - Strip HTML tags from description and escape special characters
    - _Requirements: 7.3_

- [x] 11. Create default image assets
  - [x] 11.1 Ensure default-event.jpg exists in public/img/
    - Verify file exists or document requirement for manual addition
    - _Requirements: 11.1, 11.3_
  
  - [x] 11.2 Ensure default-news.jpg exists in public/img/
    - Verify file exists or document requirement for manual addition
    - _Requirements: 11.2, 11.4_

- [x] 12. Final checkpoint - Verify all functionality
  - Run `php artisan migrate:fresh --seed` to test complete setup
  - Verify all 54 pages have content
  - Verify events and news display featured images
  - Verify gallery displays 18 images with lightbox
  - Verify calendar integration works with all three options
  - Verify logo displays in navbar
  - Verify no debug messages appear on pages
  - Ask the user if questions arise

## Notes

- All tasks involve modifying existing Laravel application code
- Migrations must be run before seeders
- Seeders use Eloquent ORM, not raw SQL
- View templates use Blade syntax
- Calendar integration uses external services (Google, Outlook) and ICS standard
- SQLite compatibility is important for development environments
- Default images may need to be added manually if not present
- All requirements from the requirements document are covered by implementation tasks
