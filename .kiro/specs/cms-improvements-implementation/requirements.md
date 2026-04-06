# Requirements Document

## Introduction

This document specifies requirements for implementing improvements and fixes to the NCTU Graduation Project Laravel CMS. The system currently has several issues including missing content in pages, broken images, debug messages in production views, and incomplete UI features. This feature addresses database schema updates, content seeding, view enhancements, and UI/UX improvements to make the CMS fully functional.

## Glossary

- **CMS**: Content Management System - the Laravel application managing university website content
- **DatabaseSeeder**: Laravel seeder class that orchestrates execution of all database seeders
- **ContentSeeder**: Laravel seeder class that populates content_blocks table with page content
- **Migration**: Laravel database schema modification file
- **Event**: University event entity with title, dates, location, and category
- **News**: News article entity with title, content, and publication date
- **Gallery**: Photo gallery page displaying campus images
- **ContentBlock**: Reusable content component (text, hero, card grid, etc.) attached to pages
- **FeaturedImage**: Direct file path to an image stored in public directory
- **Lightbox**: Modal overlay for viewing full-size images
- **CalendarService**: External calendar application (Google Calendar, Outlook, Apple Calendar)
- **ICS_File**: iCalendar format file for importing events into calendar applications
- **StaffPortal**: Administrative interface for university staff members
- **SQLite**: Lightweight database engine used for development

## Requirements

### Requirement 1: Database Seeder Orchestration

**User Story:** As a developer, I want the DatabaseSeeder to call all content seeders, so that fresh installations have complete content.

#### Acceptance Criteria

1. WHEN DatabaseSeeder runs, THE DatabaseSeeder SHALL call HomePageContentSeeder
2. WHEN DatabaseSeeder runs, THE DatabaseSeeder SHALL call AllPagesContentSeeder
3. WHEN DatabaseSeeder runs, THE DatabaseSeeder SHALL call CompleteNavigationPagesSeeder
4. WHEN DatabaseSeeder runs, THE DatabaseSeeder SHALL call GalleryContentSeeder
5. WHEN DatabaseSeeder runs, THE DatabaseSeeder SHALL call StaffPagesContentSeeder
6. THE DatabaseSeeder SHALL execute seeders in dependency order (pages before content)

### Requirement 2: Event Featured Images

**User Story:** As a content manager, I want events to display featured images, so that the events page is visually appealing.

#### Acceptance Criteria

1. THE Events_Table SHALL have a featured_image string column
2. WHEN EventSeeder runs, THE EventSeeder SHALL assign image paths from public/img/Events/ directory
3. WHEN an event has a featured_image value, THE Event_View SHALL display the featured image
4. WHEN an event has no featured_image value, THE Event_View SHALL display a default event image
5. THE Event_View SHALL prioritize featured_image over media relationship

### Requirement 3: News Featured Images

**User Story:** As a content manager, I want news articles to display featured images, so that the news page is visually engaging.

#### Acceptance Criteria

1. THE News_Table SHALL have a featured_image string column
2. WHEN NewsSeeder runs, THE NewsSeeder SHALL assign image paths to news articles
3. WHEN a news article has a featured_image value, THE News_View SHALL display the featured image
4. WHEN a news article has no featured_image value, THE News_View SHALL display a default news image
5. THE News_View SHALL prioritize featured_image over media relationship

### Requirement 4: Logo Display Fix

**User Story:** As a visitor, I want to see the university logo in the navigation bar, so that I can identify the website.

#### Acceptance Criteria

1. THE Navbar_Component SHALL reference img/logo.png as the logo path
2. WHEN the navbar renders, THE Navbar_Component SHALL display the logo image
3. IF the logo file does not exist, THEN THE Navbar_Component SHALL display alt text

### Requirement 5: Debug Message Removal

**User Story:** As a visitor, I want to see clean pages without debug information, so that the site appears professional.

#### Acceptance Criteria

1. THE Page_View SHALL NOT display debug messages about page title
2. THE Page_View SHALL NOT display debug messages about content block count
3. THE Page_View SHALL NOT display debug messages about block types

### Requirement 6: Gallery Content and Lightbox

**User Story:** As a visitor, I want to view campus photos in a gallery with lightbox functionality, so that I can explore images in detail.

#### Acceptance Criteria

