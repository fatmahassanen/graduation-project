<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\Revision;
use App\Models\User;
use App\Services\PageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageCreationWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected PageService $pageService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'super_admin']);
        $this->pageService = app(PageService::class);
    }

    public function test_page_creation_workflow_creates_page_with_content_blocks(): void
    {
        // Create a page with content blocks
        $pageData = [
            'title' => 'Test Page',
            'slug' => 'test-page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'en',
            'meta_title' => 'Test Meta Title',
            'meta_description' => 'Test meta description',
        ];

        $page = $this->pageService->createPage($pageData, $this->user);

        // Verify page was created
        $this->assertDatabaseHas('pages', [
            'title' => 'Test Page',
            'slug' => 'test-page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'en',
            'created_by' => $this->user->id,
        ]);

        // Create content blocks for the page
        $heroBlock = ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Hero Title',
                'description' => 'Hero Description',
                'image' => '/img/hero.jpg',
            ],
            'display_order' => 1,
            'created_by' => $this->user->id,
        ]);

        $textBlock = ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'text',
            'content' => [
                'body' => '<p>This is the main content.</p>',
            ],
            'display_order' => 2,
            'created_by' => $this->user->id,
        ]);

        // Verify content blocks were created
        $this->assertDatabaseHas('content_blocks', [
            'page_id' => $page->id,
            'type' => 'hero',
            'display_order' => 1,
        ]);

        $this->assertDatabaseHas('content_blocks', [
            'page_id' => $page->id,
            'type' => 'text',
            'display_order' => 2,
        ]);

        // Verify page has correct number of content blocks
        $this->assertCount(2, $page->contentBlocks);
    }

    public function test_page_creation_workflow_creates_revision(): void
    {
        $pageData = [
            'title' => 'Test Page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'en',
        ];

        $page = $this->pageService->createPage($pageData, $this->user);

        // Verify revision was created
        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => Page::class,
            'revisionable_id' => $page->id,
            'user_id' => $this->user->id,
            'action' => 'created',
        ]);

        // Verify revision contains new values
        $revision = Revision::where('revisionable_type', Page::class)
            ->where('revisionable_id', $page->id)
            ->first();

        $this->assertNotNull($revision);
        $this->assertEquals('created', $revision->action);
        $this->assertIsArray($revision->new_values);
        $this->assertEquals('Test Page', $revision->new_values['title']);
    }

    public function test_page_creation_workflow_creates_audit_log(): void
    {
        $this->actingAs($this->user);

        $pageData = [
            'title' => 'Test Page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'en',
        ];

        $page = $this->pageService->createPage($pageData, $this->user);

        // Verify audit log was created
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $this->user->id,
            'action' => 'created',
            'model_type' => Page::class,
            'model_id' => $page->id,
        ]);

        // Verify audit log contains details
        $auditLog = AuditLog::where('model_type', Page::class)
            ->where('model_id', $page->id)
            ->first();

        $this->assertNotNull($auditLog);
        $this->assertEquals('created', $auditLog->action);
        $this->assertIsArray($auditLog->new_values);
    }

    public function test_complete_page_creation_workflow_with_all_components(): void
    {
        $this->actingAs($this->user);

        // Step 1: Create page
        $pageData = [
            'title' => 'Complete Test Page',
            'category' => 'faculties',
            'status' => 'draft',
            'language' => 'en',
            'meta_title' => 'Complete Meta Title',
            'meta_description' => 'Complete meta description',
        ];

        $page = $this->pageService->createPage($pageData, $this->user);

        // Step 2: Add multiple content blocks
        ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => ['title' => 'Hero', 'description' => 'Hero desc'],
            'display_order' => 1,
            'created_by' => $this->user->id,
        ]);

        ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'card_grid',
            'content' => [
                'columns' => 3,
                'cards' => [
                    ['title' => 'Card 1', 'description' => 'Desc 1'],
                    ['title' => 'Card 2', 'description' => 'Desc 2'],
                ],
            ],
            'display_order' => 2,
            'created_by' => $this->user->id,
        ]);

        ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'faq',
            'content' => [
                'items' => [
                    ['question' => 'Q1?', 'answer' => 'A1'],
                    ['question' => 'Q2?', 'answer' => 'A2'],
                ],
            ],
            'display_order' => 3,
            'created_by' => $this->user->id,
        ]);

        // Verify complete workflow
        $page->refresh();

        // Assert page exists with correct data
        $this->assertEquals('Complete Test Page', $page->title);
        $this->assertEquals('faculties', $page->category);
        $this->assertEquals('draft', $page->status);

        // Assert content blocks are created and ordered
        $this->assertCount(3, $page->contentBlocks);
        $blocks = $page->contentBlocks;
        $this->assertEquals('hero', $blocks[0]->type);
        $this->assertEquals('card_grid', $blocks[1]->type);
        $this->assertEquals('faq', $blocks[2]->type);

        // Assert revision was created
        $this->assertCount(1, $page->revisions);
        $this->assertEquals('created', $page->revisions->first()->action);

        // Assert audit log was created
        $auditLog = AuditLog::where('model_type', Page::class)
            ->where('model_id', $page->id)
            ->first();
        $this->assertNotNull($auditLog);
        $this->assertEquals('created', $auditLog->action);
    }
}
