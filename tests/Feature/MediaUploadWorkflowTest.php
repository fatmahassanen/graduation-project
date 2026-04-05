<?php

namespace Tests\Feature;

use App\Models\ContentBlock;
use App\Models\Media;
use App\Models\News;
use App\Models\Page;
use App\Models\User;
use App\Services\MediaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaUploadWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected MediaService $mediaService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'content_editor']);
        $this->mediaService = app(MediaService::class);
        Storage::fake('public');
    }

    public function test_media_upload_workflow_with_validation(): void
    {
        // Create a valid image file
        $file = UploadedFile::fake()->image('test-image.jpg', 800, 600)->size(2048); // 2MB

        // Upload the file
        $media = $this->mediaService->uploadFile($file, $this->user);

        // Verify media record was created
        $this->assertDatabaseHas('media', [
            'original_name' => 'test-image.jpg',
            'mime_type' => 'image/jpeg',
            'uploaded_by' => $this->user->id,
        ]);

        // Verify file metadata
        $this->assertNotNull($media->filename);
        $this->assertNotNull($media->path);
        $this->assertGreaterThan(0, $media->size);

        // Verify filename is unique
        $this->assertNotEquals('test-image.jpg', $media->filename);
        $this->assertStringContainsString('test-image', $media->filename);
    }

    public function test_media_upload_workflow_validates_file_type(): void
    {
        // Create an invalid file type
        $file = UploadedFile::fake()->create('test.exe', 100);

        // Attempt to upload should fail
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->mediaService->uploadFile($file, $this->user);
    }

    public function test_media_upload_workflow_validates_file_size(): void
    {
        // Create a file larger than 10MB
        $file = UploadedFile::fake()->image('large-image.jpg')->size(11000); // 11MB

        // Attempt to upload should fail
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->mediaService->uploadFile($file, $this->user);
    }

    public function test_media_reference_in_content_blocks(): void
    {
        // Upload a media file
        $file = UploadedFile::fake()->image('hero-image.jpg');
        $media = $this->mediaService->uploadFile($file, $this->user);

        // Create a page with content block referencing the media
        $page = Page::factory()->create([
            'status' => 'published',
            'created_by' => $this->user->id,
        ]);

        $contentBlock = ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Hero Title',
                'description' => 'Hero Description',
                'image' => $media->filename,
            ],
            'created_by' => $this->user->id,
        ]);

        // Verify content block references the media
        $this->assertStringContainsString($media->filename, json_encode($contentBlock->content));

        // Verify media is referenced
        $isReferenced = $this->mediaService->isFileReferenced($media);
        $this->assertTrue($isReferenced);
    }

    public function test_deletion_prevention_for_referenced_media(): void
    {
        // Upload a media file
        $file = UploadedFile::fake()->image('referenced-image.jpg');
        $media = $this->mediaService->uploadFile($file, $this->user);

        // Create a news article with the media as featured image
        $news = News::factory()->create([
            'status' => 'published',
            'featured_image_id' => $media->id,
            'author_id' => $this->user->id,
            'published_at' => now(),
        ]);

        // Attempt to delete the media should fail
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->expectExceptionMessage('Cannot delete media file that is referenced in published content');
        
        $this->mediaService->deleteFile($media, $this->user);
    }

    public function test_media_can_be_deleted_when_not_referenced(): void
    {
        // Upload a media file
        $file = UploadedFile::fake()->image('unreferenced-image.jpg');
        $media = $this->mediaService->uploadFile($file, $this->user);

        $mediaId = $media->id;

        // Delete the media
        $result = $this->mediaService->deleteFile($media, $this->user);

        // Verify deletion was successful
        $this->assertTrue($result);
        $this->assertDatabaseMissing('media', ['id' => $mediaId]);
    }

    public function test_complete_media_upload_workflow(): void
    {
        // Step 1: Upload multiple media files
        $file1 = UploadedFile::fake()->image('image1.jpg');
        $file2 = UploadedFile::fake()->image('image2.png');
        $file3 = UploadedFile::fake()->create('document.pdf', 500);

        $media1 = $this->mediaService->uploadFile($file1, $this->user);
        $media2 = $this->mediaService->uploadFile($file2, $this->user);
        $media3 = $this->mediaService->uploadFile($file3, $this->user);

        // Verify all files were uploaded
        $this->assertDatabaseCount('media', 3);

        // Step 2: Create a page with content blocks using the media
        $page = Page::factory()->create([
            'status' => 'published',
            'created_by' => $this->user->id,
        ]);

        ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Hero',
                'description' => 'Description',
                'image' => $media1->filename,
            ],
            'created_by' => $this->user->id,
        ]);

        ContentBlock::factory()->create([
            'page_id' => $page->id,
            'type' => 'gallery',
            'content' => [
                'images' => [
                    ['url' => $media2->filename, 'caption' => 'Image 2'],
                ],
            ],
            'created_by' => $this->user->id,
        ]);

        // Step 3: Verify referenced media cannot be deleted
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->mediaService->deleteFile($media1, $this->user);
    }

    public function test_unique_filename_generation_prevents_collisions(): void
    {
        // Upload multiple files with the same original name
        $file1 = UploadedFile::fake()->image('duplicate.jpg');
        $file2 = UploadedFile::fake()->image('duplicate.jpg');
        $file3 = UploadedFile::fake()->image('duplicate.jpg');

        $media1 = $this->mediaService->uploadFile($file1, $this->user);
        $media2 = $this->mediaService->uploadFile($file2, $this->user);
        $media3 = $this->mediaService->uploadFile($file3, $this->user);

        // Verify all files have unique filenames
        $this->assertNotEquals($media1->filename, $media2->filename);
        $this->assertNotEquals($media1->filename, $media3->filename);
        $this->assertNotEquals($media2->filename, $media3->filename);

        // Verify all media records were created
        $this->assertDatabaseHas('media', ['id' => $media1->id]);
        $this->assertDatabaseHas('media', ['id' => $media2->id]);
        $this->assertDatabaseHas('media', ['id' => $media3->id]);
    }
}
