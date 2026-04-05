<?php

namespace Tests\Feature;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageShowViewTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'super_admin']);
    }

    public function test_page_show_view_renders_hero_block(): void
    {
        $page = Page::factory()->create([
            'status' => 'published',
            'language' => 'en',
            'slug' => 'test-page',
        ]);

        ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Test Hero Title',
                'description' => 'Test Hero Description',
                'image' => '/img/test.jpg',
                'ctaText' => 'Learn More',
                'ctaLink' => '/about',
            ],
            'display_order' => 1,
        ]);

        $response = $this->get('/test-page');

        $response->assertStatus(200);
        $response->assertSee('Test Hero Title');
        $response->assertSee('Test Hero Description');
    }

    public function test_page_show_view_renders_card_grid_block(): void
    {
        $page = Page::factory()->create([
            'status' => 'published',
            'language' => 'en',
            'slug' => 'test-page',
        ]);

        ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'card_grid',
            'content' => [
                'columns' => 3,
                'cards' => [
                    [
                        'title' => 'Card 1',
                        'description' => 'Card 1 Description',
                        'icon' => 'fa fa-graduation-cap',
                    ],
                    [
                        'title' => 'Card 2',
                        'description' => 'Card 2 Description',
                        'icon' => 'fa fa-book',
                    ],
                ],
            ],
            'display_order' => 1,
        ]);

        $response = $this->get('/test-page');

        $response->assertStatus(200);
        $response->assertSee('Card 1');
        $response->assertSee('Card 2');
    }

    public function test_page_show_view_renders_text_block(): void
    {
        $page = Page::factory()->create([
            'status' => 'published',
            'language' => 'en',
            'slug' => 'test-page',
        ]);

        ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'text',
            'content' => [
                'body' => '<p>This is a test text block with <strong>bold text</strong>.</p>',
            ],
            'display_order' => 1,
        ]);

        $response = $this->get('/test-page');

        $response->assertStatus(200);
        $response->assertSee('This is a test text block with');
        $response->assertSee('bold text', false); // false = don't escape HTML
    }

    public function test_page_show_view_renders_multiple_blocks_in_order(): void
    {
        $page = Page::factory()->create([
            'status' => 'published',
            'language' => 'en',
            'slug' => 'test-page',
        ]);

        ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Hero Title',
                'description' => 'Hero Description',
            ],
            'display_order' => 1,
        ]);

        ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'text',
            'content' => [
                'body' => '<p>Text content</p>',
            ],
            'display_order' => 2,
        ]);

        $response = $this->get('/test-page');

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Hero Title', 'Text content']);
    }

    public function test_page_show_view_sets_seo_meta_tags(): void
    {
        $page = Page::factory()->create([
            'status' => 'published',
            'language' => 'en',
            'slug' => 'test-page',
            'title' => 'Test Page',
            'meta_title' => 'Custom Meta Title',
            'meta_description' => 'Custom meta description',
            'meta_keywords' => 'test, keywords',
            'og_image' => '/img/og-image.jpg',
        ]);

        $response = $this->get('/test-page');

        $response->assertStatus(200);
        $response->assertSee('Custom Meta Title', false);
        $response->assertSee('Custom meta description', false);
        $response->assertSee('test, keywords', false);
    }

    public function test_page_show_view_handles_missing_content_fields_gracefully(): void
    {
        $page = Page::factory()->create([
            'status' => 'published',
            'language' => 'en',
            'slug' => 'test-page',
        ]);

        ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Only Title',
                // Missing description, image, ctaText, ctaLink
            ],
            'display_order' => 1,
        ]);

        $response = $this->get('/test-page');

        $response->assertStatus(200);
        $response->assertSee('Only Title');
    }
}
