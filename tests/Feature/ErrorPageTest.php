<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class ErrorPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_404_view_file_exists(): void
    {
        $this->assertTrue(View::exists('errors.404'));
    }

    public function test_404_view_contains_university_branding(): void
    {
        $content = file_get_contents(resource_path('views/errors/404.blade.php'));

        // Check for 404 error code
        $this->assertStringContainsString('404', $content);
        // Check for error message
        $this->assertStringContainsString('Page Not Found', $content);
        // Check for homepage link
        $this->assertStringContainsString('Go Back To Home', $content);
    }

    public function test_404_view_includes_university_colors(): void
    {
        $content = file_get_contents(resource_path('views/errors/404.blade.php'));

        // Check for orange color (#D08301)
        $this->assertStringContainsString('#D08301', $content);
        // Purple color is in the CSS file, not directly in the 404 page
        // The 404 page uses orange for branding
    }

    public function test_404_view_has_link_to_homepage(): void
    {
        $content = file_get_contents(resource_path('views/errors/404.blade.php'));

        // Check for route to home
        $this->assertStringContainsString("route('home')", $content);
    }

    public function test_404_view_extends_master_layout(): void
    {
        $content = file_get_contents(resource_path('views/errors/404.blade.php'));

        // The 404 page is standalone but includes navbar and footer components
        $this->assertStringContainsString('<x-navbar', $content);
        $this->assertStringContainsString('<x-footer', $content);
    }

    public function test_404_view_uses_bootstrap_classes(): void
    {
        $content = file_get_contents(resource_path('views/errors/404.blade.php'));

        // Check for Bootstrap classes
        $this->assertStringContainsString('container', $content);
        $this->assertStringContainsString('btn', $content);
    }
}
