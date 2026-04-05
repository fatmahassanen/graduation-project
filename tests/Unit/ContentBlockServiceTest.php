<?php

namespace Tests\Unit;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use App\Services\ContentBlockService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ContentBlockServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ContentBlockService $service;
    protected User $user;
    protected Page $page;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(ContentBlockService::class);
        $this->user = User::factory()->create();
        $this->page = Page::factory()->create(['created_by' => $this->user->id]);
    }

    public function test_it_creates_a_hero_block_with_valid_content()
    {
        $data = [
            'page_id' => $this->page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Welcome to Our University',
                'description' => 'A leading institution of higher education',
                'image' => 'https://example.com/hero.jpg',
                'ctaText' => 'Learn More',
                'ctaLink' => 'https://example.com/about',
            ],
            'display_order' => 0,
        ];

        $block = $this->service->createBlock($data, $this->user);

        $this->assertInstanceOf(ContentBlock::class, $block);
        $this->assertEquals('hero', $block->type);
        $this->assertEquals('Welcome to Our University', $block->content['title']);
        $this->assertEquals($this->user->id, $block->created_by);
    }

    public function test_it_creates_a_card_grid_block_with_valid_content()
    {
        $data = [
            'page_id' => $this->page->id,
            'type' => 'card_grid',
            'content' => [
                'columns' => 3,
                'cards' => [
                    [
                        'title' => 'Engineering',
                        'description' => 'World-class engineering programs',
                        'image' => 'https://example.com/eng.jpg',
                        'link' => 'https://example.com/engineering',
                    ],
                    [
                        'title' => 'Medicine',
                        'description' => 'Advanced medical education',
                    ],
                ],
            ],
            'display_order' => 1,
        ];

        $block = $this->service->createBlock($data, $this->user);

        $this->assertInstanceOf(ContentBlock::class, $block);
        $this->assertEquals('card_grid', $block->type);
        $this->assertEquals(3, $block->content['columns']);
        $this->assertCount(2, $block->content['cards']);
    }

    public function test_it_creates_a_faq_block_with_valid_content()
    {
        $data = [
            'page_id' => $this->page->id,
            'type' => 'faq',
            'content' => [
                'items' => [
                    [
                        'question' => 'What are the admission requirements?',
                        'answer' => 'High school diploma with minimum GPA of 3.0',
                    ],
                    [
                        'question' => 'When does the semester start?',
                        'answer' => 'Fall semester begins in September',
                    ],
                ],
            ],
            'display_order' => 2,
        ];

        $block = $this->service->createBlock($data, $this->user);

        $this->assertInstanceOf(ContentBlock::class, $block);
        $this->assertEquals('faq', $block->type);
        $this->assertCount(2, $block->content['items']);
    }

    public function test_it_creates_a_text_block_with_valid_content()
    {
        $data = [
            'page_id' => $this->page->id,
            'type' => 'text',
            'content' => [
                'content' => '<p>This is a text block with <strong>formatted</strong> content.</p>',
            ],
            'display_order' => 0,
        ];

        $block = $this->service->createBlock($data, $this->user);

        $this->assertInstanceOf(ContentBlock::class, $block);
        $this->assertEquals('text', $block->type);
    }

    public function test_it_creates_a_video_block_with_valid_content()
    {
        $data = [
            'page_id' => $this->page->id,
            'type' => 'video',
            'content' => [
                'url' => 'https://youtube.com/watch?v=example',
                'title' => 'Campus Tour',
                'description' => 'Take a virtual tour of our campus',
            ],
            'display_order' => 0,
        ];

        $block = $this->service->createBlock($data, $this->user);

        $this->assertInstanceOf(ContentBlock::class, $block);
        $this->assertEquals('video', $block->type);
    }

    public function test_it_creates_a_testimonial_block_with_valid_content()
    {
        $data = [
            'page_id' => $this->page->id,
            'type' => 'testimonial',
            'content' => [
                'items' => [
                    [
                        'name' => 'John Doe',
                        'role' => 'Alumni, Class of 2020',
                        'content' => 'This university changed my life!',
                        'image' => 'https://example.com/john.jpg',
                    ],
                ],
            ],
            'display_order' => 0,
        ];

        $block = $this->service->createBlock($data, $this->user);

        $this->assertInstanceOf(ContentBlock::class, $block);
        $this->assertEquals('testimonial', $block->type);
    }

    public function test_it_creates_a_gallery_block_with_valid_content()
    {
        $data = [
            'page_id' => $this->page->id,
            'type' => 'gallery',
            'content' => [
                'title' => 'Campus Photos',
                'images' => [
                    [
                        'url' => 'https://example.com/img1.jpg',
                        'alt' => 'Library building',
                        'caption' => 'Our state-of-the-art library',
                    ],
                ],
            ],
            'display_order' => 0,
        ];

        $block = $this->service->createBlock($data, $this->user);

        $this->assertInstanceOf(ContentBlock::class, $block);
        $this->assertEquals('gallery', $block->type);
    }

    public function test_it_creates_a_contact_form_block_with_valid_content()
    {
        $data = [
            'page_id' => $this->page->id,
            'type' => 'contact_form',
            'content' => [
                'title' => 'Contact Us',
                'submitText' => 'Send Message',
                'fields' => [
                    [
                        'name' => 'name',
                        'type' => 'text',
                        'label' => 'Your Name',
                        'required' => true,
                    ],
                    [
                        'name' => 'email',
                        'type' => 'email',
                        'label' => 'Email Address',
                        'required' => true,
                    ],
                ],
            ],
            'display_order' => 0,
        ];

        $block = $this->service->createBlock($data, $this->user);

        $this->assertInstanceOf(ContentBlock::class, $block);
        $this->assertEquals('contact_form', $block->type);
    }

    public function test_it_throws_exception_for_invalid_hero_content()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'page_id' => $this->page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Welcome',
                // Missing required 'description' and 'image'
            ],
            'display_order' => 0,
        ];

        $this->service->createBlock($data, $this->user);
    }

    public function test_it_throws_exception_for_invalid_card_grid_content()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'page_id' => $this->page->id,
            'type' => 'card_grid',
            'content' => [
                'columns' => 5, // Invalid: max is 4
                'cards' => [],
            ],
            'display_order' => 0,
        ];

        $this->service->createBlock($data, $this->user);
    }

    public function test_it_updates_a_content_block()
    {
        $block = ContentBlock::factory()->create([
            'page_id' => $this->page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Old Title',
                'description' => 'Old description',
                'image' => 'https://example.com/old.jpg',
            ],
            'created_by' => $this->user->id,
        ]);

        $updatedBlock = $this->service->updateBlock($block, [
            'content' => [
                'title' => 'New Title',
                'description' => 'New description',
                'image' => 'https://example.com/new.jpg',
            ],
        ], $this->user);

        $this->assertEquals('New Title', $updatedBlock->content['title']);
        $this->assertEquals($this->user->id, $updatedBlock->updated_by);
    }

    public function test_it_deletes_a_content_block()
    {
        $block = ContentBlock::factory()->create([
            'page_id' => $this->page->id,
            'created_by' => $this->user->id,
        ]);

        $result = $this->service->deleteBlock($block, $this->user);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('content_blocks', ['id' => $block->id]);
    }

    public function test_it_reorders_blocks_for_a_page()
    {
        $block1 = ContentBlock::factory()->create([
            'page_id' => $this->page->id,
            'display_order' => 0,
            'created_by' => $this->user->id,
        ]);
        $block2 = ContentBlock::factory()->create([
            'page_id' => $this->page->id,
            'display_order' => 1,
            'created_by' => $this->user->id,
        ]);
        $block3 = ContentBlock::factory()->create([
            'page_id' => $this->page->id,
            'display_order' => 2,
            'created_by' => $this->user->id,
        ]);

        // Reorder: block3, block1, block2
        $this->service->reorderBlocks($this->page, [$block3->id, $block1->id, $block2->id]);

        $this->assertEquals(0, $block3->fresh()->display_order);
        $this->assertEquals(1, $block1->fresh()->display_order);
        $this->assertEquals(2, $block2->fresh()->display_order);
    }

    public function test_it_gets_blocks_by_page_in_display_order()
    {
        ContentBlock::factory()->create([
            'page_id' => $this->page->id,
            'display_order' => 2,
            'created_by' => $this->user->id,
        ]);
        ContentBlock::factory()->create([
            'page_id' => $this->page->id,
            'display_order' => 0,
            'created_by' => $this->user->id,
        ]);
        ContentBlock::factory()->create([
            'page_id' => $this->page->id,
            'display_order' => 1,
            'created_by' => $this->user->id,
        ]);

        $blocks = $this->service->getBlocksByPage($this->page);

        $this->assertCount(3, $blocks);
        $this->assertEquals(0, $blocks[0]->display_order);
        $this->assertEquals(1, $blocks[1]->display_order);
        $this->assertEquals(2, $blocks[2]->display_order);
    }

    public function test_it_validates_hero_block_content()
    {
        $validContent = [
            'title' => 'Test Title',
            'description' => 'Test description',
            'image' => 'https://example.com/image.jpg',
        ];

        $this->assertTrue($this->service->validateBlockContent('hero', $validContent));

        $invalidContent = [
            'title' => 'Test Title',
            // Missing required fields
        ];

        $this->assertFalse($this->service->validateBlockContent('hero', $invalidContent));
    }

    public function test_it_validates_card_grid_block_content()
    {
        $validContent = [
            'columns' => 3,
            'cards' => [
                ['title' => 'Card 1'],
                ['title' => 'Card 2'],
            ],
        ];

        $this->assertTrue($this->service->validateBlockContent('card_grid', $validContent));

        $invalidContent = [
            'columns' => 5, // Invalid: max is 4
            'cards' => [],
        ];

        $this->assertFalse($this->service->validateBlockContent('card_grid', $invalidContent));
    }

    public function test_it_validates_faq_block_content()
    {
        $validContent = [
            'items' => [
                ['question' => 'Q1?', 'answer' => 'A1'],
                ['question' => 'Q2?', 'answer' => 'A2'],
            ],
        ];

        $this->assertTrue($this->service->validateBlockContent('faq', $validContent));

        $invalidContent = [
            'items' => [
                ['question' => 'Q1?'], // Missing answer
            ],
        ];

        $this->assertFalse($this->service->validateBlockContent('faq', $invalidContent));
    }

    public function test_it_creates_revision_on_block_creation()
    {
        $data = [
            'page_id' => $this->page->id,
            'type' => 'text',
            'content' => ['content' => 'Test content'],
            'display_order' => 0,
        ];

        $block = $this->service->createBlock($data, $this->user);

        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => ContentBlock::class,
            'revisionable_id' => $block->id,
            'action' => 'created',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_it_creates_revision_on_block_update()
    {
        $block = ContentBlock::factory()->create([
            'page_id' => $this->page->id,
            'type' => 'text',
            'content' => ['content' => 'Old content'],
            'created_by' => $this->user->id,
        ]);

        $this->service->updateBlock($block, [
            'content' => ['content' => 'New content'],
        ], $this->user);

        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => ContentBlock::class,
            'revisionable_id' => $block->id,
            'action' => 'updated',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_it_creates_revision_on_block_deletion()
    {
        $block = ContentBlock::factory()->create([
            'page_id' => $this->page->id,
            'created_by' => $this->user->id,
        ]);

        $this->service->deleteBlock($block, $this->user);

        $this->assertDatabaseHas('revisions', [
            'revisionable_type' => ContentBlock::class,
            'revisionable_id' => $block->id,
            'action' => 'deleted',
            'user_id' => $this->user->id,
        ]);
    }
}
