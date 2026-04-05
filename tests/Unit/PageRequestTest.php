<?php

namespace Tests\Unit;

use App\Http\Requests\PageRequest;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class PageRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_validates_required_fields()
    {
        $request = new PageRequest();
        $validator = Validator::make([], $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('title'));
        $this->assertTrue($validator->errors()->has('category'));
        $this->assertTrue($validator->errors()->has('status'));
        $this->assertTrue($validator->errors()->has('language'));
    }

    public function test_it_validates_title_max_length()
    {
        $request = new PageRequest();
        $data = [
            'title' => str_repeat('a', 256),
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'en',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('title'));
    }

    public function test_it_validates_category_enum()
    {
        $request = new PageRequest();
        $data = [
            'title' => 'Test Page',
            'category' => 'invalid_category',
            'status' => 'draft',
            'language' => 'en',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('category'));
    }

    public function test_it_accepts_valid_categories()
    {
        $validCategories = [
            'admissions',
            'faculties',
            'events',
            'about',
            'quality',
            'media',
            'campus',
            'staff',
            'student_services',
        ];

        foreach ($validCategories as $category) {
            $request = new PageRequest();
            $data = [
                'title' => 'Test Page',
                'category' => $category,
                'status' => 'draft',
                'language' => 'en',
            ];
            $validator = Validator::make($data, $request->rules());

            $this->assertTrue($validator->passes(), "Category {$category} should be valid");
        }
    }

    public function test_it_validates_status_enum()
    {
        $request = new PageRequest();
        $data = [
            'title' => 'Test Page',
            'category' => 'admissions',
            'status' => 'invalid_status',
            'language' => 'en',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('status'));
    }

    public function test_it_accepts_valid_statuses()
    {
        $validStatuses = ['draft', 'published', 'archived'];

        foreach ($validStatuses as $status) {
            $request = new PageRequest();
            $data = [
                'title' => 'Test Page',
                'category' => 'admissions',
                'status' => $status,
                'language' => 'en',
            ];
            $validator = Validator::make($data, $request->rules());

            $this->assertTrue($validator->passes(), "Status {$status} should be valid");
        }
    }

    public function test_it_validates_language_length()
    {
        $request = new PageRequest();
        $data = [
            'title' => 'Test Page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'eng',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('language'));
    }

    public function test_it_validates_slug_uniqueness_per_language()
    {
        Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'en',
        ]);

        $request = new PageRequest();
        $request->merge(['language' => 'en']);
        
        $data = [
            'title' => 'Test Page',
            'slug' => 'test-page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'en',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('slug'));
    }

    public function test_it_allows_same_slug_for_different_languages()
    {
        Page::factory()->create([
            'slug' => 'test-page',
            'language' => 'en',
        ]);

        $request = new PageRequest();
        $request->merge(['language' => 'ar']);
        
        $data = [
            'title' => 'Test Page',
            'slug' => 'test-page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'ar',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_it_validates_optional_meta_fields()
    {
        $request = new PageRequest();
        $data = [
            'title' => 'Test Page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'en',
            'meta_title' => str_repeat('a', 256),
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('meta_title'));
    }

    public function test_it_passes_with_valid_data()
    {
        $request = new PageRequest();
        $data = [
            'title' => 'Test Page',
            'slug' => 'test-page',
            'category' => 'admissions',
            'status' => 'published',
            'language' => 'en',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'keyword1, keyword2',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }
}
