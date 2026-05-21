# Implementation Plan: Admin Dashboard Layout

## Overview

This implementation plan creates a professional admin dashboard layout for the Laravel application with a fixed vertical sidebar, top header bar with user controls, and responsive content area. The layout uses Laravel Blade templates, Tailwind CSS v4, and FontAwesome icons to provide a premium SaaS-style interface for authenticated administrators.

## Tasks

- [x] 1. Create admin layout master template file
  - Create `resources/views/layouts/admin.blade.php` with complete HTML structure
  - Include FontAwesome 5.10.0 CDN link for icons
  - Include Tailwind CSS v4 CDN script for styling
  - Add CSRF token meta tag for security
  - Define `@yield('admin_content')` directive for content injection
  - Define `@stack('styles')` and `@stack('scripts')` directives for additional assets
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 10.1, 10.2, 10.3_

- [x] 2. Implement sidebar navigation component
  - [x] 2.1 Create sidebar HTML structure with navigation menu
    - Add sidebar container with fixed positioning and 250px width
    - Apply background color #1a096e (Dark Slate / Midnight Blue)
    - Create navigation list with menu items: Dashboard, News Management, Media/Gallery, Departments, Students, Settings
    - Add FontAwesome icons for each menu item (fa-tachometer-alt, fa-newspaper, fa-images, fa-building, fa-user-graduate, fa-cog)
    - Use Laravel route helpers for navigation links (e.g., `route('admin.dashboard')`)
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5, 2.6_
  
  - [x] 2.2 Add sidebar interactive styling with Tailwind CSS
    - Apply hover effect with #D08301 (orange accent) color
    - Add smooth CSS transition (0.3s ease) for hover states
    - Implement active state detection using `request()->routeIs()` helper
    - Apply distinct styling for active menu item
    - _Requirements: 3.1, 3.2, 3.3, 3.4_

- [x] 3. Implement top header component
  - [x] 3.1 Create header HTML structure
    - Add header container with white background and full width
    - Set fixed positioning at top with 64px height
    - Add box shadow for visual depth (0 2px 4px rgba(0,0,0,0.1))
    - Set z-index to 1000 for proper layering
    - _Requirements: 4.1, 4.2, 4.4, 4.5_
  
  - [x] 3.2 Create user profile dropdown component
    - Add dropdown trigger button displaying authenticated user's name using `Auth::user()->name`
    - Add chevron-down icon (fa-chevron-down) next to username
    - Create dropdown menu with Profile link to `route('profile.edit')`
    - Add logout form with CSRF token and POST to `route('logout')`
    - Position dropdown on right side of header
    - _Requirements: 4.3, 5.1, 5.2, 5.3, 5.4, 5.5, 9.2, 9.3, 10.5_
  
  - [x] 3.3 Add dropdown interactive behavior with JavaScript
    - Write vanilla JavaScript to toggle dropdown visibility on click
    - Implement click-outside detection to close dropdown
    - Add smooth fade-in animation (0.2s) for dropdown appearance
    - _Requirements: 5.2_

