<?php

namespace Tests\Unit;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use App\Services\RevisionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RevisionServicePolymorphicTest extends TestCase
{
    use RefreshDatabase;

    protected RevisionService $service;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new RevisionService();
        $this->user = User::factory()->create();
    }

    public function test_works_with_page_model(): void
    {
        $page = Page::factory()->create(['title' => 'Test Page']);
        
        $revision = $this->service->createRevision(
            $page,
            [],
            ['title' => 'Test Page'],
            $this->user
        );

        $this->assertEquals(Page::class, $revision->revisionable_type);
        $this->assertEquals($page->id, $revision->revisionable_id);
        $this->assertInstanceOf(Page::class, $revision->revisionable);
    }

    public function test_works_with_content_block_model(): void
    {
        $page = Page::factory()->create();
        $block = ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'text',
            'content' => ['content' => 'Test content'],
        ]);
        
        $revision = $this->service->createRevision(
            $block,
            [],
            ['content' => ['content' => 'Test content']],
            $this->user
        );

        $this->assertEquals(ContentBlock::class, $revision->revisionable_type);
        $this->assertEquals($block->id, $revision->revisionable_id);
        $this->assertInstanceOf(ContentBlock::class, $revision->revisionable);
    }

    public function test_get_revision_history_works_for_content_blocks(): void
    {
        $page = Page::factory()->create();
        $block = ContentBlock::factory()->create(['page_id' => $page->id]);
        
        $this->service->createRevision($block, [], ['type' => 'text'], $this->user);
        $this->service->createRevision($block, ['type' => 'text'], ['type' => 'hero'], $this->user);

        $history = $this->service->getRevisionHistory($block);

        $this->assertCount(2, $history);
        $this->assertEquals($block->id, $history[0]->revisionable_id);
    }

    public function test_restore_revision_works_for_content_blocks(): void
    {
        $page = Page::factory()->create();
        $block = ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'text',
            'content' => ['content' => 'Original'],
        ]);

        $oldValues = $block->toArray();
        
        $block->update(['content' => ['content' => 'Updated']]);
        $revision = $this->service->createRevision($block, $oldValues, $block->toArray(), $this->user);

        $restoredBlock = $this->service->restoreRevision($revision, $this->user);

        $this->assertEquals(['content' => 'Original'], $restoredBlock->content);
    }
}
