<?php

namespace Tests\Unit;

use App\Models\Page;
use App\Models\User;
use App\Services\RevisionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RevisionServiceMetadataTest extends TestCase
{
    use RefreshDatabase;

    protected RevisionService $service;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new RevisionService();
        $this->user = User::factory()->create(['name' => 'Test User']);
    }

    public function test_revision_includes_user_metadata(): void
    {
        $page = Page::factory()->create(['title' => 'Test Page']);
        
        $revision = $this->service->createRevision(
            $page,
            [],
            ['title' => 'Test Page'],
            $this->user
        );

        $this->assertEquals($this->user->id, $revision->user_id);
        $this->assertNotNull($revision->created_at);
    }

    public function test_revision_history_shows_who_changed_what_when(): void
    {
        $page = Page::factory()->create(['title' => 'Original']);
        $user1 = User::factory()->create(['name' => 'Editor 1']);
        $user2 = User::factory()->create(['name' => 'Editor 2']);
        
        // First change by user1
        $this->service->createRevision(
            $page,
            ['title' => 'Original'],
            ['title' => 'Updated by User 1'],
            $user1
        );
        
        sleep(1);
        
        // Second change by user2
        $this->service->createRevision(
            $page,
            ['title' => 'Updated by User 1'],
            ['title' => 'Updated by User 2'],
            $user2
        );

        $history = $this->service->getRevisionHistory($page);

        // Most recent first
        $this->assertEquals($user2->id, $history[0]->user_id);
        $this->assertEquals('Editor 2', $history[0]->user->name);
        $this->assertEquals('Updated by User 2', $history[0]->new_values['title']);
        
        $this->assertEquals($user1->id, $history[1]->user_id);
        $this->assertEquals('Editor 1', $history[1]->user->name);
        $this->assertEquals('Updated by User 1', $history[1]->new_values['title']);
    }

    public function test_revision_tracks_page_field_changes(): void
    {
        $page = Page::factory()->create([
            'title' => 'Original Title',
            'slug' => 'original-slug',
            'status' => 'draft',
            'language' => 'en',
        ]);

        $oldValues = $page->toArray();
        
        $page->update([
            'title' => 'New Title',
            'slug' => 'new-slug',
            'status' => 'published',
        ]);

        $revision = $this->service->createRevision($page, $oldValues, $page->toArray(), $this->user);

        $this->assertEquals('Original Title', $revision->old_values['title']);
        $this->assertEquals('New Title', $revision->new_values['title']);
        $this->assertEquals('draft', $revision->old_values['status']);
        $this->assertEquals('published', $revision->new_values['status']);
    }

    public function test_compare_revisions_shows_what_values_changed(): void
    {
        $page = Page::factory()->create();
        
        $revision1 = $this->service->createRevision(
            $page,
            [],
            ['title' => 'Version 1', 'status' => 'draft', 'language' => 'en'],
            $this->user
        );
        
        $revision2 = $this->service->createRevision(
            $page,
            ['title' => 'Version 1', 'status' => 'draft', 'language' => 'en'],
            ['title' => 'Version 2', 'status' => 'published', 'language' => 'en'],
            $this->user
        );

        $diff = $this->service->compareRevisions($revision1, $revision2);

        // Verify we can see what changed
        $this->assertArrayHasKey('title', $diff['changed']);
        $this->assertEquals('Version 1', $diff['changed']['title']['old']);
        $this->assertEquals('Version 2', $diff['changed']['title']['new']);
        
        $this->assertArrayHasKey('status', $diff['changed']);
        $this->assertEquals('draft', $diff['changed']['status']['old']);
        $this->assertEquals('published', $diff['changed']['status']['new']);
        
        // Language didn't change
        $this->assertArrayNotHasKey('language', $diff['changed']);
    }

    public function test_restoration_creates_new_revision_documenting_the_restoration(): void
    {
        $page = Page::factory()->create(['title' => 'Original', 'status' => 'draft']);
        $oldValues = $page->toArray();
        
        $page->update(['title' => 'Modified', 'status' => 'published']);
        $page->refresh();
        $newValues = $page->toArray();
        
        $revision = $this->service->createRevision($page, $oldValues, $newValues, $this->user);

        $revisionCountBefore = $page->revisions()->count();
        
        // Restore to original version
        $restoredPage = $this->service->restoreRevision($revision, $this->user);

        $revisionCountAfter = $page->revisions()->count();
        
        // A new revision should be created documenting the restoration
        $this->assertEquals($revisionCountBefore + 1, $revisionCountAfter);
        
        // Verify the page was actually restored
        $this->assertEquals('Original', $restoredPage->title);
        $this->assertEquals('draft', $restoredPage->status);
        
        // The latest revision should show the restoration (order by id as secondary sort for same timestamps)
        $latestRevision = $page->fresh()->revisions()
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();
        
        // The restoration revision should show going from Modified back to Original
        $this->assertEquals('Modified', $latestRevision->old_values['title']);
        $this->assertEquals('Original', $latestRevision->new_values['title']);
    }
}