- [x] 4. Implement main content area
  - Create content area container with light gray background (#f4f7f6)
  - Set margin-left to 250px on desktop (matching sidebar width)
  - Set margin-top to 64px (matching header height)
  - Add 24px padding around content
  - Set min-height to `calc(100vh - 64px)` for full viewport coverage
  - Ensure `@yield('admin_content')` renders within content area
  - _Requirements: 6.1, 6.2, 6.3, 6.4, 6.5, 6.6_

- [x] 5. Implement responsive mobile behavior
  - [x] 5.1 Add mobile-specific CSS classes
    - Hide sidebar by default on mobile viewports (<768px) using Tailwind responsive classes
    - Show sidebar by default on desktop viewports (≥768px)
    - Remove left margin from content area on mobile
    - _Requirements: 7.1, 7.5_
  
  - [x] 5.2 Create mobile toggle button
    - Add hamburger menu button (fa-bars icon) in header
    - Hide toggle button on desktop (≥768px) using Tailwind responsive classes
    - Show toggle button on mobile (<768px)
    - Position button in top-left of header
    - _Requirements: 7.2_
  
  - [x] 5.3 Add mobile sidebar toggle functionality
    - Write JavaScript function to toggle sidebar visibility class
    - Add smooth slide-in animation for sidebar on mobile
    - Create semi-transparent overlay (rgba(0,0,0,0.5)) that appears when sidebar is open
    - Implement overlay click handler to close sidebar
    - Set proper z-index values (sidebar: 1001, overlay: 999)
    - _Requirements: 7.3, 7.4_

- [x] 6. Apply premium visual design styling
  - Review and refine spacing consistency across all components using Tailwind spacing utilities
  - Ensure typography consistency (font sizes, weights, line heights)
  - Add subtle shadows and borders for visual depth and component separation
  - Verify all interactive elements have clear visual affordances (hover states, focus states)
  - Ensure color scheme consistency throughout layout
  - _Requirements: 8.1, 8.2, 8.3, 8.4, 8.5_

- [x] 7. Checkpoint - Verify layout renders correctly
  - Ensure all tests pass, ask the user if questions arise.

- [x] 8. Create admin routes and controller
  - [x] 8.1 Define admin route group in routes/web.php
    - Create route group with `auth` middleware and `admin` prefix
    - Define named routes for: dashboard, news.index, media.index, departments.index, students.index, settings.index
    - Use route naming convention: `admin.{resource}.{action}`
    - _Requirements: 9.1, 9.4_
  
  - [x] 8.2 Create AdminController with dashboard method
    - Generate controller using `php artisan make:controller AdminController`
    - Create `dashboard()` method that returns view extending admin layout
    - Create `resources/views/admin/dashboard.blade.php` view file
    - Use `@extends('layouts.admin')` and `@section('admin_content')` in dashboard view
    - _Requirements: 10.4_

- [ ]* 9. Write feature tests for admin layout
  - [ ]* 9.1 Test admin layout renders with required elements
    - Test that sidebar displays with all menu items
    - Test that header displays with user dropdown
    - Test that authenticated user's name appears in dropdown
    - Test that FontAwesome and Tailwind CSS assets are included
    - Test that logout form is present
    - _Requirements: 1.1, 1.2, 1.3, 1.4, 2.3, 5.1, 5.3_
  
  - [ ]* 9.2 Test authentication integration
    - Test that unauthenticated users are redirected to login page
    - Test that authenticated users can access admin dashboard
    - Test that logout action works and redirects appropriately
    - _Requirements: 9.1, 9.2, 9.3, 9.4_
  
  - [ ]* 9.3 Test admin routes are protected
    - Test that all admin routes require authentication
    - Test that each admin route returns 200 status for authenticated users
    - Test that each admin route redirects to login for guests
    - _Requirements: 9.1, 9.4_
  
  - [ ]* 9.4 Test responsive CSS classes
    - Test that sidebar has mobile-responsive Tailwind classes
    - Test that mobile toggle button exists in markup
    - Test that content area has proper responsive margin classes
    - _Requirements: 7.1, 7.2, 7.5_

- [x] 10. Run Laravel Pint for code formatting
  - Run `vendor/bin/pint --dirty --format agent` to format all modified PHP files
  - Verify no formatting issues remain

- [x] 11. Final checkpoint - Run all tests
  - Run `php artisan test --compact` to verify all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for faster MVP
- Each task references specific requirements for traceability
- The layout uses Laravel Blade's template inheritance system for extensibility
- All styling uses Tailwind CSS v4 utility classes for consistency
- Authentication integration uses Laravel's built-in Auth system
- Manual testing is required for visual design verification and cross-browser compatibility
- Property-based testing is not applicable for this UI layout feature
