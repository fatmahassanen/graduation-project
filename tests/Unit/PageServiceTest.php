<?php

namespace Tests\Unit;

use App\Models\Page;
use App\Models\User;
use App\Services\PageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PageService $pageService;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pageService = app(PageService::class);
        $this->user = User::factory()->create(['role' => 'super_admin']);
    }

    public function test_create_page_generates_slug_from_title(): void
    {
        $data = [
            'title' => 'About University',
            'category' => 'about',
            'status' => 'draft',
            'language' => 'en',
        ];

        $page = $this->pageService->createPage($data, $this->user);

        $this->assertEquals('about-university', $page->slug);
        $this->assertEquals('About University', $page->title);
        $this->assertEquals($this->user->id, $page->created_by);
    }

    public function test_create_page_uses_provided_slug(): void
    {
        $data = [
            'title' => 'About University',
            'slug' => 'custom-slug',
            'category' => 'about',
            'status' => 'draft',
            'language' => 'en',
        ];

        $page = $this->pageService->createPage($data, $this->user);

        $this->assertEquals('custom-slug', $page->slug);
    }

    public function test_create_page_creates_revision(): void
    {
        $data = [
            'title' => 'Test Page',
            'category' => 'about',
            'status' => 'draft',
            'language' => 'en',
        ];

        $page = $this->pageService->createPage($data, $this->user);

        $this->assertCount(1, $page->revisions);
        $this->assertEquals('created', $page->revisions->first()->action);
        $this->assertEquals($this->user->id, $page->revisions->first()->user_id);
    }

    public function test_update_page_updates_fields(): void
    {
        $page = Page::factory()->create([
            'title' => 'Original Title',
            'status' => 'draft',
        ]);

        $updatedPage = $this->pageService->updatePage($page, [
            'title' => 'Updated Title',
        ], $this->user);

        $this->assertEquals('Updated Title', $updatedPage->title);
        $this->assertEquals($this->user->id, $updatedPage->updated_by);
    }

    public function test_update_page_creates_revision(): void
    {
        $page = Page::factory()->create(['title' => 'Original']);

        $this->pageService->updatePage($page, ['title' => 'Updated'], $this->user);

        $page->refresh();
        $this->assertCount(1, $page->revisions);
        $this->assertEquals('updated', $page->revisions->first()->action);
    }

    public function test_publish_page_sets_status_and_published_at(): void
    {
        $page = Page::factory()->create(['status' => 'draft']);

        $publishedPage = $this->pageService->publishPage($page, $this->user);

        $this->assertEquals('published', $publishedPage->status);
        $this->assertNotNull($publishedPage->published_at);
        $this->assertEquals($this->user->id, $publishedPage->updated_by);
    }

    public function test_publish_page_creates_revision(): void
    {
        $page = Page::factory()->create(['status' => 'draft']);

        $this->pageService->publishPage($page, $this->user);

        $page->refresh();
        $this->assertCount(1, $page->revisions);
        $this->assertEquals('published', $page->revisions->first()->action);
    }

    public function test_unpublish_page_sets_status_to_draft(): void
    {
        $page = Page::factory()->create(['status' => 'published']);

        $unpublishedPage = $this->pageService->unpublishPage($page, $this->user);

        $this->assertEquals('draft', $unpublishedPage->status);
        $this->assertEquals($this->user->id, $unpublishedPage->updated_by);
    }

    public function test_unpublish_page_creates_revision(): void
    {
        $page = Page::factory()->create(['status' => 'published']);

        $this->pageService->unpublishPage($page, $this->user);

        $page->refresh();
        $this->assertCount(1, $page->revisions);
        $this->assertEquals('unpublished', $page->revisions->first()->action);
    }

    public function test_archive_page_sets_status_to_archived(): void
    {
        $page = Page::factory()->create(['status' => 'published']);

        $archivedPage = $this->pageService->archivePage($page, $this->user);

        $this->assertEquals('archived', $archivedPage->status);
        $this->assertEquals($this->user->id, $archivedPage->updated_by);
    }

    public function test_archive_page_creates_revision(): void
    {
        $page = Page::factory()->create(['status' => 'published']);

        $this->pageService->archivePage($page, $this->user);

        $page->refresh();
        $this->assertCount(1, $page->revisions);
        $this->assertEquals('updated', $page->revisions->first()->action);
    }

    public function test_get_published_page_by_slug_returns_published_page(): void
    {
        Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'en',
            'status' => 'published',
        ]);

        $page = $this->pageService->getPublishedPageBySlug('test-page', 'en');

        $this->assertNotNull($page);
        $this->assertEquals('test-page', $page->slug);
    }

    public function test_get_published_page_by_slug_returns_null_for_draft(): void
    {
        Page::factory()->create([
            'slug' => 'draft-page',
            'language' => 'en',
            'status' => 'draft',
        ]);

        $page = $this->pageService->getPublishedPageBySlug('draft-page', 'en');

        $this->assertNull($page);
    }

    public function test_get_published_page_by_slug_returns_null_for_wrong_language(): void
    {
        Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'en',
            'status' => 'published',
        ]);

        $page = $this->pageService->getPublishedPageBySlug('test-page', 'ar');

        $this->assertNull($page);
    }

    public function test_get_pages_by_category_returns_published_pages_only(): void
    {
        Page::factory()->create([
            'category' => 'admissions',
            'language' => 'en',
            'status' => 'published',
        ]);
        Page::factory()->create([
            'category' => 'admissions',
            'language' => 'en',
            'status' => 'draft',
        ]);
        Page::factory()->create([
            'category' => 'faculties',
            'language' => 'en',
            'status' => 'published',
        ]);

        $pages = $this->pageService->getPagesByCategory('admissions', 'en');

        $this->assertCount(1, $pages);
        $this->assertEquals('admissions', $pages->first()->category);
    }

    public function test_generate_unique_slug_creates_url_safe_slug(): void
    {
        $slug = $this->pageService->generateUniqueSlug('About University!');

        $this->assertEquals('about-university', $slug);
    }

    public function test_generate_unique_slug_adds_numeric_suffix_for_duplicates(): void
    {
        Page::factory()->create(['slug' => 'about-university']);

        $slug = $this->pageService->generateUniqueSlug('About University');

        $this->assertEquals('about-university-1', $slug);
    }

    public function test_generate_unique_slug_increments_suffix_for_multiple_duplicates(): void
    {
        Page::factory()->create(['slug' => 'about-university']);
        Page::factory()->create(['slug' => 'about-university-1']);
        Page::factory()->create(['slug' => 'about-university-2']);

        $slug = $this->pageService->generateUniqueSlug('About University');

        $this->assertEquals('about-university-3', $slug);
    }

    public function test_generate_unique_slug_excludes_current_page_id(): void
    {
        $page = Page::factory()->create(['slug' => 'about-university']);

        $slug = $this->pageService->generateUniqueSlug('About University', $page->id);

        $this->assertEquals('about-university', $slug);
    }

    public function test_update_page_regenerates_slug_when_title_changes(): void
    {
        $page = Page::factory()->create([
            'title' => 'Original Title',
            'slug' => 'original-title',
        ]);

        $updatedPage = $this->pageService->updatePage($page, [
            'title' => 'New Title',
        ], $this->user);

        $this->assertEquals('new-title', $updatedPage->slug);
    }

    public function test_update_page_keeps_custom_slug_when_provided(): void
    {
        $page = Page::factory()->create([
            'title' => 'Original Title',
            'slug' => 'original-title',
        ]);

        $updatedPage = $this->pageService->updatePage($page, [
            'title' => 'New Title',
            'slug' => 'custom-slug',
        ], $this->user);

        $this->assertEquals('custom-slug', $updatedPage->slug);
    }
}
