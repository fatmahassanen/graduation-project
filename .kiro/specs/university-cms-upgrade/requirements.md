# Requirements Document: University CMS Upgrade

## Introduction

This document specifies the requirements for upgrading a static university website (70+ HTML pages) into a dynamic Laravel 13.x CMS application. The system will preserve the existing Bootstrap-based design while providing a flexible content management system with versioning, multi-language support, and role-based access control.

The upgrade will transform static HTML files in the old_files/ directory into a database-driven CMS that enables non-technical staff to manage content through a secure admin panel while maintaining the university's brand identity (orange #D08301 and purple #1a096e color scheme).

## Glossary

- **CMS**: The Content Management System - the Laravel application that manages all website content
- **Page**: A complete web page entity with metadata (title, slug, category, status, language)
- **Content_Block**: A reusable section of content within a page (hero, text, cards, FAQ, etc.)
- **Admin_Panel**: The secure backend interface for content management
- **Content_Editor**: A user role that can create and edit content but cannot publish
- **Faculty_Admin**: A user role that can manage content for their specific faculty only
- **Super_Admin**: A user role with full system access including user management
- **Revision**: A historical version of page or content block data
- **Media_Library**: The system for uploading, organizing, and managing images, PDFs, and documents
- **Blade_Component**: A reusable Laravel Blade template component (navbar, footer, hero, card, etc.)
- **Page_Category**: A classification for pages (Admissions, Faculties, Events, About, Quality, Media, Campus, Staff, Student_Services)
- **WYSIWYG_Editor**: What You See Is What You Get - visual content editor
- **Audit_Log**: A record of who changed what content and when
- **Draft_Mode**: Content state that is saved but not visible to public users
- **Published_Mode**: Content state that is live and visible to public users

## Requirements

### Requirement 1: Flexible Page Management System

**User Story:** As a Super Admin, I want to manage 70+ unique pages through a database-driven system, so that content can be updated without modifying code.

#### Acceptance Criteria

1. THE CMS SHALL store page metadata including title, slug, category, status, language, and timestamps
2. THE CMS SHALL support page categories: Admissions, Faculties, Events, About, Quality, Media, Campus, Staff, Student_Services
3. WHEN a page is created, THE CMS SHALL generate a unique slug from the title
4. WHEN a duplicate slug is detected, THE CMS SHALL append a numeric suffix to ensure uniqueness
5. THE CMS SHALL support page status values: draft, published, archived
6. THE CMS SHALL associate each page with one or more Content_Blocks
7. WHEN a page is requested by slug, THE CMS SHALL retrieve all associated Content_Blocks in display order
8. THE CMS SHALL support multi-language pages with language codes: en, ar
9. FOR ALL valid Page objects, serializing then deserializing SHALL produce an equivalent object (round-trip property)

### Requirement 2: Content Block Architecture

**User Story:** As a Content Editor, I want to build pages from reusable content blocks, so that I can create consistent layouts without duplicating content.

#### Acceptance Criteria

1. THE CMS SHALL support Content_Block types: hero, text, card_grid, video, faq, testimonial, gallery, contact_form
2. THE CMS SHALL store Content_Block data including type, content (JSON), display_order, and page association
3. WHEN Content_Blocks are retrieved for a page, THE CMS SHALL order them by display_order ascending
4. THE CMS SHALL validate Content_Block JSON structure based on block type
5. WHEN invalid JSON structure is provided, THE CMS SHALL return a descriptive validation error
6. THE CMS SHALL allow Content_Blocks to be reused across multiple pages
7. WHEN a Content_Block is updated, THE CMS SHALL reflect changes on all pages using that block
8. THE CMS SHALL support nested content within card_grid blocks (title, description, image, link)
9. FOR ALL valid Content_Block objects, parsing then printing then parsing SHALL produce an equivalent object (round-trip property)

### Requirement 3: Content Versioning and Revision History

**User Story:** As a Super Admin, I want to track all content changes with revision history, so that I can review changes and restore previous versions if needed.

#### Acceptance Criteria

1. WHEN a page is created or updated, THE CMS SHALL create a Revision record
2. THE CMS SHALL store Revision data including user_id, revisionable_type, revisionable_id, old_values, new_values, and timestamp
3. THE CMS SHALL track changes to page fields: title, slug, status, language
4. THE CMS SHALL track changes to Content_Block fields: type, content, display_order
5. WHEN a Revision is created, THE CMS SHALL store the complete old and new values as JSON
6. THE CMS SHALL provide a revision history view showing all changes chronologically
7. WHEN a Super Admin requests to restore a revision, THE CMS SHALL revert the page or Content_Block to that version
8. WHEN a revision is restored, THE CMS SHALL create a new Revision record documenting the restoration
9. THE CMS SHALL display revision metadata: who changed what, when, and what values changed

