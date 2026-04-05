<?php

namespace Tests\Unit;

use App\Http\Requests\MediaUploadRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class MediaUploadRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_validates_required_file(): void
    {
        $request = new MediaUploadRequest();
        $validator = Validator::make([], $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('file'));
    }

    public function test_it_validates_file_type(): void
    {
        $request = new MediaUploadRequest();
        $file = UploadedFile::fake()->create('document.txt', 100);
        
        $data = ['file' => $file];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('file'));
    }

    public function test_it_accepts_valid_image_types(): void
    {
        $validTypes = ['jpg', 'jpeg', 'png', 'gif', 'svg'];

        foreach ($validTypes as $type) {
            $request = new MediaUploadRequest();
            $file = UploadedFile::fake()->image("test.{$type}");
            
            $data = ['file' => $file];
            $validator = Validator::make($data, $request->rules());

            $this->assertTrue($validator->passes(), "File type {$type} should be valid");
        }
    }

    public function test_it_accepts_valid_document_types(): void
    {
        $validTypes = ['pdf', 'doc', 'docx'];

        foreach ($validTypes as $type) {
            $request = new MediaUploadRequest();
            $file = UploadedFile::fake()->create("document.{$type}", 100);
            
            $data = ['file' => $file];
            $validator = Validator::make($data, $request->rules());

            $this->assertTrue($validator->passes(), "File type {$type} should be valid");
        }
    }

    public function test_it_validates_file_size_limit(): void
    {
        $request = new MediaUploadRequest();
        $file = UploadedFile::fake()->create('large.pdf', 10241); // 10241 KB > 10240 KB limit
        
        $data = ['file' => $file];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('file'));
    }

    public function test_it_accepts_file_at_size_limit(): void
    {
        $request = new MediaUploadRequest();
        $file = UploadedFile::fake()->create('large.pdf', 10240); // Exactly 10MB
        
        $data = ['file' => $file];
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_it_validates_alt_text_max_length(): void
    {
        $request = new MediaUploadRequest();
        $file = UploadedFile::fake()->image('test.jpg');
        
        $data = [
            'file' => $file,
            'alt_text' => str_repeat('a', 256),
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('alt_text'));
    }

    public function test_it_allows_optional_alt_text(): void
    {
        $request = new MediaUploadRequest();
        $file = UploadedFile::fake()->image('test.jpg');
        
        $data = ['file' => $file];
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_it_passes_with_valid_data(): void
    {
        $request = new MediaUploadRequest();
        $file = UploadedFile::fake()->image('test.jpg');
        
        $data = [
            'file' => $file,
            'alt_text' => 'Test image description',
        ];
        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }
}
