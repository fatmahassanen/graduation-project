<?php

namespace Tests\Unit;

use App\Models\Page;
use App\Models\Revision;
use App\Models\User;
use App\Services\RevisionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RevisionServiceTest extends TestCase
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

    public function test_create_revision_captures_old_and_new_values(): void
    {
        $page = Page::factory()->create();
        $oldValues = ['title' => 'Old Title', 'status' => 'draft'];
        $newValues = ['title' => 'New Title', 'status' => 'published'];

        $revision = $this->service->createRevision($page, $oldValues, $newValues, $this->user);

        $this->assertInstanceOf(Revision::class, $revision);
        $this->assertEquals($page->id, $revision->revisionable_id);
        $this->assertEquals(Page::class, $revision->revisionable_type);
        $this->assertEquals($this->user->id, $revision->user_id);
        $this->assertEquals($oldValues, $revision->old_values);
        $this->assertEquals($newValues, $revision->new_values);
        $this->assertEquals('updated', $revision->action);
    }

    public function test_create_revision_determines_created_action(): void
    {
        $page = Page::factory()->create();
        $revision = $this->service->createRevision($page, [], ['title' => 'New Page'], $this->user);

        $this->assertEquals('created', $revision->action);
    }

    public function test_create_revision_determines_deleted_action(): void
    {
        $page = Page::factory()->create();
        $revision = $this->service->createRevision($page, ['title' => 'Old Page'], [], $this->user);

        $this->assertEquals('deleted', $revision->action);
    }

    public function test_get_revision_history_returns_ordered_collection(): void
    {
        $page = Page::factory()->create();
        
        // Create multiple revisions with slight delays
        $revision1 = $this->service->createRevision($page, [], ['title' => 'V1'], $this->user);
        sleep(1);
        $revision2 = $this->service->createRevision($page, ['title' => 'V1'], ['title' => 'V2'], $this->user);
        sleep(1);
        $revision3 = $this->service->createRevision($page, ['title' => 'V2'], ['title' => 'V3'], $this->user);

        $history = $this->service->getRevisionHistory($page);

        $this->assertCount(3, $history);
        // Most recent first
        $this->assertEquals($revision3->id, $history[0]->id);
        $this->assertEquals($revision2->id, $history[1]->id);
        $this->assertEquals($revision1->id, $history[2]->id);
    }

    public function test_get_revision_history_includes_user_relationship(): void
    {
        $page = Page::factory()->create();
        $this->service->createRevision($page, [], ['title' => 'Test'], $this->user);

        $history = $this->service->getRevisionHistory($page);

        $this->assertTrue($history[0]->relationLoaded('user'));
        $this->assertEquals($this->user->id, $history[0]->user->id);
    }

    public function test_restore_revision_updates_model_with_old_values(): void
    {
        $page = Page::factory()->create([
            'title' => 'Original Title',
            'slug' => 'original-slug',
            'status' => 'draft',
        ]);

        $oldValues = $page->toArray();
        
        $page->update(['title' => 'Updated Title', 'status' => 'published']);
        $newValues = $page->toArray();

        $revision = $this->service->createRevision($page, $oldValues, $newValues, $this->user);

        // Now restore to the old version
        $restoredPage = $this->service->restoreRevision($revision, $this->user);

        $this->assertEquals('Original Title', $restoredPage->title);
        $this->assertEquals('draft', $restoredPage->status);
    }

    public function test_restore_revision_creates_new_revision(): void
    {
        $page = Page::factory()->create(['title' => 'Original']);
        $oldValues = $page->toArray();
        
        $page->update(['title' => 'Updated']);
        $revision = $this->service->createRevision($page, $oldValues, $page->toArray(), $this->user);

        $initialRevisionCount = $page->revisions()->count();
        
        $this->service->restoreRevision($revision, $this->user);

        $this->assertEquals($initialRevisionCount + 1, $page->revisions()->count());
    }

    public function test_compare_revisions_detects_changed_fields(): void
    {
        $page = Page::factory()->create();
        
        $revision1 = $this->service->createRevision(
            $page,
            [],
            ['title' => 'Title V1', 'status' => 'draft'],
            $this->user
        );
        
        $revision2 = $this->service->createRevision(
            $page,
            ['title' => 'Title V1', 'status' => 'draft'],
            ['title' => 'Title V2', 'status' => 'published'],
            $this->user
        );

        $diff = $this->service->compareRevisions($revision1, $revision2);

        $this->assertArrayHasKey('changed', $diff);
        $this->assertArrayHasKey('title', $diff['changed']);
        $this->assertEquals('Title V1', $diff['changed']['title']['old']);
        $this->assertEquals('Title V2', $diff['changed']['title']['new']);
        $this->assertArrayHasKey('status', $diff['changed']);
        $this->assertEquals('draft', $diff['changed']['status']['old']);
        $this->assertEquals('published', $diff['changed']['status']['new']);
    }

    public function test_compare_revisions_detects_added_fields(): void
    {
        $page = Page::factory()->create();
        
        $revision1 = $this->service->createRevision(
            $page,
            [],
            ['title' => 'Title'],
            $this->user
        );
        
        $revision2 = $this->service->createRevision(
            $page,
            ['title' => 'Title'],
            ['title' => 'Title', 'meta_description' => 'New meta'],
            $this->user
        );

        $diff = $this->service->compareRevisions($revision1, $revision2);

        $this->assertArrayHasKey('added', $diff);
        $this->assertArrayHasKey('meta_description', $diff['added']);
        $this->assertEquals('New meta', $diff['added']['meta_description']);
    }

    public function test_compare_revisions_detects_removed_fields(): void
    {
        $page = Page::factory()->create();
        
        $revision1 = $this->service->createRevision(
            $page,
            [],
            ['title' => 'Title', 'meta_description' => 'Meta'],
            $this->user
        );
        
        $revision2 = $this->service->createRevision(
            $page,
            ['title' => 'Title', 'meta_description' => 'Meta'],
            ['title' => 'Title'],
            $this->user
        );

        $diff = $this->service->compareRevisions($revision1, $revision2);

        $this->assertArrayHasKey('removed', $diff);
        $this->assertArrayHasKey('meta_description', $diff['removed']);
        $this->assertEquals('Meta', $diff['removed']['meta_description']);
    }

    public function test_compare_revisions_returns_empty_diff_for_identical_revisions(): void
    {
        $page = Page::factory()->create();
        
        $values = ['title' => 'Same Title', 'status' => 'draft'];
        $revision1 = $this->service->createRevision($page, [], $values, $this->user);
        $revision2 = $this->service->createRevision($page, $values, $values, $this->user);

        $diff = $this->service->compareRevisions($revision1, $revision2);

        $this->assertEmpty($diff['added']);
        $this->assertEmpty($diff['removed']);
        $this->assertEmpty($diff['changed']);
    }
}