### Requirement 4: Multi-Language Content Support

**User Story:** As a Content Editor, I want to create content in multiple languages, so that the university can serve both English and Arabic-speaking audiences.

#### Acceptance Criteria

1. THE CMS SHALL support language codes: en (English), ar (Arabic)
2. WHEN a page is created, THE CMS SHALL require a language code
3. THE CMS SHALL allow multiple pages with the same slug if they have different language codes
4. THE CMS SHALL provide a language switcher in the frontend navigation
5. WHEN a user switches language, THE CMS SHALL display the page in the selected language if available
6. IF a page translation does not exist, THEN THE CMS SHALL display a "translation not available" message
7. THE CMS SHALL store Content_Block content with language-specific fields in JSON
8. THE CMS SHALL allow Content_Editors to link translated pages together
9. WHEN viewing a page, THE CMS SHALL display available translations with links to switch

### Requirement 5: Role-Based Access Control

**User Story:** As a Super Admin, I want to assign different permission levels to users, so that content editors can manage content without accessing sensitive system settings.

#### Acceptance Criteria

1. THE CMS SHALL support user roles: Super_Admin, Content_Editor, Faculty_Admin
2. THE CMS SHALL use Laravel's built-in authentication system
3. WHEN a Super_Admin creates a user, THE CMS SHALL assign one role to that user
4. THE CMS SHALL allow Super_Admin to: manage all content, manage users, access audit logs, restore revisions
5. THE CMS SHALL allow Content_Editor to: create and edit content, upload media, save drafts
6. THE CMS SHALL allow Faculty_Admin to: manage content only for their assigned faculty category
7. WHEN a Faculty_Admin attempts to edit content outside their faculty, THE CMS SHALL deny access with a 403 error
8. THE CMS SHALL restrict Content_Editor from publishing content (only Super_Admin can publish)
9. THE CMS SHALL require authentication for all Admin_Panel routes

### Requirement 6: Secure Admin Panel

**User Story:** As a Super Admin, I want a secure backend interface for content management, so that only authorized users can modify website content.

#### Acceptance Criteria

1. THE CMS SHALL provide an Admin_Panel accessible at /admin route
2. WHEN an unauthenticated user accesses /admin, THE CMS SHALL redirect to login page
3. THE CMS SHALL use Laravel's session-based authentication
4. THE CMS SHALL implement CSRF protection on all Admin_Panel forms
5. WHEN a user logs in successfully, THE CMS SHALL redirect to the Admin_Panel dashboard
6. THE CMS SHALL display user role and name in the Admin_Panel header
7. THE CMS SHALL provide a logout button that terminates the session
8. THE CMS SHALL implement password hashing using Laravel's Hash facade
9. WHEN a user fails authentication 5 times, THE CMS SHALL lock the account for 15 minutes

### Requirement 7: Media Management System

**User Story:** As a Content Editor, I want to upload and organize images, PDFs, and documents, so that I can include media in page content.

#### Acceptance Criteria

1. THE CMS SHALL provide a Media_Library interface in the Admin_Panel
2. THE CMS SHALL support file uploads for types: jpg, jpeg, png, gif, svg, pdf, doc, docx
3. WHEN a file is uploaded, THE CMS SHALL validate file type and size (max 10MB)
4. WHEN an invalid file is uploaded, THE CMS SHALL return a descriptive error message
5. THE CMS SHALL store uploaded files in storage/app/public/media directory
6. THE CMS SHALL generate unique filenames to prevent overwrites
7. THE CMS SHALL store media metadata in a media table: filename, original_name, mime_type, size, uploaded_by, created_at
8. THE CMS SHALL provide a media browser with search and filter capabilities
9. THE CMS SHALL allow Content_Editors to delete media files they uploaded
10. THE CMS SHALL prevent deletion of media files referenced in published content

### Requirement 8: Audit Logging System

**User Story:** As a Super Admin, I want to track all content changes with user attribution, so that I can maintain accountability and review who made specific changes.

#### Acceptance Criteria

