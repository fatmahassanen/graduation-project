<?php

namespace Tests\Unit;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\Revision;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentBlockModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_fields_are_defined(): void
    {
        $block = new ContentBlock();
        $fillable = $block->getFillable();

        $this->assertContains('page_id', $fillable);
        $this->assertContains('type', $fillable);
        $this->assertContains('content', $fillable);
        $this->assertContains('display_order', $fillable);
        $this->assertContains('is_reusable', $fillable);
    }

    public function test_content_is_cast_to_array(): void
    {
        $block = new ContentBlock();
        $casts = $block->getCasts();

        $this->assertEquals('array', $casts['content']);
    }

    public function test_is_reusable_is_cast_to_boolean(): void
    {
        $block = new ContentBlock();
        $casts = $block->getCasts();

        $this->assertEquals('boolean', $casts['is_reusable']);
    }

    public function test_belongs_to_page(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create(['created_by' => $user->id]);
        $block = ContentBlock::factory()->create([
            'page_id' => $page->id,
            'created_by' => $user->id,
        ]);

        $this->assertInstanceOf(Page::class, $block->page);
        $this->assertEquals($page->id, $block->page->id);
    }

    public function test_belongs_to_creator(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create(['created_by' => $user->id]);
        $block = ContentBlock::factory()->create([
            'page_id' => $page->id,
            'created_by' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $block->creator);
        $this->assertEquals($user->id, $block->creator->id);
    }

    public function test_has_many_revisions(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create(['created_by' => $user->id]);
        $block = ContentBlock::factory()->create([
            'page_id' => $page->id,
            'created_by' => $user->id,
        ]);

        // Create a revision
        $revision = new Revision([
            'user_id' => $user->id,
            'action' => 'created',
            'old_values' => null,
            'new_values' => json_encode($block->toArray()),
        ]);
        $block->revisions()->save($revision);

        $this->assertCount(1, $block->revisions);
        $this->assertInstanceOf(Revision::class, $block->revisions->first());
    }

    public function test_content_json_casting_works(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create(['created_by' => $user->id]);
        
        $contentData = [
            'title' => 'Test Hero',
            'description' => 'Test description',
            'image' => 'https://example.com/image.jpg',
        ];

        $block = ContentBlock::factory()->create([
            'page_id' => $page->id,
            'created_by' => $user->id,
            'type' => 'hero',
            'content' => $contentData,
        ]);

        // Refresh from database
        $block->refresh();

        $this->assertIsArray($block->content);
        $this->assertEquals($contentData, $block->content);
    }

    public function test_is_reusable_boolean_casting_works(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create(['created_by' => $user->id]);
        
        $block = ContentBlock::factory()->create([
            'page_id' => $page->id,
            'created_by' => $user->id,
            'is_reusable' => true,
        ]);

        $block->refresh();

        $this->assertIsBool($block->is_reusable);
        $this->assertTrue($block->is_reusable);
    }
}
