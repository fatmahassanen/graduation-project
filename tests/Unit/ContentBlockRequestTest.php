<?php

namespace Tests\Unit;

use App\Http\Requests\ContentBlockRequest;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ContentBlockRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_validates_required_fields(): void
    {
        $request = new ContentBlockRequest();
        $validator = Validator::make([], $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('page_id'));
        $this->assertTrue($validator->errors()->has('type'));
        $this->assertTrue($validator->errors()->has('content'));
    }

    public function test_it_validates_page_id_exists(): void
    {
        $request = new ContentBlockRequest();
        $data = [
            'page_id' => 99999,
            'type' => 'text',
            'content' => ['content' => 'Test content'],
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('page_id'));
    }

    public function test_it_validates_type_enum(): void
    {
        $page = Page::factory()->create();
        
        $request = new ContentBlockRequest();
        $data = [
            'page_id' => $page->id,
            'type' => 'invalid_type',
            'content' => ['content' => 'Test content'],
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('type'));
    }

    public function test_it_accepts_valid_types(): void
    {
        $page = Page::factory()->create();
        $validTypes = [
            'hero',
            'text',
            'card_grid',
            'video',
            'faq',
            'testimonial',
            'gallery',
            'contact_form',
        ];

        foreach ($validTypes as $type) {
            $request = new ContentBlockRequest();
            $data = [
                'page_id' => $page->id,
                'type' => $type,
                'content' => ['test' => 'data'],
            ];
            $validator = Validator::make($data, $request->rules());

            $this->assertTrue($validator->passes(), "Type {$type} should be valid");
        }
    }

    public function test_it_validates_content_is_array(): void
    {
        $page = Page::factory()->create();
        
        $request = new ContentBlockRequest();
        $data = [
            'page_id' => $page->id,
            'type' => 'text',
            'content' => 'not an array',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('content'));
    }

    public function test_it_validates_display_order_is_integer(): void
    {
        $page = Page::factory()->create();
        
        $request = new ContentBlockRequest();
        $data = [
            'page_id' => $page->id,
            'type' => 'text',
            'content' => ['content' => 'Test'],
            'display_order' => 'not_an_integer',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('display_order'));
    }

    public function test_it_validates_display_order_minimum(): void
    {
        $page = Page::factory()->create();
        
        $request = new ContentBlockRequest();
        $data = [
            'page_id' => $page->id,
            'type' => 'text',
            'content' => ['content' => 'Test'],
            'display_order' => -1,
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('display_order'));
    }

    public function test_it_validates_is_reusable_is_boolean(): void
    {
        $page = Page::factory()->create();
        
        $request = new ContentBlockRequest();
        $data = [
            'page_id' => $page->id,
            'type' => 'text',
            'content' => ['content' => 'Test'],
            'is_reusable' => 'not_boolean',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('is_reusable'));
    }

    public function test_it_validates_hero_block_content_schema(): void
    {
        $page = Page::factory()->create();
        
        $request = new ContentBlockRequest();
        $request->merge([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => ['title' => 'Test'], // Missing required fields
        ]);
        
        $validator = Validator::make($request->all(), $request->rules());
        $request->withValidator($validator);
        
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('content'));
    }

    public function test_it_validates_text_block_content_schema(): void
    {
        $page = Page::factory()->create();
        
        $request = new ContentBlockRequest();
        $request->merge([
            'page_id' => $page->id,
            'type' => 'text',
            'content' => [], // Missing required content field
        ]);
        
        $validator = Validator::make($request->all(), $request->rules());
        $request->withValidator($validator);
        
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('content'));
    }

    public function test_it_passes_with_valid_text_block(): void
    {
        $page = Page::factory()->create();
        
        $request = new ContentBlockRequest();
        $request->merge([
            'page_id' => $page->id,
            'type' => 'text',
            'content' => ['content' => 'Valid text content'],
        ]);
        
        $validator = Validator::make($request->all(), $request->rules());
        $request->withValidator($validator);
        
        $this->assertTrue($validator->passes());
        $this->assertFalse($validator->errors()->has('content'));
    }

    public function test_it_passes_with_valid_hero_block(): void
    {
        $page = Page::factory()->create();
        
        $request = new ContentBlockRequest();
        $request->merge([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Hero Title',
                'description' => 'Hero Description',
                'image' => 'https://example.com/image.jpg',
            ],
        ]);
        
        $validator = Validator::make($request->all(), $request->rules());
        $request->withValidator($validator);
        
        $this->assertTrue($validator->passes());
        $this->assertFalse($validator->errors()->has('content'));
    }
}