1. WHEN a user creates, updates, or deletes content, THE CMS SHALL create an Audit_Log entry
2. THE CMS SHALL store Audit_Log data: user_id, action, model_type, model_id, old_values, new_values, ip_address, user_agent, timestamp
3. THE CMS SHALL log actions: created, updated, deleted, published, unpublished, restored
4. THE CMS SHALL provide an audit log viewer in the Admin_Panel (Super_Admin only)
5. THE CMS SHALL allow filtering audit logs by: user, date range, action type, model type
6. THE CMS SHALL display audit logs in reverse chronological order
7. THE CMS SHALL retain audit logs for minimum 2 years
8. THE CMS SHALL include IP address and user agent in audit logs for security tracking
9. WHEN viewing an audit log entry, THE CMS SHALL display a diff view of old vs new values

### Requirement 9: Draft and Preview Mode

**User Story:** As a Content Editor, I want to save drafts and preview changes before publishing, so that I can review content without affecting the live site.

#### Acceptance Criteria

1. THE CMS SHALL support page status: draft, published, archived
2. WHEN a Content_Editor saves a page, THE CMS SHALL set status to draft by default
3. THE CMS SHALL provide a "Save Draft" button that saves without publishing
4. THE CMS SHALL provide a "Preview" button that displays the page as it would appear when published
5. WHEN previewing a draft, THE CMS SHALL render the page with all Content_Blocks but display a "Preview Mode" banner
6. THE CMS SHALL restrict draft pages from appearing in public site navigation
7. WHEN a Super_Admin clicks "Publish", THE CMS SHALL change status to published and make the page publicly visible
8. THE CMS SHALL allow reverting published pages to draft status
9. WHEN a page is unpublished, THE CMS SHALL return 404 for public requests to that page

### Requirement 10: WYSIWYG Content Editor

**User Story:** As a Content Editor, I want a visual editor for text content, so that I can format content without writing HTML.

#### Acceptance Criteria

1. THE CMS SHALL integrate a WYSIWYG_Editor for text Content_Blocks
2. THE CMS SHALL support formatting: bold, italic, underline, headings, lists, links, images
3. WHEN a user inserts an image, THE CMS SHALL open the Media_Library browser
4. THE CMS SHALL sanitize HTML output to prevent XSS attacks
5. THE CMS SHALL allow switching between visual and HTML source modes
6. THE CMS SHALL preserve formatting when saving and retrieving content
7. THE CMS SHALL support RTL (right-to-left) text direction for Arabic content
8. THE CMS SHALL provide a character counter for content fields with limits
9. WHEN invalid HTML is detected, THE CMS SHALL display a validation warning

### Requirement 11: Frontend Blade Component Architecture

**User Story:** As a developer, I want to convert static HTML into reusable Blade components, so that the codebase follows DRY principles and is maintainable.

#### Acceptance Criteria

1. THE CMS SHALL extract navbar.html into a Blade_Component at resources/views/components/navbar.blade.php
2. THE CMS SHALL extract footer.html into a Blade_Component at resources/views/components/footer.blade.php
3. THE CMS SHALL create Blade_Components for: hero, card-grid, video-section, faq-section, testimonial-carousel, gallery-grid
4. THE CMS SHALL use a master layout at resources/views/layouts/app.blade.php
5. THE CMS SHALL pass data to Blade_Components via component attributes
6. THE CMS SHALL preserve all existing CSS classes and structure from static HTML
7. THE CMS SHALL maintain Bootstrap 5 compatibility
8. THE CMS SHALL preserve JavaScript functionality (WOW.js, Owl Carousel, active link highlighting)
9. FOR ALL Blade_Components, rendering with valid props SHALL produce valid HTML (property)

### Requirement 12: Dynamic Page Rendering

**User Story:** As a website visitor, I want to view university pages with the same design as the static site, so that the user experience remains consistent.

#### Acceptance Criteria

1. WHEN a user requests a page by slug, THE CMS SHALL retrieve the page and associated Content_Blocks
2. THE CMS SHALL render Content_Blocks using appropriate Blade_Components based on block type
3. THE CMS SHALL preserve the existing Bootstrap grid layout and styling
4. THE CMS SHALL load CSS files: css/bootstrap.min.css, css/style.css
5. THE CMS SHALL load JavaScript libraries: jQuery, Bootstrap, WOW.js, Owl Carousel
6. THE CMS SHALL maintain responsive design for mobile devices
7. THE CMS SHALL render navbar with active link highlighting based on current page
8. THE CMS SHALL render footer with gallery images and social media links
9. WHEN a page does not exist, THE CMS SHALL return a 404 error page with consistent styling