1. WHEN GalleryContentSeeder runs, THE GalleryContentSeeder SHALL create 18 gallery image content blocks
2. WHEN a visitor hovers over a gallery image, THE Gallery_Component SHALL display image title and description overlay
3. WHEN a visitor clicks a gallery image, THE Gallery_Component SHALL open a lightbox modal with full-size image
4. THE Gallery_Component SHALL display images in a responsive grid layout
5. WHEN the lightbox is open, THE Gallery_Component SHALL display image title and description below the image

### Requirement 7: Enhanced Calendar Integration

**User Story:** As a visitor, I want multiple options to add events to my calendar, so that I can use my preferred calendar application.

#### Acceptance Criteria

1. WHEN viewing an event, THE Event_View SHALL display a Google Calendar link
2. WHEN viewing an event, THE Event_View SHALL display an Outlook Calendar link
3. WHEN viewing an event, THE Event_View SHALL display an ICS file download option
4. THE Event_View SHALL include explanatory text for the ICS file option
5. WHEN a visitor clicks a calendar link, THE CMS SHALL open the calendar service in a new tab with pre-filled event details

### Requirement 8: Staff Portal Enhancement

**User Story:** As a staff member, I want an enhanced profile page with service cards, so that I can quickly access staff resources.

#### Acceptance Criteria

1. WHEN StaffPagesContentSeeder runs, THE StaffPagesContentSeeder SHALL create profile page content with hero section
2. WHEN StaffPagesContentSeeder runs, THE StaffPagesContentSeeder SHALL create 6 service cards for staff portal
3. THE Profile_Page SHALL display service cards for Staff Portal, Update Profile, Academic Resources, Research Portal, HR Services, and Support
4. WHEN StaffPagesContentSeeder runs, THE StaffPagesContentSeeder SHALL create staff-lms page content with login form
5. THE Staff_LMS_Page SHALL display features list and quick links

### Requirement 9: SQLite Migration Compatibility

**User Story:** As a developer, I want migrations to work with SQLite, so that I can use SQLite for development and testing.

#### Acceptance Criteria

1. WHEN a migration uses MODIFY COLUMN syntax, THE Migration SHALL detect SQLite database
2. IF the database is SQLite, THEN THE Migration SHALL skip MODIFY COLUMN operations
3. IF the database is not SQLite, THEN THE Migration SHALL execute MODIFY COLUMN operations
4. THE Migration SHALL log a warning when skipping SQLite-incompatible operations

### Requirement 10: Content Seeder Creation

**User Story:** As a developer, I want comprehensive content seeders for all pages, so that the CMS has realistic content for testing and demonstration.

#### Acceptance Criteria

1. THE HomePageContentSeeder SHALL create hero, text, and card grid content blocks for the home page
2. THE AllPagesContentSeeder SHALL create content for 16 major pages including about, faculties, and admissions sections
3. THE CompleteNavigationPagesSeeder SHALL create content for all 29 navigation menu pages
4. THE GalleryContentSeeder SHALL create 18 image content blocks with titles and descriptions
5. THE StaffPagesContentSeeder SHALL create enhanced content for profile and staff-lms pages
6. WHEN a content seeder runs, THE ContentSeeder SHALL use Eloquent ORM to create content blocks
7. WHEN a content seeder runs, THE ContentSeeder SHALL associate content blocks with existing pages by slug

### Requirement 11: Default Image Assets

**User Story:** As a content manager, I want default fallback images for events and news, so that pages display properly when featured images are missing.

#### Acceptance Criteria

1. THE CMS SHALL provide a default-event.jpg image in public/img/ directory
2. THE CMS SHALL provide a default-news.jpg image in public/img/ directory
3. WHEN an event has no featured_image, THE Event_View SHALL display default-event.jpg
4. WHEN a news article has no featured_image, THE News_View SHALL display default-news.jpg

### Requirement 12: Event and News Model Updates

**User Story:** As a developer, I want Event and News models to support featured images, so that the application can display images correctly.

#### Acceptance Criteria

1. THE Event_Model SHALL include featured_image in fillable attributes
2. THE News_Model SHALL include featured_image in fillable attributes
3. THE Event_Model SHALL cast featured_image as string
4. THE News_Model SHALL cast featured_image as string

### Requirement 13: View Template Updates

**User Story:** As a developer, I want view templates to display featured images correctly, so that visitors see images on event and news pages.

#### Acceptance Criteria

1. THE Event_Index_View SHALL check for featured_image before media relationship
2. THE Event_Show_View SHALL check for featured_image before media relationship
3. THE News_Index_View SHALL check for featured_image before media relationship
4. THE News_Show_View SHALL check for featured_image before media relationship
5. WHEN no image source is available, THE View SHALL display the appropriate default image
