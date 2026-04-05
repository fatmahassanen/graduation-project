<?php

namespace Tests\Unit;

use App\Models\Page;
use App\Models\User;
use App\Services\PageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CachingPropertyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Property 33: Cache Invalidation on Content Update
     * 
     * For any content update, affected page caches SHALL be cleared.
     * 
     * Validates: Requirements 18.2
     */
    public function test_property_33_cache_invalidation_on_content_update(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);
        $pageService = app(PageService::class);

        // Create a page
        $page = Page::factory()->create([
            'title' => 'Test Page',
            'slug' => 'test-page',
            'status' => 'published',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        // First request - should cache the page
        $cachedPage1 = $pageService->getPublishedPageBySlug('test-page', 'en');
        $this->assertNotNull($cachedPage1);
        $this->assertEquals('Test Page', $cachedPage1->title);

        // Verify cache exists
        $cacheKey = 'page:test-page:en';
        $this->assertTrue(Cache::has($cacheKey));

        // Update the page (preserve slug to test cache invalidation)
        $pageService->updatePage($page, ['title' => 'Updated Test Page', 'slug' => 'test-page'], $user);

        // Cache should be invalidated
        $this->assertFalse(Cache::has($cacheKey), 'Cache should be invalidated after update');

        // Second request - should fetch fresh data
        $cachedPage2 = $pageService->getPublishedPageBySlug('test-page', 'en');
        $this->assertNotNull($cachedPage2);
        $this->assertEquals('Updated Test Page', $cachedPage2->title);
    }

    /**
     * Property 33 Extended: Cache invalidation on publish
     */
    public function test_property_33_cache_invalidation_on_publish(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);
        $pageService = app(PageService::class);

        // Create a draft page
        $page = Page::factory()->create([
            'title' => 'Draft Page',
            'slug' => 'draft-page',
            'status' => 'draft',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        // Publish the page
        $pageService->publishPage($page, $user);

        // Cache key should not exist yet (no one has requested it)
        $cacheKey = 'page:draft-page:en';
        $this->assertFalse(Cache::has($cacheKey));

        // Request the page - should cache it
        $cachedPage = $pageService->getPublishedPageBySlug('draft-page', 'en');
        $this->assertNotNull($cachedPage);
        $this->assertTrue(Cache::has($cacheKey));

        // Unpublish the page
        $pageService->unpublishPage($page, $user);

        // Cache should be invalidated
        $this->assertFalse(Cache::has($cacheKey), 'Cache should be invalidated after unpublish');
    }

    /**
     * Property 33 Extended: Cache invalidation on archive
     */
    public function test_property_33_cache_invalidation_on_archive(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);
        $pageService = app(PageService::class);

        // Create a published page
        $page = Page::factory()->create([
            'title' => 'Published Page',
            'slug' => 'published-page',
            'status' => 'published',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        // Request the page - should cache it
        $cachedPage = $pageService->getPublishedPageBySlug('published-page', 'en');
        $this->assertNotNull($cachedPage);

        $cacheKey = 'page:published-page:en';
        $this->assertTrue(Cache::has($cacheKey));

        // Archive the page
        $pageService->archivePage($page, $user);

        // Cache should be invalidated
        $this->assertFalse(Cache::has($cacheKey), 'Cache should be invalidated after archive');
    }

    /**
     * Property 33 Extended: Multiple language cache invalidation
     */
    public function test_property_33_multiple_language_cache_invalidation(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);
        $pageService = app(PageService::class);

        // Create pages in different languages with same slug
        $pageEn = Page::factory()->create([
            'title' => 'Test Page EN',
            'slug' => 'test-page',
            'status' => 'published',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        $pageAr = Page::factory()->create([
            'title' => 'Test Page AR',
            'slug' => 'test-page',
            'status' => 'published',
            'language' => 'ar',
            'created_by' => $user->id,
        ]);

        // Cache both versions
        $pageService->getPublishedPageBySlug('test-page', 'en');
        $pageService->getPublishedPageBySlug('test-page', 'ar');

        $cacheKeyEn = 'page:test-page:en';
        $cacheKeyAr = 'page:test-page:ar';

        $this->assertTrue(Cache::has($cacheKeyEn));
        $this->assertTrue(Cache::has($cacheKeyAr));

        // Update English version
        $pageService->updatePage($pageEn, ['title' => 'Updated EN'], $user);

        // Only English cache should be invalidated
        $this->assertFalse(Cache::has($cacheKeyEn), 'English cache should be invalidated');
        $this->assertTrue(Cache::has($cacheKeyAr), 'Arabic cache should remain');
    }
}