### Requirement 13: Event Calendar System

**User Story:** As a Content Editor, I want to manage university events with dates and descriptions, so that students can see upcoming activities.

#### Acceptance Criteria

1. THE CMS SHALL provide an Event content type with fields: title, description, start_date, end_date, location, category, image
2. THE CMS SHALL display events in chronological order on the Events page
3. WHEN an event date has passed, THE CMS SHALL move it to "Past Events" section
4. THE CMS SHALL support event categories: Competition, Conference, Exhibition, Workshop, Seminar
5. THE CMS SHALL allow filtering events by category
6. THE CMS SHALL display event details on individual event pages
7. THE CMS SHALL support recurring events with recurrence rules
8. WHEN creating a recurring event, THE CMS SHALL generate individual event instances
9. THE CMS SHALL provide an iCalendar export for events

### Requirement 14: News Feed Management

**User Story:** As a Content Editor, I want to publish news articles with featured images, so that the university can share updates with students and visitors.

#### Acceptance Criteria

1. THE CMS SHALL provide a News content type with fields: title, excerpt, body, featured_image, author, published_at, category
2. THE CMS SHALL display news articles in reverse chronological order on the News page
3. THE CMS SHALL support news categories: Announcement, Achievement, Research, Partnership
4. THE CMS SHALL allow filtering news by category
5. THE CMS SHALL display news article details on individual article pages
6. THE CMS SHALL show related news articles based on category
7. THE CMS SHALL support featured news articles that appear prominently on homepage
8. WHEN a news article is published, THE CMS SHALL set published_at to current timestamp
9. THE CMS SHALL provide RSS feed for news articles

### Requirement 15: Contact Form System

**User Story:** As a website visitor, I want to submit inquiries through a contact form, so that I can communicate with the university.

#### Acceptance Criteria

1. THE CMS SHALL provide a contact form with fields: name, email, phone, subject, message
2. WHEN a user submits the form, THE CMS SHALL validate all required fields
3. WHEN validation fails, THE CMS SHALL display field-specific error messages
4. WHEN the form is valid, THE CMS SHALL store the submission in a contact_submissions table
5. THE CMS SHALL send an email notification to the university contact email address
6. THE CMS SHALL display a success message after successful submission
7. THE CMS SHALL implement reCAPTCHA to prevent spam submissions
8. THE CMS SHALL provide a submissions viewer in the Admin_Panel
9. WHEN a Super_Admin views a submission, THE CMS SHALL mark it as read

### Requirement 16: Search Functionality

**User Story:** As a website visitor, I want to search for content across the website, so that I can quickly find information.

#### Acceptance Criteria

1. THE CMS SHALL provide a search input in the navigation bar
2. WHEN a user submits a search query, THE CMS SHALL search page titles, content, and metadata
3. THE CMS SHALL display search results with page title, excerpt, and link
4. THE CMS SHALL highlight search terms in results
5. THE CMS SHALL order results by relevance score
6. THE CMS SHALL support search filters: category, language, content type
7. WHEN no results are found, THE CMS SHALL display a "no results" message with search suggestions
8. THE CMS SHALL limit search results to published content only
9. THE CMS SHALL log search queries for analytics purposes

### Requirement 17: SEO Metadata Management

**User Story:** As a Content Editor, I want to set SEO metadata for pages, so that the website ranks well in search engines.

#### Acceptance Criteria

1. THE CMS SHALL provide SEO fields for pages: meta_title, meta_description, meta_keywords, og_image
2. WHEN SEO fields are empty, THE CMS SHALL generate defaults from page title and content
3. THE CMS SHALL render meta tags in the HTML head section
4. THE CMS SHALL support Open Graph tags for social media sharing
5. THE CMS SHALL generate a sitemap.xml file automatically
6. WHEN a page is published or unpublished, THE CMS SHALL update the sitemap
7. THE CMS SHALL generate a robots.txt file
8. THE CMS SHALL provide canonical URL tags to prevent duplicate content issues
9. THE CMS SHALL validate meta_description length (max 160 characters)

### Requirement 18: Performance Optimization

**User Story:** As a website visitor, I want pages to load quickly, so that I have a smooth browsing experience.

#### Acceptance Criteria

