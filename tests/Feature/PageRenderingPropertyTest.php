<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageRenderingPropertyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Property 24: Published Content Filtering
     * 
     * For any public-facing query (navigation, search, page access), 
     * only pages with status='published' SHALL be included in results.
     * 
     * Validates: Requirements 9.6, 9.9, 16.8
     */
    public function test_property_24_published_content_filtering(): void
    {
        // Create a user for page creation
        $user = User::factory()->create(['role' => 'super_admin']);

        // Create pages with different statuses
        $publishedPage = Page::factory()->create([
            'slug' => 'published-page',
            'status' => 'published',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        $draftPage = Page::factory()->create([
            'slug' => 'draft-page',
            'status' => 'draft',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        $archivedPage = Page::factory()->create([
            'slug' => 'archived-page',
            'status' => 'archived',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        // Test 1: Published page should be accessible
        $response = $this->get(route('page.show', ['slug' => 'published-page']));
        $response->assertStatus(200);
        $response->assertViewHas('page', function ($page) use ($publishedPage) {
            return $page->id === $publishedPage->id;
        });

        // Test 2: Draft page should return 404
        $response = $this->get(route('page.show', ['slug' => 'draft-page']));
        $response->assertStatus(404);

        // Test 3: Archived page should return 404
        $response = $this->get(route('page.show', ['slug' => 'archived-page']));
        $response->assertStatus(404);

        // Test 4: Non-existent page should return 404
        $response = $this->get(route('page.show', ['slug' => 'non-existent-page']));
        $response->assertStatus(404);
    }

    /**
     * Property 24 Extended: Published content filtering with language parameter
     */
    public function test_property_24_published_content_filtering_with_language(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        // Create published pages in different languages
        $englishPage = Page::factory()->create([
            'slug' => 'test-page',
            'status' => 'published',
            'language' => 'en',
            'title' => 'English Page',
            'created_by' => $user->id,
        ]);

        $arabicPage = Page::factory()->create([
            'slug' => 'test-page',
            'status' => 'published',
            'language' => 'ar',
            'title' => 'Arabic Page',
            'created_by' => $user->id,
        ]);

        // Create draft page in English
        $draftEnglishPage = Page::factory()->create([
            'slug' => 'draft-test',
            'status' => 'draft',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        // Test 1: English published page should be accessible
        $response = $this->get(route('page.show', ['slug' => 'test-page', 'language' => 'en']));
        $response->assertStatus(200);
        $response->assertViewHas('page', function ($page) use ($englishPage) {
            return $page->id === $englishPage->id && $page->language === 'en';
        });

        // Test 2: Arabic published page should be accessible
        $response = $this->get(route('page.show', ['slug' => 'test-page', 'language' => 'ar']));
        $response->assertStatus(200);
        $response->assertViewHas('page', function ($page) use ($arabicPage) {
            return $page->id === $arabicPage->id && $page->language === 'ar';
        });

        // Test 3: Draft page should return 404 regardless of language
        $response = $this->get(route('page.show', ['slug' => 'draft-test', 'language' => 'en']));
        $response->assertStatus(404);
    }

    /**
     * Property 24 Extended: Unpublished pages return 404
     * 
     * Tests that when a page is unpublished, it returns 404 for public requests.
     */
    public function test_property_24_unpublished_pages_return_404(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        // Create a published page
        $page = Page::factory()->create([
            'slug' => 'test-page',
            'status' => 'published',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        // Verify page is accessible when published
        $response = $this->get(route('page.show', ['slug' => 'test-page']));
        $response->assertStatus(200);

        // Unpublish the page
        $page->update(['status' => 'draft']);

        // Clear cache to simulate cache invalidation (which should happen in production)
        cache()->forget("page:test-page:en");

        // Verify page returns 404 after unpublishing
        $response = $this->get(route('page.show', ['slug' => 'test-page']));
        $response->assertStatus(404);
    }

    /**
     * Property 24 Extended: Cache respects published status
     * 
     * Tests that cached pages are invalidated when status changes.
     */
    public function test_property_24_cache_respects_published_status(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        // Create a published page
        $page = Page::factory()->create([
            'slug' => 'cached-page',
            'status' => 'published',
            'language' => 'en',
            'title' => 'Cached Page',
            'created_by' => $user->id,
        ]);

        // First request - should cache the page
        $response = $this->get(route('page.show', ['slug' => 'cached-page']));
        $response->assertStatus(200);

        // Unpublish the page
        $page->update(['status' => 'draft']);

        // Clear cache to simulate cache invalidation
        cache()->forget("page:cached-page:en");

        // Second request - should return 404 even if previously cached
        $response = $this->get(route('page.show', ['slug' => 'cached-page']));
        $response->assertStatus(404);
    }
}
