<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiLanguageSupportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test user
        $this->user = User::factory()->create(['role' => 'super_admin']);
    }

    public function test_language_switcher_displays_available_languages(): void
    {
        // Create a page in English
        $page = Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'en',
            'status' => 'published',
        ]);

        $response = $this->get(route('page.show', ['slug' => 'test-page']));

        $response->assertStatus(200);
        $response->assertSee('English');
        $response->assertSee('العربية');
    }

    public function test_language_switch_route_changes_locale(): void
    {
        $response = $this->get(route('language.switch', ['lang' => 'ar']));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('locale', 'ar');
    }

    public function test_language_switch_redirects_to_translated_page(): void
    {
        // Create pages in both languages
        Page::factory()->create([
            'slug' => 'about',
            'language' => 'en',
            'status' => 'published',
            'title' => 'About Us',
        ]);

        Page::factory()->create([
            'slug' => 'about',
            'language' => 'ar',
            'status' => 'published',
            'title' => 'معلومات عنا',
        ]);

        $response = $this->get(route('language.switch', ['lang' => 'ar', 'slug' => 'about']));

        $response->assertRedirect(route('page.show', ['slug' => 'about', 'language' => 'ar']));
    }

    public function test_displays_translation_unavailable_message_when_page_not_in_requested_language(): void
    {
        // Create page only in English
        Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'en',
            'status' => 'published',
            'title' => 'Test Page',
        ]);

        // Request the page in Arabic
        $response = $this->get(route('page.show', ['slug' => 'test-page', 'language' => 'ar']));

        $response->assertStatus(200);
        $response->assertSee('Translation Not Available');
        $response->assertSee('This page is not available in Arabic');
    }

    public function test_middleware_sets_locale_from_url_parameter(): void
    {
        Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'ar',
            'status' => 'published',
        ]);

        $this->get(route('page.show', ['slug' => 'test-page', 'language' => 'ar']));

        $this->assertEquals('ar', app()->getLocale());
    }

    public function test_middleware_sets_locale_from_session(): void
    {
        // This test verifies that when a user has a language preference in their session,
        // subsequent requests will use that language preference.
        
        // Create pages in both languages
        Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'en',
            'status' => 'published',
        ]);
        
        Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'ar',
            'status' => 'published',
        ]);

        // Simulate a user who has switched to Arabic (which sets session)
        $this->get(route('language.switch', ['lang' => 'ar', 'slug' => 'test-page']));
        
        // Now make a request to a page - it should use the Arabic locale from session
        $response = $this->get(route('page.show', ['slug' => 'test-page']));
        
        $response->assertStatus(200);
        // The page should be rendered in Arabic (RTL)
        $response->assertSee('dir="rtl"', false);
    }

    public function test_middleware_defaults_to_english_when_no_language_specified(): void
    {
        Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'en',
            'status' => 'published',
        ]);

        $this->get(route('page.show', ['slug' => 'test-page']));

        $this->assertEquals('en', app()->getLocale());
    }

    public function test_layout_has_rtl_attribute_for_arabic(): void
    {
        Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'ar',
            'status' => 'published',
        ]);

        $response = $this->get(route('page.show', ['slug' => 'test-page', 'language' => 'ar']));

        $response->assertStatus(200);
        $response->assertSee('dir="rtl"', false);
    }

    public function test_layout_has_ltr_attribute_for_english(): void
    {
        Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'en',
            'status' => 'published',
        ]);

        $response = $this->get(route('page.show', ['slug' => 'test-page', 'language' => 'en']));

        $response->assertStatus(200);
        $response->assertSee('dir="ltr"', false);
    }

    public function test_invalid_language_code_defaults_to_english(): void
    {
        $response = $this->get(route('language.switch', ['lang' => 'invalid']));

        $response->assertStatus(400);
    }

    public function test_language_preference_persists_in_session(): void
    {
        // Switch to Arabic
        $this->get(route('language.switch', ['lang' => 'ar']));

        // Make another request without language parameter
        Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'ar',
            'status' => 'published',
        ]);

        $response = $this->get(route('page.show', ['slug' => 'test-page']));

        $this->assertEquals('ar', app()->getLocale());
    }
}