1. THE CMS SHALL cache rendered pages for 1 hour
2. WHEN content is updated, THE CMS SHALL clear the cache for affected pages
3. THE CMS SHALL use Laravel's query optimization to prevent N+1 queries
4. THE CMS SHALL eager load relationships when retrieving pages with Content_Blocks
5. THE CMS SHALL compress images uploaded to the Media_Library
6. THE CMS SHALL serve images in WebP format when browser supports it
7. THE CMS SHALL minify CSS and JavaScript in production environment
8. THE CMS SHALL implement lazy loading for images below the fold
9. WHEN a page is requested, THE CMS SHALL respond within 200ms (excluding network latency)

### Requirement 19: Database Migration from Static Files

**User Story:** As a developer, I want to migrate existing static HTML content into the database, so that the CMS is populated with current university content.

#### Acceptance Criteria

1. THE CMS SHALL provide an Artisan command to parse static HTML files
2. WHEN the migration command runs, THE CMS SHALL extract page metadata from HTML files
3. THE CMS SHALL identify common patterns: hero sections, card grids, FAQ sections, video embeds
4. THE CMS SHALL create Page records for each HTML file with appropriate category
5. THE CMS SHALL create Content_Block records for identified sections
6. THE CMS SHALL preserve content structure and formatting
7. THE CMS SHALL extract and copy media files to the Media_Library
8. THE CMS SHALL generate slugs from HTML filenames
9. WHEN migration completes, THE CMS SHALL output a summary report of migrated pages and blocks

### Requirement 20: Environment-Aware Configuration

**User Story:** As a developer, I want the CMS to behave differently in development, testing, and production environments, so that I can safely develop and test features.

#### Acceptance Criteria

1. THE CMS SHALL read environment configuration from .env file
2. THE CMS SHALL use different database connections for dev, test, and prod environments
3. WHEN in development environment, THE CMS SHALL display detailed error messages
4. WHEN in production environment, THE CMS SHALL log errors and display generic error pages
5. THE CMS SHALL disable debug mode in production environment
6. THE CMS SHALL use different cache drivers based on environment
7. THE CMS SHALL send emails to real addresses in production, log emails in development
8. THE CMS SHALL use different asset compilation strategies (hot reload in dev, minified in prod)
9. THE CMS SHALL validate required environment variables on application boot

## Correctness Properties for Property-Based Testing

### Page Management Properties

1. **Slug Uniqueness Invariant**: For any set of pages with the same language, all slugs SHALL be unique
2. **Round-Trip Serialization**: For all valid Page objects, `Page::fromArray(page->toArray()) == page`
3. **Category Membership**: For all pages, the category SHALL be one of the defined Page_Category values
4. **Status Transition**: For all pages, valid status transitions SHALL be: draft→published, published→draft, any→archived

### Content Block Properties

1. **Display Order Invariant**: For any page, Content_Blocks ordered by display_order SHALL maintain ascending sequence
2. **JSON Validation**: For all Content_Blocks, the content JSON SHALL validate against the schema for its type
3. **Round-Trip Content**: For all Content_Blocks, `parse(serialize(block.content)) == block.content`
4. **Type-Content Consistency**: For all Content_Blocks, the content structure SHALL match the requirements of its type

### Revision History Properties

1. **Revision Completeness**: For all content changes, a Revision record SHALL exist
2. **Restoration Idempotence**: Restoring a revision twice SHALL produce the same result as restoring once
3. **Revision Chain**: For any page, following the revision chain SHALL reconstruct the complete history

### Access Control Properties

1. **Permission Enforcement**: For all protected routes, unauthenticated requests SHALL return 401 or redirect to login
2. **Role Restriction**: For all Faculty_Admin users, accessible pages SHALL only include their assigned faculty category
3. **Publish Permission**: For all Content_Editor users, publish actions SHALL be denied with 403 error

### Media Management Properties

1. **File Type Validation**: For all upload attempts, files not in allowed types SHALL be rejected
2. **Filename Uniqueness**: For all uploaded files, generated filenames SHALL be unique
3. **Reference Integrity**: For all media files referenced in published content, deletion attempts SHALL be prevented

### Search Properties

1. **Published Content Only**: For all search results, returned pages SHALL have status = published
2. **Relevance Ordering**: For all search results, relevance scores SHALL be in descending order
3. **Query Sanitization**: For all search queries, SQL injection attempts SHALL be prevented

### Performance Properties

1. **Query Efficiency**: For all page renders, database queries SHALL not exceed N+1 pattern
2. **Cache Invalidation**: For all content updates, affected page caches SHALL be cleared
3. **Response Time**: For all page requests (excluding network), response time SHALL be under 200ms for 95th percentile
