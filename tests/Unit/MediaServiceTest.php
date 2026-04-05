<?php

namespace Tests\Unit;

use App\Models\ContentBlock;
use App\Models\Event;
use App\Models\Media;
use App\Models\News;
use App\Models\Page;
use App\Models\User;
use App\Services\MediaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class MediaServiceTest extends TestCase
{
    use RefreshDatabase;

    protected MediaService $mediaService;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->mediaService = new MediaService();
        $this->user = User::factory()->create(['role' => 'content_editor']);
    }

    public function test_upload_file_creates_media_record(): void
    {
        $file = UploadedFile::fake()->image('test-image.jpg', 800, 600)->size(1024);

        $media = $this->mediaService->uploadFile($file, $this->user);

        $this->assertInstanceOf(Media::class, $media);
        $this->assertEquals('test-image.jpg', $media->original_name);
        $this->assertEquals('image/jpeg', $media->mime_type);
        $this->assertEquals($this->user->id, $media->uploaded_by);
        $this->assertNotNull($media->filename);
        $this->assertNotNull($media->path);
    }

    public function test_upload_file_stores_file_in_storage(): void
    {
        $file = UploadedFile::fake()->image('test-image.jpg');

        $media = $this->mediaService->uploadFile($file, $this->user);

        Storage::disk('public')->assertExists($media->path);
    }

    public function test_upload_file_generates_unique_filename(): void
    {
        $file1 = UploadedFile::fake()->image('test.jpg');
        $file2 = UploadedFile::fake()->image('test.jpg');

        $media1 = $this->mediaService->uploadFile($file1, $this->user);
        $media2 = $this->mediaService->uploadFile($file2, $this->user);

        $this->assertNotEquals($media1->filename, $media2->filename);
    }

    public function test_upload_file_rejects_invalid_file_type(): void
    {
        $file = UploadedFile::fake()->create('test.exe', 100);

        $this->expectException(ValidationException::class);
        $this->mediaService->uploadFile($file, $this->user);
    }

    public function test_upload_file_rejects_file_exceeding_size_limit(): void
    {
        $file = UploadedFile::fake()->image('large.jpg')->size(11000); // 11MB

        $this->expectException(ValidationException::class);
        $this->mediaService->uploadFile($file, $this->user);
    }

    public function test_upload_file_accepts_all_allowed_types(): void
    {
        $allowedTypes = [
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
        ];

        foreach ($allowedTypes as $ext => $mime) {
            $file = UploadedFile::fake()->create("test.$ext", 100, $mime);
            $media = $this->mediaService->uploadFile($file, $this->user);
            $this->assertInstanceOf(Media::class, $media);
        }
    }

    public function test_delete_file_removes_file_and_record(): void
    {
        $file = UploadedFile::fake()->image('test.jpg');
        $media = $this->mediaService->uploadFile($file, $this->user);

        $result = $this->mediaService->deleteFile($media, $this->user);

        $this->assertTrue($result);
        Storage::disk('public')->assertMissing($media->path);
        $this->assertDatabaseMissing('media', ['id' => $media->id]);
    }

    public function test_delete_file_prevents_deletion_of_referenced_media_in_news(): void
    {
        $file = UploadedFile::fake()->image('test.jpg');
        $media = $this->mediaService->uploadFile($file, $this->user);

        News::factory()->create(['featured_image_id' => $media->id]);

        $this->expectException(ValidationException::class);
        $this->mediaService->deleteFile($media, $this->user);
    }

    public function test_delete_file_prevents_deletion_of_referenced_media_in_events(): void
    {
        $file = UploadedFile::fake()->image('test.jpg');
        $media = $this->mediaService->uploadFile($file, $this->user);

        Event::factory()->create(['image_id' => $media->id]);

        $this->expectException(ValidationException::class);
        $this->mediaService->deleteFile($media, $this->user);
    }

    public function test_delete_file_prevents_deletion_of_referenced_media_in_content_blocks(): void
    {
        $file = UploadedFile::fake()->image('test.jpg');
        $media = $this->mediaService->uploadFile($file, $this->user);

        $page = Page::factory()->create();
        ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Test',
                'description' => 'Test',
                'image' => $media->filename,
            ],
        ]);

        $this->expectException(ValidationException::class);
        $this->mediaService->deleteFile($media, $this->user);
    }

    public function test_is_file_referenced_returns_true_for_news(): void
    {
        $media = Media::factory()->create();
        News::factory()->create(['featured_image_id' => $media->id]);

        $result = $this->mediaService->isFileReferenced($media);

        $this->assertTrue($result);
    }

    public function test_is_file_referenced_returns_true_for_events(): void
    {
        $media = Media::factory()->create();
        Event::factory()->create(['image_id' => $media->id]);

        $result = $this->mediaService->isFileReferenced($media);

        $this->assertTrue($result);
    }

    public function test_is_file_referenced_returns_true_for_content_blocks(): void
    {
        $media = Media::factory()->create(['filename' => 'test-image.jpg']);
        $page = Page::factory()->create();
        ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Test',
                'description' => 'Test',
                'image' => 'test-image.jpg',
            ],
        ]);

        $result = $this->mediaService->isFileReferenced($media);

        $this->assertTrue($result);
    }

    public function test_is_file_referenced_returns_false_for_unreferenced_media(): void
    {
        $media = Media::factory()->create();

        $result = $this->mediaService->isFileReferenced($media);

        $this->assertFalse($result);
    }

    public function test_search_media_finds_by_filename(): void
    {
        Media::factory()->create(['filename' => 'test-image.jpg']);
        Media::factory()->create(['filename' => 'other-file.png']);

        $results = $this->mediaService->searchMedia('test-image');

        $this->assertCount(1, $results);
        $this->assertEquals('test-image.jpg', $results->first()->filename);
    }

    public function test_search_media_finds_by_original_name(): void
    {
        Media::factory()->create(['original_name' => 'My Photo.jpg']);
        Media::factory()->create(['original_name' => 'Other.png']);

        $results = $this->mediaService->searchMedia('Photo');

        $this->assertCount(1, $results);
        $this->assertEquals('My Photo.jpg', $results->first()->original_name);
    }

    public function test_search_media_finds_by_alt_text(): void
    {
        Media::factory()->create(['alt_text' => 'University campus']);
        Media::factory()->create(['alt_text' => 'Student photo']);

        $results = $this->mediaService->searchMedia('campus');

        $this->assertCount(1, $results);
        $this->assertEquals('University campus', $results->first()->alt_text);
    }

    public function test_search_media_filters_by_mime_type(): void
    {
        Media::factory()->create(['mime_type' => 'image/jpeg']);
        Media::factory()->create(['mime_type' => 'application/pdf']);

        $results = $this->mediaService->searchMedia('', ['mime_type' => 'image/jpeg']);

        $this->assertCount(1, $results);
        $this->assertEquals('image/jpeg', $results->first()->mime_type);
    }

    public function test_search_media_filters_by_uploaded_by(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Media::factory()->create(['uploaded_by' => $user1->id]);
        Media::factory()->create(['uploaded_by' => $user2->id]);

        $results = $this->mediaService->searchMedia('', ['uploaded_by' => $user1->id]);

        $this->assertCount(1, $results);
        $this->assertEquals($user1->id, $results->first()->uploaded_by);
    }

    public function test_search_media_filters_by_date_range(): void
    {
        Media::factory()->create(['created_at' => '2024-01-01']);
        Media::factory()->create(['created_at' => '2024-06-01']);
        Media::factory()->create(['created_at' => '2024-12-01']);

        $results = $this->mediaService->searchMedia('', [
            'date_from' => '2024-05-01',
            'date_to' => '2024-11-01',
        ]);

        $this->assertCount(1, $results);
    }

    public function test_search_media_returns_all_when_no_query(): void
    {
        Media::factory()->count(3)->create();

        $results = $this->mediaService->searchMedia('');

        $this->assertCount(3, $results);
    }

    public function test_search_media_orders_by_most_recent(): void
    {
        $old = Media::factory()->create(['created_at' => '2024-01-01']);
        $new = Media::factory()->create(['created_at' => '2024-12-01']);

        $results = $this->mediaService->searchMedia('');

        $this->assertEquals($new->id, $results->first()->id);
        $this->assertEquals($old->id, $results->last()->id);
    }

    public function test_generate_unique_filename_creates_unique_name(): void
    {
        $filename1 = $this->mediaService->generateUniqueFilename('test.jpg');
        $filename2 = $this->mediaService->generateUniqueFilename('test.jpg');

        $this->assertNotEquals($filename1, $filename2);
    }

    public function test_generate_unique_filename_preserves_extension(): void
    {
        $filename = $this->mediaService->generateUniqueFilename('test.jpg');

        $this->assertStringEndsWith('.jpg', $filename);
    }

    public function test_generate_unique_filename_sanitizes_name(): void
    {
        $filename = $this->mediaService->generateUniqueFilename('Test File!@#.jpg');

        $this->assertStringContainsString('test-file', $filename);
    }

    public function test_generate_unique_filename_avoids_database_collisions(): void
    {
        $filename = $this->mediaService->generateUniqueFilename('test.jpg');
        Media::factory()->create(['filename' => $filename]);

        $newFilename = $this->mediaService->generateUniqueFilename('test.jpg');

        $this->assertNotEquals($filename, $newFilename);
    }
}
