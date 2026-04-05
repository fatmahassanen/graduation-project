<?php

namespace Tests\Unit;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\Revision;
use App\Models\User;
use App\Services\RevisionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RevisionServicePropertyTest extends TestCase
{
    use RefreshDatabase;

    protected RevisionService $service;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new RevisionService();
        $this->user = User::factory()->create(['role' => 'super_admin']);
    }

    /**
     * Feature: university-cms-upgrade, Property 8: Revision Creation on Changes
     * For any page or content block creation or update operation, a Revision record SHALL
     * be created capturing the change.
     *
     * **Validates: Requirements 3.1**
     */
    public function test_revision_created_for_all_page_changes(): void
    {
        // Test page creation scenarios
        for ($iteration = 0; $iteration < 15; $iteration++) {
            $page = Page::factory()->create(['created_by' => $this->user->id]);
            $oldValues = [];
            $newValues = $page->toArray();

            $revision = $this->service->createRevision($page, $oldValues, $newValues, $this->user);

            $this->assertInstanceOf(Revision::class, $revision);
            $this->assertEquals($page->id, $revision->revisionable_id);
            $this->assertEquals(Page::class, $revision->revisionable_type);
            $this->assertEquals($this->user->id, $revision->user_id);
            $this->assertEquals('created', $revision->action);
            $this->assertNotNull($revision->created_at);
        }

        // Test page update scenarios
        for ($iteration = 0; $iteration < 15; $iteration++) {
            $page = Page::factory()->create(['created_by' => $this->user->id]);
            $oldValues = $page->toArray();

            // Make random updates
            $updates = $this->generateRandomPageUpdates();
            $page->update($updates);
            $newValues = $page->fresh()->toArray();

            $revision = $this->service->createRevision($page, $oldValues, $newValues, $this->user);

            $this->assertInstanceOf(Revision::class, $revision);
            $this->assertEquals($page->id, $revision->revisionable_id);
            $this->assertEquals(Page::class, $revision->revisionable_type);
            $this->assertEquals('updated', $revision->action);
            $this->assertNotEmpty($revision->old_values);
            $this->assertNotEmpty($revision->new_values);
        }
    }

    /**
     * Feature: university-cms-upgrade, Property 8: Revision Creation on Changes
     * For any page or content block creation or update operation, a Revision record SHALL
     * be created capturing the change.
     *
     * **Validates: Requirements 3.1**
     */
    public function test_revision_created_for_all_content_block_changes(): void
    {
        // Test content block creation scenarios
        for ($iteration = 0; $iteration < 15; $iteration++) {
            $page = Page::factory()->create(['created_by' => $this->user->id]);
            $block = ContentBlock::factory()->create([
                'page_id' => $page->id,
                'created_by' => $this->user->id,
            ]);

            $oldValues = [];
            $newValues = $block->toArray();

            $revision = $this->service->createRevision($block, $oldValues, $newValues, $this->user);

            $this->assertInstanceOf(Revision::class, $revision);
            $this->assertEquals($block->id, $revision->revisionable_id);
            $this->assertEquals(ContentBlock::class, $revision->revisionable_type);
            $this->assertEquals($this->user->id, $revision->user_id);
            $this->assertEquals('created', $revision->action);
        }

        // Test content block update scenarios
        for ($iteration = 0; $iteration < 15; $iteration++) {
            $page = Page::factory()->create(['created_by' => $this->user->id]);
            $block = ContentBlock::factory()->create([
                'page_id' => $page->id,
                'created_by' => $this->user->id,
            ]);

            $oldValues = $block->toArray();

            // Make random updates
            $updates = $this->generateRandomBlockUpdates();
            $block->update($updates);
            $newValues = $block->fresh()->toArray();

            $revision = $this->service->createRevision($block, $oldValues, $newValues, $this->user);

            $this->assertInstanceOf(Revision::class, $revision);
            $this->assertEquals($block->id, $revision->revisionable_id);
            $this->assertEquals(ContentBlock::class, $revision->revisionable_type);
            $this->assertEquals('updated', $revision->action);
            $this->assertNotEmpty($revision->old_values);
            $this->assertNotEmpty($revision->new_values);
        }
    }

    /**
     * Feature: university-cms-upgrade, Property 9: Revision Change Tracking
     * For any field change on a page or content block, the revision SHALL store both
     * the old value and new value for that field.
     *
     * **Validates: Requirements 3.3, 3.4**
     */
    public function test_revision_tracks_all_field_changes_for_pages(): void
    {
        $fieldsToTest = ['title', 'slug', 'status', 'language', 'meta_title', 'meta_description'];

        foreach ($fieldsToTest as $field) {
            for ($iteration = 0; $iteration < 10; $iteration++) {
                $page = Page::factory()->create(['created_by' => $this->user->id]);
                $oldValues = $page->toArray();
                $oldValue = $oldValues[$field];

                // Generate new value for the field
                $newValue = $this->generateNewValueForField($field, $oldValue);
                $page->update([$field => $newValue]);
                $newValues = $page->fresh()->toArray();

                $revision = $this->service->createRevision($page, $oldValues, $newValues, $this->user);

                // Verify old value is stored
                $this->assertArrayHasKey($field, $revision->old_values);
                $this->assertEquals($oldValue, $revision->old_values[$field],
                    "Old value for field '{$field}' should be stored correctly (iteration {$iteration})");

                // Verify new value is stored
                $this->assertArrayHasKey($field, $revision->new_values);
                $this->assertEquals($newValue, $revision->new_values[$field],
                    "New value for field '{$field}' should be stored correctly (iteration {$iteration})");

                // Verify values are different
                $this->assertNotEquals($revision->old_values[$field], $revision->new_values[$field],
                    "Old and new values for field '{$field}' should be different (iteration {$iteration})");
            }
        }
    }

    /**
     * Feature: university-cms-upgrade, Property 9: Revision Change Tracking
     * For any field change on a page or content block, the revision SHALL store both
     * the old value and new value for that field.
     *
     * **Validates: Requirements 3.3, 3.4**
     */
    public function test_revision_tracks_all_field_changes_for_content_blocks(): void
    {
        $fieldsToTest = ['type', 'content', 'display_order', 'is_reusable'];

        foreach ($fieldsToTest as $field) {
            for ($iteration = 0; $iteration < 10; $iteration++) {
                $page = Page::factory()->create(['created_by' => $this->user->id]);
                $block = ContentBlock::factory()->create([
                    'page_id' => $page->id,
                    'created_by' => $this->user->id,
                ]);

                $oldValues = $block->toArray();
                $oldValue = $oldValues[$field];

                // Generate new value for the field
                $newValue = $this->generateNewValueForBlockField($field, $oldValue);
                $block->update([$field => $newValue]);
                $newValues = $block->fresh()->toArray();

                $revision = $this->service->createRevision($block, $oldValues, $newValues, $this->user);

                // Verify old value is stored
                $this->assertArrayHasKey($field, $revision->old_values);

                // Verify new value is stored
                $this->assertArrayHasKey($field, $revision->new_values);

                // For array fields (content), compare as arrays
                if ($field === 'content') {
                    $this->assertEquals($oldValue, $revision->old_values[$field],
                        "Old content should be stored correctly (iteration {$iteration})");
                    $this->assertEquals($newValue, $revision->new_values[$field],
                        "New content should be stored correctly (iteration {$iteration})");
                } else {
                    $this->assertEquals($oldValue, $revision->old_values[$field],
                        "Old value for field '{$field}' should be stored correctly (iteration {$iteration})");
                    $this->assertEquals($newValue, $revision->new_values[$field],
                        "New value for field '{$field}' should be stored correctly (iteration {$iteration})");
                }
            }
        }
    }

    /**
     * Feature: university-cms-upgrade, Property 10: Revision Restoration Correctness
     * For any revision of a page or content block, restoring that revision SHALL set
     * the entity's fields to match the revision's old_values.
     *
     * **Validates: Requirements 3.7**
     */
    public function test_restoring_page_revision_sets_fields_to_old_values(): void
    {
        for ($iteration = 0; $iteration < 20; $iteration++) {
            // Create a page with initial values
            $page = Page::factory()->create([
                'title' => 'Original Title ' . $iteration,
                'slug' => 'original-slug-' . $iteration,
                'status' => 'draft',
                'language' => 'en',
                'meta_title' => 'Original Meta ' . $iteration,
                'created_by' => $this->user->id,
            ]);

            $oldValues = $page->toArray();

            // Update the page
            $page->update([
                'title' => 'Updated Title ' . $iteration,
                'slug' => 'updated-slug-' . $iteration,
                'status' => 'published',
                'meta_title' => 'Updated Meta ' . $iteration,
            ]);
            $newValues = $page->fresh()->toArray();

            // Create revision tracking the change
            $revision = $this->service->createRevision($page, $oldValues, $newValues, $this->user);

            // Restore the revision
            $restoredPage = $this->service->restoreRevision($revision, $this->user);

            // Verify all fillable fields match the old values
            $fillableFields = ['title', 'slug', 'status', 'language', 'meta_title'];
            foreach ($fillableFields as $field) {
                if (isset($oldValues[$field])) {
                    $this->assertEquals($oldValues[$field], $restoredPage->$field,
                        "Field '{$field}' should match old value after restoration (iteration {$iteration})");
                }
            }

            // Verify the page was actually updated in the database
            $pageFromDb = Page::find($page->id);
            $this->assertEquals('Original Title ' . $iteration, $pageFromDb->title);
            $this->assertEquals('draft', $pageFromDb->status);
        }
    }

    /**
     * Feature: university-cms-upgrade, Property 10: Revision Restoration Correctness
     * For any revision of a page or content block, restoring that revision SHALL set
     * the entity's fields to match the revision's old_values.
     *
     * **Validates: Requirements 3.7**
     */
    public function test_restoring_content_block_revision_sets_fields_to_old_values(): void
    {
        for ($iteration = 0; $iteration < 20; $iteration++) {
            $page = Page::factory()->create(['created_by' => $this->user->id]);

            // Create a content block with initial values
            $block = ContentBlock::factory()->create([
                'page_id' => $page->id,
                'type' => 'hero',
                'content' => [
                    'title' => 'Original Hero ' . $iteration,
                    'description' => 'Original Description ' . $iteration,
                    'image' => 'https://example.com/original.jpg',
                ],
                'display_order' => 0,
                'is_reusable' => false,
                'created_by' => $this->user->id,
            ]);

            $oldValues = $block->toArray();

            // Update the block
            $block->update([
                'type' => 'text',
                'content' => [
                    'content' => 'Updated Text Content ' . $iteration,
                ],
                'display_order' => 5,
                'is_reusable' => true,
            ]);
            $newValues = $block->fresh()->toArray();

            // Create revision tracking the change
            $revision = $this->service->createRevision($block, $oldValues, $newValues, $this->user);

            // Restore the revision
            $restoredBlock = $this->service->restoreRevision($revision, $this->user);

            // Verify all fillable fields match the old values
            $this->assertEquals('hero', $restoredBlock->type,
                "Type should match old value after restoration (iteration {$iteration})");
            $this->assertEquals($oldValues['content'], $restoredBlock->content,
                "Content should match old value after restoration (iteration {$iteration})");
            $this->assertEquals(0, $restoredBlock->display_order,
                "Display order should match old value after restoration (iteration {$iteration})");
            $this->assertEquals(false, $restoredBlock->is_reusable,
                "Is_reusable should match old value after restoration (iteration {$iteration})");

            // Verify the block was actually updated in the database
            $blockFromDb = ContentBlock::find($block->id);
            $this->assertEquals('hero', $blockFromDb->type);
            $this->assertEquals('Original Hero ' . $iteration, $blockFromDb->content['title']);
        }
    }

    /**
     * Feature: university-cms-upgrade, Property 11: Revision Creation on Restore
     * For any revision restoration operation, a new Revision record SHALL be created
     * documenting the restoration action.
     *
     * **Validates: Requirements 3.8**
     */
    public function test_restoring_revision_creates_new_revision_record(): void
    {
        // Test with pages
        for ($iteration = 0; $iteration < 15; $iteration++) {
            $page = Page::factory()->create([
                'title' => 'Original ' . $iteration,
                'created_by' => $this->user->id,
            ]);

            $oldValues = $page->toArray();
            $page->update(['title' => 'Updated ' . $iteration]);
            $newValues = $page->fresh()->toArray();

            $revision = $this->service->createRevision($page, $oldValues, $newValues, $this->user);

            // Count revisions before restoration
            $revisionCountBefore = $page->revisions()->count();

            // Restore the revision
            $this->service->restoreRevision($revision, $this->user);

            // Count revisions after restoration
            $revisionCountAfter = $page->revisions()->count();

            // Verify a new revision was created
            $this->assertEquals($revisionCountBefore + 1, $revisionCountAfter,
                "A new revision should be created when restoring (iteration {$iteration})");

            // Verify the new revision has correct data
            $latestRevision = $page->revisions()->latest('created_at')->first();
            $this->assertEquals($this->user->id, $latestRevision->user_id);
            $this->assertNotEmpty($latestRevision->old_values);
            $this->assertNotEmpty($latestRevision->new_values);
            $this->assertNotNull($latestRevision->created_at);
        }

        // Test with content blocks
        for ($iteration = 0; $iteration < 15; $iteration++) {
            $page = Page::factory()->create(['created_by' => $this->user->id]);
            $block = ContentBlock::factory()->create([
                'page_id' => $page->id,
                'type' => 'hero',
                'content' => ['title' => 'Original ' . $iteration],
                'created_by' => $this->user->id,
            ]);

            $oldValues = $block->toArray();
            $block->update(['content' => ['title' => 'Updated ' . $iteration]]);
            $newValues = $block->fresh()->toArray();

            $revision = $this->service->createRevision($block, $oldValues, $newValues, $this->user);

            // Count revisions before restoration
            $revisionCountBefore = $block->revisions()->count();

            // Restore the revision
            $this->service->restoreRevision($revision, $this->user);

            // Count revisions after restoration
            $revisionCountAfter = $block->revisions()->count();

            // Verify a new revision was created
            $this->assertEquals($revisionCountBefore + 1, $revisionCountAfter,
                "A new revision should be created when restoring content block (iteration {$iteration})");

            // Verify the new revision has correct data
            $latestRevision = $block->revisions()->latest('created_at')->first();
            $this->assertEquals($this->user->id, $latestRevision->user_id);
            $this->assertNotEmpty($latestRevision->old_values);
            $this->assertNotEmpty($latestRevision->new_values);
        }
    }

    /**
     * Generate random page updates for testing.
     */
    private function generateRandomPageUpdates(): array
    {
        $updates = [];
        $possibleUpdates = [
            'title' => 'Updated Title ' . rand(1000, 9999),
            'slug' => 'updated-slug-' . rand(1000, 9999),
            'status' => ['draft', 'published', 'archived'][rand(0, 2)],
            'meta_title' => 'Updated Meta ' . rand(1000, 9999),
            'meta_description' => 'Updated description ' . rand(1000, 9999),
        ];

        // Randomly select 1-3 fields to update
        $fieldsToUpdate = array_rand($possibleUpdates, rand(1, 3));
        if (!is_array($fieldsToUpdate)) {
            $fieldsToUpdate = [$fieldsToUpdate];
        }

        foreach ($fieldsToUpdate as $field) {
            $updates[$field] = $possibleUpdates[$field];
        }

        return $updates;
    }

    /**
     * Generate random content block updates for testing.
     */
    private function generateRandomBlockUpdates(): array
    {
        $types = ['hero', 'text', 'card_grid', 'video', 'faq'];
        $type = $types[rand(0, count($types) - 1)];

        return [
            'type' => $type,
            'content' => $this->generateContentForType($type),
            'display_order' => rand(0, 100),
            'is_reusable' => (bool) rand(0, 1),
        ];
    }

    /**
     * Generate new value for a specific field.
     */
    private function generateNewValueForField(string $field, $oldValue): mixed
    {
        return match ($field) {
            'title' => 'New Title ' . rand(1000, 9999),
            'slug' => 'new-slug-' . rand(1000, 9999),
            'status' => $oldValue === 'draft' ? 'published' : 'draft',
            'language' => $oldValue === 'en' ? 'ar' : 'en',
            'meta_title' => 'New Meta Title ' . rand(1000, 9999),
            'meta_description' => 'New Meta Description ' . rand(1000, 9999),
            default => 'New Value ' . rand(1000, 9999),
        };
    }

    /**
     * Generate new value for a content block field.
     */
    private function generateNewValueForBlockField(string $field, $oldValue): mixed
    {
        return match ($field) {
            'type' => $oldValue === 'hero' ? 'text' : 'hero',
            'content' => [
                'title' => 'New Content ' . rand(1000, 9999),
                'description' => 'New Description ' . rand(1000, 9999),
            ],
            'display_order' => rand(0, 100),
            'is_reusable' => !$oldValue,
            default => 'New Value ' . rand(1000, 9999),
        };
    }

    /**
     * Generate content for a specific block type.
     */
    private function generateContentForType(string $type): array
    {
        return match ($type) {
            'hero' => [
                'title' => 'Hero Title ' . rand(1000, 9999),
                'description' => 'Hero Description ' . rand(1000, 9999),
                'image' => 'https://example.com/hero-' . rand(1000, 9999) . '.jpg',
            ],
            'text' => [
                'content' => 'Text content ' . rand(1000, 9999),
            ],
            'card_grid' => [
                'columns' => rand(2, 4),
                'cards' => [
                    ['title' => 'Card ' . rand(1000, 9999)],
                ],
            ],
            'video' => [
                'url' => 'https://youtube.com/watch?v=' . rand(1000, 9999),
            ],
            'faq' => [
                'items' => [
                    [
                        'question' => 'Question ' . rand(1000, 9999) . '?',
                        'answer' => 'Answer ' . rand(1000, 9999),
                    ],
                ],
            ],
            default => ['content' => 'Default content ' . rand(1000, 9999)],
        };
    }
}
