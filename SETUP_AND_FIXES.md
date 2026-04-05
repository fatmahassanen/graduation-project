# NCTU Graduation Project - Setup Guide & Fixes Documentation

## Table of Contents
1. [Initial Setup](#initial-setup)
2. [Problems Found & Solutions](#problems-found--solutions)
3. [What Was Added](#what-was-added)
4. [Fresh Installation Guide](#fresh-installation-guide)

---

## Initial Setup

### Prerequisites
- PHP 8.2+ (Project requires 8.3+ but works with 8.2 using `--ignore-platform-reqs`)
- Composer
- Node.js & NPM
- Git

### Repository
```
https://github.com/fatmahassanen/graduation_project.git
```

---

## Problems Found & Solutions

### 1. **Missing Content in Pages**
**Problem:** All pages were created but had no content blocks, showing "This page has no content yet" message.

**Root Cause:** The `DatabaseSeeder` wasn't calling content seeders - only page structure was created without actual content.

**Solution:**
- Updated `DatabaseSeeder.php` to include content seeders
- Created comprehensive seeders:
  - `HomePageContentSeeder` - Home page content
  - `AllPagesContentSeeder` - Content for 16 major pages
  - `CompleteNavigationPagesSeeder` - All 29 navigation menu pages
  - `RemainingPagesContentSeeder` - Additional pages
  - `GalleryContentSeeder` - Photo gallery with 18 images
  - `StaffPagesContentSeeder` - Enhanced staff portal pages

**Pages Created:**
- About section (11 pages): about, president, dean1, dean2, dean3, campus, internal-protocols, external-protocols, reasons, competitions, graduates
- Units section (5 pages): digital-transformation, international-cooperation, quality, evaluation, women
- Faculties (3 pages): faculty-it, faculty-health, faculty-engineering
- Media (3 pages): events, gallery, news
- Admissions (5 pages): admissions, how-apply, faculties-requirements, postgraduate-studies, fees
- Campus (2 pages): entrepreneur, activities
- Staff (3 pages): staff-lms, profile, members
- Student Services (4 pages): student-service, student-booking, library, trainings
- Contact (1 page): contact

---

### 2. **Debug Messages Displayed**
**Problem:** Debug information showing on all pages: "Debug: Page: [title] | Blocks: X | First block type: text"

**Solution:** Removed debug block from `resources/views/pages/show.blade.php`

---

### 3. **Missing Event Images**
**Problem:** Events page showed broken image placeholders (404 errors).

**Root Cause:** Events were using `image_id` (media relationship) but no media records existed.

**Solution:**
- Added `featured_image` string field to events table
- Updated `EventSeeder` to assign direct image paths from `/public/img/Events/`
- Updated event views to prioritize `featured_image` over media relationship
- Created default event image fallback
- Assigned images to all 14 events (competitions, conferences, exhibitions, workshops, seminars)

**Files Modified:**
- Migration: `2026_04_05_212446_add_featured_image_to_events_table.php`
- Model: `app/Models/Event.php`
- Views: `resources/views/events/index.blade.php`, `resources/views/events/show.blade.php`
- Seeder: `database/seeders/EventSeeder.php`

---

### 4. **Website Logo Not Appearing**
**Problem:** Logo showed broken image icon in navbar.

**Root Cause:** Incorrect path `uni/img.png` (directory doesn't exist).

**Solution:** Updated navbar to use correct path `img/logo.png`

**File Modified:** `resources/views/components/navbar.blade.php`

---

### 5. **Confusing Calendar Download (.ics file)**
**Problem:** "Add to Calendar" downloaded `.ics` file which users found confusing.

**Solution:** 
- Added multiple calendar service options:
  - Google Calendar (direct link)
  - Outlook Calendar (direct link)
  - Download .ics file (with explanation)
- Updated both event list and detail pages with dropdown menu

**Files Modified:**
- `resources/views/events/show.blade.php`
- `resources/views/events/index.blade.php`

---

### 6. **Empty Gallery Page**
**Problem:** Gallery page had no photos, just placeholder text.

**Solution:**
- Created `GalleryContentSeeder` with 18 campus images
- Enhanced `gallery-grid` component with:
  - Hover effects showing titles and descriptions
  - Lightbox modal for full-size image viewing
  - Responsive grid layout
  - Smooth animations

**Images Added:**
- Campus buildings and facilities
- Student events and activities
- Graduation ceremonies
- Conferences and exhibitions
- Department labs (Mechatronics, IT, Renewable Energy, Prosthetics)

**Files Modified:**
- Seeder: `database/seeders/GalleryContentSeeder.php`
- Component: `resources/views/components/gallery-grid.blade.php`

---

### 7. **Missing News Images**
**Problem:** All news articles showed broken image placeholders.

**Root Cause:** Same as events - using media relationship without actual media records.

**Solution:**
- Added `featured_image` string field to news table
- Updated `NewsSeeder` to assign direct image paths
- Updated news views to prioritize `featured_image` over media relationship
- Created default news image fallback
- Assigned images to all 12 news articles

**Files Modified:**
- Migration: `2026_04_05_214059_add_featured_image_to_news_table.php`
- Model: `app/Models/News.php`
- Views: `resources/views/news/index.blade.php`, `resources/views/news/show.blade.php`
- Seeder: `database/seeders/NewsSeeder.php`

---

### 8. **Minimal Profile Page**
**Problem:** `/profile` page only showed basic text with no useful functionality.

**Solution:**
- Enhanced with hero section
- Added 6 service cards (Staff Portal, Update Profile, Academic Resources, Research Portal, HR Services, Support)
- Added quick links section
- Added important information alerts
- Enhanced `/staff-lms` page with login form and features list

**Files Modified:**
- Seeder: `database/seeders/StaffPagesContentSeeder.php`

---

### 9. **SQLite Compatibility Issue**
**Problem:** Migration failed with "near MODIFY: syntax error" - SQLite doesn't support `MODIFY COLUMN`.

**Solution:** Updated migration to skip MODIFY COLUMN for SQLite databases.

**File Modified:** `database/migrations/2026_04_04_225157_add_html_type_to_content_blocks_table.php`

---

## What Was Added

### New Database Seeders
1. `HomePageContentSeeder.php` - Home page with hero, text, and card grid
2. `AllPagesContentSeeder.php` - 16 major pages with content
3. `CompleteNavigationPagesSeeder.php` - All 29 navigation pages
4. `RemainingPagesContentSeeder.php` - 8 additional pages
5. `GalleryContentSeeder.php` - Photo gallery with 18 images
6. `StaffPagesContentSeeder.php` - Enhanced staff portal pages

### New Migrations
1. `2026_04_05_212446_add_featured_image_to_events_table.php`
2. `2026_04_05_214059_add_featured_image_to_news_table.php`

### New Features
1. **Enhanced Gallery System**
   - Lightbox modal for image viewing
   - Hover effects with titles and descriptions
   - 18 campus photos organized by category

2. **Improved Calendar Integration**
   - Google Calendar direct link
   - Outlook Calendar direct link
   - .ics file download with explanation

3. **Complete Content Coverage**
   - 54 total pages (all with content)
   - 62 content blocks
   - 14 events with images
   - 12 news articles with images

4. **Enhanced Staff Portal**
   - Professional profile page with service cards
   - Staff LMS login page
   - Quick links and resources

### Default Images Created
- `public/img/default-event.jpg`
- `public/img/default-news.jpg`

---

## Fresh Installation Guide

### Step 1: Clone Repository
```bash
git clone https://github.com/fatmahassanen/graduation_project.git
cd graduation_project
```

### Step 2: Install PHP Dependencies
```bash
composer install --ignore-platform-reqs
```
*Note: Use `--ignore-platform-reqs` if you have PHP 8.2 instead of 8.3*

### Step 3: Install Node Dependencies
```bash
npm install
```

### Step 4: Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 5: Database Setup
```bash
# Create SQLite database file
touch database/database.sqlite

# Run migrations
php artisan migrate --force

# Seed database with all content
php artisan db:seed
```

**Important:** The `DatabaseSeeder` now includes all content seeders:
- UserSeeder
- MediaSeeder
- PageSeeder
- HomePageContentSeeder
- AllPagesContentSeeder
- CompleteNavigationPagesSeeder
- EventSeeder
- NewsSeeder

### Step 6: Build Frontend Assets
```bash
npm run build
```

### Step 7: Start Development Servers

**Option 1: Using Composer (Recommended)**
```bash
composer dev
```
This starts all services: Laravel server, queue worker, logs, and Vite.

**Option 2: Manual Start**

Terminal 1 - Backend:
```bash
php artisan serve
```

Terminal 2 - Frontend:
```bash
npm run dev
```

### Step 8: Access Application
- **Frontend:** http://127.0.0.1:8000
- **Vite Dev Server:** http://localhost:5173

---

## Verification Checklist

After setup, verify the following:

### Pages
- [ ] Home page displays with hero, text, and card sections
- [ ] All navigation menu items work (no 404 errors)
- [ ] About section pages have content
- [ ] Faculty pages display properly
- [ ] Admissions pages have information

### Media
- [ ] Events page shows 14 events with images
- [ ] News page shows 12 articles with images
- [ ] Gallery page displays 18 photos with lightbox
- [ ] Logo appears in navbar

### Functionality
- [ ] "Add to Calendar" shows Google/Outlook/Download options
- [ ] Gallery images open in lightbox when clicked
- [ ] Event detail pages show images
- [ ] News detail pages show images
- [ ] Profile page shows service cards

### Database
```bash
# Check database status
php artisan tinker --execute="echo 'Pages: ' . App\Models\Page::count() . PHP_EOL; echo 'Content Blocks: ' . App\Models\ContentBlock::count() . PHP_EOL; echo 'Events: ' . App\Models\Event::count() . PHP_EOL; echo 'News: ' . App\Models\News::count() . PHP_EOL;"
```

Expected output:
- Pages: 54
- Content Blocks: 62+
- Events: 14
- News: 12

---

## Troubleshooting

### Issue: Pages still show "no content"
**Solution:** Run seeders again
```bash
php artisan db:seed --class=CompleteNavigationPagesSeeder
```

### Issue: Images not showing
**Solution:** Check if images exist in public directory
```bash
ls public/img/Events/
ls public/img/
```

### Issue: Logo not appearing
**Solution:** Verify logo file exists
```bash
ls public/img/logo.png
```

### Issue: Migration errors
**Solution:** Fresh migration with seed
```bash
php artisan migrate:fresh --seed
```

---

## Production Deployment Notes

1. **Environment Variables:** Update `.env` for production:
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Configure proper database credentials
   - Set correct `APP_URL`

2. **Database:** Consider using MySQL/PostgreSQL instead of SQLite for production

3. **Assets:** Build production assets
   ```bash
   npm run build
   ```

4. **Permissions:** Set proper file permissions
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

5. **Optimization:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

## Summary

This project is now fully functional with:
- ✅ 54 pages with complete content
- ✅ 14 events with images
- ✅ 12 news articles with images
- ✅ 18-photo gallery with lightbox
- ✅ Enhanced calendar integration
- ✅ Professional staff portal
- ✅ Working navigation menu
- ✅ Proper logo display
- ✅ SQLite compatibility

All issues have been resolved and the application is ready for use!
