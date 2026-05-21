# Design Document: Admin Dashboard Layout

## Overview

The admin dashboard layout provides a professional, modern interface for authenticated administrators to manage the Laravel application's backend. The design implements a classic admin panel pattern with a fixed vertical sidebar for navigation, a top header bar for user controls, and a flexible content area for dynamic page content.

The layout uses Tailwind CSS v4 for styling, FontAwesome for icons, and Laravel Blade's template inheritance system for extensibility. The design prioritizes a premium aesthetic consistent with high-end SaaS applications while maintaining responsive behavior for mobile devices.

### Key Design Goals

1. **Professional Appearance**: Modern, high-end design aesthetic with consistent spacing, typography, and color schemes
2. **Responsive Behavior**: Seamless adaptation from desktop to mobile viewports with collapsible sidebar
3. **Developer Experience**: Clean Blade template structure that's easy to extend and maintain
4. **Authentication Integration**: Seamless integration with Laravel's existing authentication system
5. **Accessibility**: Clear visual affordances and keyboard-navigable interface elements

## Architecture

### Component Structure

The admin dashboard layout follows Laravel's Blade template inheritance pattern:

```
resources/views/layouts/admin.blade.php (Master Layout)
    ├── Sidebar Component (Navigation)
    ├── Top Header Component (User Controls)
    └── Content Area (@yield directive)
            └── Child Views (@extends)
```

### Technology Stack

