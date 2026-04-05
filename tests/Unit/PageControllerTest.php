<?php

namespace Tests\Unit;

use App\Http\Controllers\PageController;
use App\Models\Page;
use App\Models\User;
use App\Services\PageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    private PageController $controller;
    private PageService $pageService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pageService = app(PageService::class);
        $this->controller = new PageController($this->pageService);
    }

    public function test_show_returns_published_page_with_content_blocks(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        // Create a published page
        $page = Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'en',
            'status' => 'published',
            'published_at' => now(),
            'created_by' => $user->id,
        ]);

        $request = Request::create('/test-page', 'GET');

        $response = $this->controller->show($request, 'test-page');

        $this->assertEquals('pages.show', $response->name());
        $this->assertEquals($page->id, $response->getData()['page']->id);
        $this->assertEquals('test-page', $response->getData()['currentPage']);
    }

    public function test_show_uses_language_from_request(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        // Create Arabic page
        $page = Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'ar',
            'status' => 'published',
            'published_at' => now(),
            'created_by' => $user->id,
        ]);

        $request = Request::create('/test-page?language=ar', 'GET', ['language' => 'ar']);

        $response = $this->controller->show($request, 'test-page');

        $this->assertEquals('pages.show', $response->name());
        $this->assertEquals($page->id, $response->getData()['page']->id);
        $this->assertEquals('ar', $response->getData()['page']->language);
    }

    public function test_show_defaults_to_current_locale(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        app()->setLocale('en');

        $page = Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'en',
            'status' => 'published',
            'published_at' => now(),
            'created_by' => $user->id,
        ]);

        $request = Request::create('/test-page', 'GET');

        $response = $this->controller->show($request, 'test-page');

        $this->assertEquals('pages.show', $response->name());
        $this->assertEquals($page->id, $response->getData()['page']->id);
    }

    public function test_show_returns_404_for_nonexistent_page(): void
    {
        $request = Request::create('/nonexistent-page', 'GET');

        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);

        $this->controller->show($request, 'nonexistent-page');
    }

    public function test_show_returns_404_for_draft_page(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        // Create a draft page
        Page::factory()->create([
            'slug' => 'draft-page',
            'language' => 'en',
            'status' => 'draft',
            'created_by' => $user->id,
        ]);

        $request = Request::create('/draft-page', 'GET');

        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);

        $this->controller->show($request, 'draft-page');
    }

    public function test_show_returns_404_for_archived_page(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        // Create an archived page
        Page::factory()->create([
            'slug' => 'archived-page',
            'language' => 'en',
            'status' => 'archived',
            'created_by' => $user->id,
        ]);

        $request = Request::create('/archived-page', 'GET');

        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);

        $this->controller->show($request, 'archived-page');
    }

    public function test_show_passes_current_page_for_navbar_highlighting(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        $page = Page::factory()->create([
            'slug' => 'about-us',
            'language' => 'en',
            'status' => 'published',
            'published_at' => now(),
            'created_by' => $user->id,
        ]);

        $request = Request::create('/about-us', 'GET');

        $response = $this->controller->show($request, 'about-us');

        $this->assertEquals('about-us', $response->getData()['currentPage']);
    }

    public function test_show_eager_loads_content_blocks(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        $page = Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'en',
            'status' => 'published',
            'published_at' => now(),
            'created_by' => $user->id,
        ]);

        // Create content blocks
        $page->contentBlocks()->create([
            'type' => 'hero',
            'content' => ['title' => 'Test Hero', 'description' => 'Test Description', 'image' => 'test.jpg'],
            'display_order' => 1,
            'created_by' => $user->id,
        ]);

        $request = Request::create('/test-page', 'GET');

        $response = $this->controller->show($request, 'test-page');

        $pageData = $response->getData()['page'];
        $this->assertTrue($pageData->relationLoaded('contentBlocks'));
        $this->assertCount(1, $pageData->contentBlocks);
    }
}
