<?php

namespace Tests\Unit;

use App\Http\Requests\EventRequest;
use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class EventRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_validates_required_fields(): void
    {
        $request = new EventRequest();
        $validator = Validator::make([], $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('title'));
        $this->assertTrue($validator->errors()->has('description'));
        $this->assertTrue($validator->errors()->has('start_date'));
        $this->assertTrue($validator->errors()->has('end_date'));
        $this->assertTrue($validator->errors()->has('category'));
        $this->assertTrue($validator->errors()->has('language'));
        $this->assertTrue($validator->errors()->has('status'));
    }

    public function test_it_validates_title_max_length(): void
    {
        $request = new EventRequest();
        $data = [
            'title' => str_repeat('a', 256),
            'description' => 'Test description',
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-02',
            'category' => 'conference',
            'language' => 'en',
            'status' => 'draft',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('title'));
    }

    public function test_it_validates_end_date_after_start_date(): void
    {
        $request = new EventRequest();
        $data = [
            'title' => 'Test Event',
            'description' => 'Test description',
            'start_date' => '2024-01-02',
            'end_date' => '2024-01-01',
            'category' => 'conference',
            'language' => 'en',
            'status' => 'draft',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('end_date'));
    }

    public function test_it_accepts_same_start_and_end_date(): void
    {
        $request = new EventRequest();
        $data = [
            'title' => 'Test Event',
            'description' => 'Test description',
            'start_date' => '2024-01-01 10:00:00',
            'end_date' => '2024-01-01 18:00:00',
            'category' => 'conference',
            'language' => 'en',
            'status' => 'draft',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_it_validates_category_enum(): void
    {
        $request = new EventRequest();
        $data = [
            'title' => 'Test Event',
            'description' => 'Test description',
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-02',
            'category' => 'invalid_category',
            'language' => 'en',
            'status' => 'draft',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('category'));
    }

    public function test_it_accepts_valid_categories(): void
    {
        $validCategories = [
            'competition',
            'conference',
            'exhibition',
            'workshop',
            'seminar',
        ];

        foreach ($validCategories as $category) {
            $request = new EventRequest();
            $data = [
                'title' => 'Test Event',
                'description' => 'Test description',
                'start_date' => '2024-01-01',
                'end_date' => '2024-01-02',
                'category' => $category,
                'language' => 'en',
                'status' => 'draft',
            ];
            $validator = Validator::make($data, $request->rules());

            $this->assertTrue($validator->passes(), "Category {$category} should be valid");
        }
    }

    public function test_it_validates_status_enum(): void
    {
        $request = new EventRequest();
        $data = [
            'title' => 'Test Event',
            'description' => 'Test description',
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-02',
            'category' => 'conference',
            'language' => 'en',
            'status' => 'invalid_status',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('status'));
    }

    public function test_it_validates_language_length(): void
    {
        $request = new EventRequest();
        $data = [
            'title' => 'Test Event',
            'description' => 'Test description',
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-02',
            'category' => 'conference',
            'language' => 'eng',
            'status' => 'draft',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('language'));
    }

    public function test_it_validates_image_id_exists(): void
    {
        $request = new EventRequest();
        $data = [
            'title' => 'Test Event',
            'description' => 'Test description',
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-02',
            'category' => 'conference',
            'image_id' => 99999,
            'language' => 'en',
            'status' => 'draft',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('image_id'));
    }

    public function test_it_accepts_valid_image_id(): void
    {
        $media = Media::factory()->create();
        
        $request = new EventRequest();
        $data = [
            'title' => 'Test Event',
            'description' => 'Test description',
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-02',
            'category' => 'conference',
            'image_id' => $media->id,
            'language' => 'en',
            'status' => 'draft',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_it_validates_location_max_length(): void
    {
        $request = new EventRequest();
        $data = [
            'title' => 'Test Event',
            'description' => 'Test description',
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-02',
            'location' => str_repeat('a', 256),
            'category' => 'conference',
            'language' => 'en',
            'status' => 'draft',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('location'));
    }

    public function test_it_passes_with_valid_data(): void
    {
        $request = new EventRequest();
        $data = [
            'title' => 'Test Event',
            'description' => 'Test description',
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-02',
            'location' => 'Main Hall',
            'category' => 'conference',
            'language' => 'en',
            'status' => 'published',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }
}
