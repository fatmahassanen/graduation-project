<?php

namespace Tests\Unit;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\Revision;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RevisionRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_has_many_revisions(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create();

        // Create multiple revisions for the page
        Revision::create([
            'user_id' => $user->id,
            'revisionable_type' => Page::class,
            'revisionable_id' => $page->id,
            'action' => 'created',
            'old_values' => null,
            'new_values' => ['title' => 'Initial Title'],
        ]);

        Revision::create([
            'user_id' => $user->id,
            'revisionable_type' => Page::class,
            'revisionable_id' => $page->id,
            'action' => 'updated',
            'old_values' => ['title' => 'Initial Title'],
            'new_values' => ['title' => 'Updated Title'],
        ]);

        $this->assertCount(2, $page->revisions);
        $this->assertEquals('created', $page->revisions[0]->action);
        $this->assertEquals('updated', $page->revisions[1]->action);
    }

    public function test_content_block_has_many_revisions(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create();
        $contentBlock = ContentBlock::factory()->create(['page_id' => $page->id]);

        // Create multiple revisions for the content block
        Revision::create([
            'user_id' => $user->id,
            'revisionable_type' => ContentBlock::class,
            'revisionable_id' => $contentBlock->id,
            'action' => 'created',
            'old_values' => null,
            'new_values' => ['type' => 'hero'],
        ]);

        Revision::create([
            'user_id' => $user->id,
            'revisionable_type' => ContentBlock::class,
            'revisionable_id' => $contentBlock->id,
            'action' => 'updated',
            'old_values' => ['content' => ['title' => 'Old']],
            'new_values' => ['content' => ['title' => 'New']],
        ]);

        $this->assertCount(2, $contentBlock->revisions);
        $this->assertEquals('created', $contentBlock->revisions[0]->action);
        $this->assertEquals('updated', $contentBlock->revisions[1]->action);
    }

    public function test_user_can_access_revisions_through_relationship(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create();

        $revision = Revision::create([
            'user_id' => $user->id,
            'revisionable_type' => Page::class,
            'revisionable_id' => $page->id,
            'action' => 'created',
            'old_values' => null,
            'new_values' => ['title' => 'Test Page'],
        ]);

        // Verify the relationship works
        $this->assertEquals($user->id, $revision->user->id);
        $this->assertEquals($user->name, $revision->user->name);
    }
}