- **Backend Framework**: Laravel 13.x
- **Template Engine**: Blade (Laravel's native templating)
- **CSS Framework**: Tailwind CSS v4
- **Icon Library**: FontAwesome 5.10.0
- **JavaScript**: Vanilla JS for mobile toggle (minimal)
- **Authentication**: Laravel's built-in Auth system

### Layout Flow

1. User authenticates via Laravel's auth system
2. Route middleware (`auth`) protects admin routes
3. Admin controller returns view extending `layouts.admin`
4. Master layout renders with sidebar, header, and content area
5. Child view content injected via `@yield('admin_content')`
6. User profile data passed from authenticated user object

## Components and Interfaces

### 1. Master Layout File

**File**: `resources/views/layouts/admin.blade.php`

**Responsibilities**:
- Define HTML document structure
- Include CSS and JavaScript dependencies
- Render sidebar, header, and content area
- Provide content injection points via `@yield` and `@stack`
- Pass authenticated user data to child views

**Key Directives**:
- `@yield('admin_content')` - Main content injection point
- `@stack('styles')` - Additional CSS injection
- `@stack('scripts')` - Additional JavaScript injection
- `{{ Auth::user() }}` - Access authenticated user

**Dependencies**:
```html
<!-- CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<!-- JavaScript (for mobile toggle) -->
<script>
  // Mobile sidebar toggle logic
</script>
```

### 2. Sidebar Navigation Component

**Structure**:
```html
<aside class="sidebar">
  <div class="sidebar-header">
    <!-- Logo/Brand -->
  </div>
  <nav class="sidebar-nav">
    <a href="{{ route('admin.dashboard') }}" class="nav-item">
      <i class="fas fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
    <!-- Additional menu items -->
  </nav>
</aside>
```

**Styling Requirements**:
- Background color: `#1a096e` (Dark Slate / Midnight Blue)
- Fixed width: `250px` on desktop
- Hover color: `#D08301` (Orange accent)
- Smooth transitions on hover (0.3s ease)
- Fixed positioning on desktop
- Collapsible on mobile (<768px)

**Menu Items**:
1. Dashboard - `fas fa-tachometer-alt`
2. News Management - `fas fa-newspaper`
3. Media/Gallery - `fas fa-images`
4. Departments - `fas fa-building`
5. Students - `fas fa-user-graduate`
6. Settings - `fas fa-cog`

**Active State Indication**:
- Use `request()->routeIs('admin.dashboard')` to detect active route
- Apply distinct background color or border to active item
- Maintain hover effect on non-active items

### 3. Top Header Component

**Structure**:
```html
<header class="top-header">
  <div class="header-content">
    <button class="mobile-toggle">
      <i class="fas fa-bars"></i>
    </button>
    <div class="header-right">
      <div class="user-dropdown">
        <button class="dropdown-trigger">
          <span>{{ Auth::user()->name }}</span>
          <i class="fas fa-chevron-down"></i>
        </button>
        <div class="dropdown-menu">
          <a href="{{ route('profile.edit') }}">Profile</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</header>
```

**Styling Requirements**:
- Background: White (`#ffffff`)
- Fixed positioning at top
- Height: `64px`
- Box shadow for depth: `0 2px 4px rgba(0,0,0,0.1)`
- Z-index: `1000` (above content, below sidebar on mobile)

**Dropdown Behavior**:
- Click to toggle dropdown visibility
- Close on outside click
- Smooth fade-in animation (0.2s)
- Position: absolute, right-aligned

### 4. Main Content Area

**Structure**:
```html
<main class="content-area">
  @yield('admin_content')
</main>
```

**Styling Requirements**:
- Background: Light gray (`#f4f7f6`)
- Margin-left: `250px` on desktop (sidebar width)
- Margin-top: `64px` (header height)
- Padding: `24px` (1.5rem)
- Min-height: `calc(100vh - 64px)`
- Full width on mobile

**Responsive Behavior**:
- Desktop (≥768px): Fixed left margin for sidebar
- Mobile (<768px): Full width, sidebar overlays when open

### 5. Mobile Toggle Button

**Visibility**:
- Hidden on desktop (≥768px)
- Visible on mobile (<768px)
- Positioned in top-left of header

**Functionality**:
```javascript
function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  sidebar.classList.toggle('mobile-open');
  
  // Optional: Add overlay
  const overlay = document.querySelector('.sidebar-overlay');
  overlay.classList.toggle('active');
}
```

**Overlay**:
- Semi-transparent black background (`rgba(0,0,0,0.5)`)
- Covers content area when sidebar is open
- Click to close sidebar
- Z-index: `999` (between content and sidebar)

## Data Models

### Authenticated User

The layout relies on Laravel's authenticated user object, accessed via `Auth::user()` or `auth()->user()`.

**Required User Properties**:
- `name` (string) - Displayed in user dropdown
- `email` (string) - Optional display in dropdown
- `id` (integer) - For user-specific operations

**Authentication Check**:
```php
@auth
  <!-- Authenticated content -->
@endauth

@guest
  <!-- Redirect to login -->
@endguest
```

### Route Structure

Admin routes should follow this pattern:

```php
// routes/web.php
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
});
```

## Error Handling

### Authentication Errors

**Unauthenticated Access**:
- Middleware redirects to login page
- Session stores intended URL for post-login redirect
- Flash message: "Please log in to access the admin panel"

**Session Expiration**:
- Middleware detects expired session
- Redirects to login with message
- Preserves form data where possible

### Layout Rendering Errors

**Missing User Data**:
```blade
{{ Auth::user()->name ?? 'Guest' }}
```

**Missing Routes**:
```blade
@if(Route::has('admin.dashboard'))
  <a href="{{ route('admin.dashboard') }}">Dashboard</a>
@endif
```

**Asset Loading Failures**:
- Provide fallback for CDN resources
- Use local copies as backup
- Graceful degradation for icons (text labels)

### JavaScript Errors

**Mobile Toggle Failure**:
- Ensure sidebar is visible by default on desktop
- Provide CSS-only fallback for mobile menu
- Log errors to console for debugging

## Testing Strategy

### Unit Tests

Since this feature is primarily UI layout and rendering, property-based testing is **not applicable**. Instead, we will use:

#### 1. Blade Component Tests

Test that the layout file renders correctly with required elements:

```php
// tests/Feature/AdminLayoutTest.php
public function test_admin_layout_renders_with_sidebar(): void
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('admin.dashboard'));
    
    $response->assertStatus(200);
    $response->assertSee('Dashboard');
    $response->assertSee('News Management');
    $response->assertSee($user->name);
}

public function test_admin_layout_includes_required_assets(): void
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('admin.dashboard'));
    
    $response->assertSee('font-awesome', false);
    $response->assertSee('tailwindcss', false);
}

public function test_admin_layout_has_logout_form(): void
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('admin.dashboard'));
    
    $response->assertSee('Logout');
    $response->assertSee(route('logout'), false);
}
```

#### 2. Authentication Integration Tests

Test that authentication is properly enforced:

```php
public function test_unauthenticated_users_cannot_access_admin_layout(): void
{
    $response = $this->get(route('admin.dashboard'));
    
    $response->assertRedirect(route('login'));
}

public function test_authenticated_users_can_access_admin_layout(): void
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('admin.dashboard'));
    
    $response->assertStatus(200);
}

public function test_logout_redirects_to_home(): void
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post(route('logout'));
    
    $response->assertRedirect('/');
    $this->assertGuest();
}
```

#### 3. Route Tests

Test that admin routes are properly protected:

```php
public function test_admin_routes_require_authentication(): void
{
    $routes = [
        'admin.dashboard',
        'admin.news.index',
        'admin.media.index',
        'admin.departments.index',
        'admin.students.index',
        'admin.settings.index',
    ];
    
    foreach ($routes as $routeName) {
        $response = $this->get(route($routeName));
        $response->assertRedirect(route('login'));
    }
}
```

#### 4. Responsive Behavior Tests

Test CSS classes for responsive design:

```php
public function test_sidebar_has_mobile_responsive_classes(): void
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('admin.dashboard'));
    
    // Check for Tailwind responsive classes
    $response->assertSee('md:block', false); // Sidebar visible on desktop
    $response->assertSee('hidden', false); // Hidden on mobile
}

public function test_mobile_toggle_button_exists(): void
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('admin.dashboard'));
    
    $response->assertSee('mobile-toggle', false);
    $response->assertSee('fa-bars', false);
}
```

### Integration Tests

#### 1. Full Page Rendering

Test that child views properly extend the admin layout:

```php
public function test_dashboard_page_extends_admin_layout(): void
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('admin.dashboard'));
    
    // Should have layout elements
    $response->assertSee('Dashboard'); // Sidebar
    $response->assertSee($user->name); // Header
    
    // Should have page-specific content
    $response->assertSee('Welcome to Admin Dashboard');
}
```

#### 2. Navigation Tests

Test that navigation links work correctly:

```php
public function test_sidebar_navigation_links_are_functional(): void
{
    $user = User::factory()->create();
    
    $this->actingAs($user);
    
    // Test each navigation link
    $this->get(route('admin.dashboard'))->assertStatus(200);
    $this->get(route('admin.news.index'))->assertStatus(200);
    $this->get(route('admin.media.index'))->assertStatus(200);
}

public function test_active_navigation_item_is_highlighted(): void
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('admin.news.index'));
    
    // Check for active class on news menu item
    $response->assertSee('active', false);
}
```

### Manual Testing Checklist

Since UI appearance and responsive behavior cannot be fully automated, manual testing is required:

1. **Visual Design**:
   - [ ] Sidebar has correct background color (#1a096e)
   - [ ] Hover effects work smoothly with orange accent (#D08301)
   - [ ] Typography is consistent and readable
   - [ ] Spacing and padding are visually balanced
   - [ ] Icons align properly with text labels

2. **Responsive Behavior**:
   - [ ] Desktop view (≥768px): Sidebar fixed, content area adjusted
   - [ ] Tablet view (768px-1024px): Layout remains functional
   - [ ] Mobile view (<768px): Sidebar collapses, toggle button appears
   - [ ] Sidebar slides smoothly on mobile toggle
   - [ ] Overlay appears and functions correctly

3. **Interactive Elements**:
   - [ ] User dropdown opens/closes on click
   - [ ] Dropdown closes when clicking outside
   - [ ] Logout button triggers logout action
   - [ ] Navigation links navigate to correct pages
   - [ ] Active page is visually indicated in sidebar

4. **Cross-Browser Testing**:
   - [ ] Chrome/Edge (latest)
   - [ ] Firefox (latest)
   - [ ] Safari (latest)
   - [ ] Mobile Safari (iOS)
   - [ ] Chrome Mobile (Android)

5. **Accessibility**:
   - [ ] Keyboard navigation works (Tab, Enter, Escape)
   - [ ] Focus indicators are visible
   - [ ] Color contrast meets WCAG AA standards
   - [ ] Screen reader announces navigation items correctly

### Browser Testing

Use Laravel Dusk for browser automation tests (optional):

```php
public function test_mobile_sidebar_toggle_works(): void
{
    $user = User::factory()->create();
    
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
                ->visit(route('admin.dashboard'))
                ->resize(375, 667) // Mobile size
                ->assertDontSee('Dashboard') // Sidebar hidden
                ->click('.mobile-toggle')
                ->waitFor('.sidebar.mobile-open')
                ->assertSee('Dashboard'); // Sidebar visible
    });
}
```

### Test Coverage Goals

- **Unit Tests**: 100% coverage of authentication logic
- **Integration Tests**: All admin routes tested
- **Manual Tests**: Complete responsive behavior verification
- **Browser Tests**: Critical user flows (login, navigation, logout)

### Why Property-Based Testing Is Not Applicable

This feature is **not suitable for property-based testing** because:

1. **UI Rendering**: The feature is primarily about HTML/CSS layout, which is declarative rather than algorithmic
2. **No Universal Properties**: There are no mathematical or logical properties that hold across all inputs
3. **Visual Validation**: Correctness is determined by visual appearance, not computable properties
4. **Better Alternatives**: Snapshot tests, visual regression tests, and example-based integration tests are more appropriate

Instead, we rely on:
- **Example-based unit tests** for specific scenarios
- **Integration tests** for authentication and routing
- **Manual testing** for visual design and responsive behavior
- **Browser tests** (optional) for interactive elements
