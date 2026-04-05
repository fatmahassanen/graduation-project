<?php

namespace Tests\Unit;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\Revision;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RevisionModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_revision_has_fillable_fields(): void
    {
        $fillable = (new Revision())->getFillable();

        $this->assertContains('user_id', $fillable);
        $this->assertContains('revisionable_type', $fillable);
        $this->assertContains('revisionable_id', $fillable);
        $this->assertContains('action', $fillable);
        $this->assertContains('old_values', $fillable);
        $this->assertContains('new_values', $fillable);
    }

    public function test_revision_casts_old_values_to_array(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create();

        $revision = Revision::create([
            'user_id' => $user->id,
            'revisionable_type' => Page::class,
            'revisionable_id' => $page->id,
            'action' => 'updated',
            'old_values' => ['title' => 'Old Title'],
            'new_values' => ['title' => 'New Title'],
        ]);

        $this->assertIsArray($revision->old_values);
        $this->assertEquals(['title' => 'Old Title'], $revision->old_values);
    }

    public function test_revision_casts_new_values_to_array(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create();

        $revision = Revision::create([
            'user_id' => $user->id,
            'revisionable_type' => Page::class,
            'revisionable_id' => $page->id,
            'action' => 'updated',
            'old_values' => ['title' => 'Old Title'],
            'new_values' => ['title' => 'New Title'],
        ]);

        $this->assertIsArray($revision->new_values);
        $this->assertEquals(['title' => 'New Title'], $revision->new_values);
    }

    public function test_revision_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create();

        $revision = Revision::create([
            'user_id' => $user->id,
            'revisionable_type' => Page::class,
            'revisionable_id' => $page->id,
            'action' => 'created',
            'old_values' => null,
            'new_values' => ['title' => 'New Page'],
        ]);

        $this->assertInstanceOf(User::class, $revision->user);
        $this->assertEquals($user->id, $revision->user->id);
    }

    public function test_revision_morphs_to_page(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create();

        $revision = Revision::create([
            'user_id' => $user->id,
            'revisionable_type' => Page::class,
            'revisionable_id' => $page->id,
            'action' => 'created',
            'old_values' => null,
            'new_values' => ['title' => $page->title],
        ]);

        $this->assertInstanceOf(Page::class, $revision->revisionable);
        $this->assertEquals($page->id, $revision->revisionable->id);
    }

    public function test_revision_morphs_to_content_block(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create();
        $contentBlock = ContentBlock::factory()->create(['page_id' => $page->id]);

        $revision = Revision::create([
            'user_id' => $user->id,
            'revisionable_type' => ContentBlock::class,
            'revisionable_id' => $contentBlock->id,
            'action' => 'created',
            'old_values' => null,
            'new_values' => ['type' => $contentBlock->type],
        ]);

        $this->assertInstanceOf(ContentBlock::class, $revision->revisionable);
        $this->assertEquals($contentBlock->id, $revision->revisionable->id);
    }
}
