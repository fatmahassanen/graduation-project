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

class MediaServicePropertyTest extends TestCase
{
    use RefreshDatabase;

    protected MediaService $service;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->service = new MediaService();
        $this->user = User::factory()->create(['role' => 'content_editor']);
    }

    /**
     * Feature: university-cms-upgrade, Property 18: File Upload Validation
     * For any file upload attempt, validation SHALL correctly accept files matching
     * allowed types and sizes (≤10MB) and reject others.
     * 
     * **Validates: Requirements 7.3**
     */
    public function test_file_upload_validation_accepts_valid_and_rejects_invalid_files()
    {
        // Test with 100+ iterations of randomized file uploads
        for ($iteration = 0; $iteration < 100; $iteration++) {
            // Generate random valid file parameters
            $validTypes = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'pdf', 'doc', 'docx'];
            $validMimeTypes = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'svg' => 'image/svg+xml',
                'pdf' => 'application/pdf',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ];
            
            $randomValidType = $validTypes[array_rand($validTypes)];
            $randomValidSize = rand(100, 10240); // 100 bytes to 10MB in KB
            
            // Test 1: Valid file should be accepted
            $validFile = UploadedFile::fake()->create(
                "valid-file-{$iteration}.{$randomValidType}",
                $randomValidSize,
                $validMimeTypes[$randomValidType]
            );
            
            try {
                $media = $this->service->uploadFile($validFile, $this->user);
                $this->assertInstanceOf(Media::class, $media,
                    "Valid file with type {$randomValidType} and size {$randomValidSize}KB should be accepted (iteration {$iteration})");
                $this->assertEquals($validMimeTypes[$randomValidType], $media->mime_type);
            } catch (ValidationException $e) {
                $this->fail("Valid file should be accepted but was rejected: " . json_encode($e->errors()) . " (iteration {$iteration})");
            }
            
            // Test 2: Invalid file type should be rejected
            $invalidTypes = ['exe', 'bat', 'sh', 'php', 'js', 'html'];
            $randomInvalidType = $invalidTypes[array_rand($invalidTypes)];
            
            $invalidTypeFile = UploadedFile::fake()->create(
                "invalid-type-{$iteration}.{$randomInvalidType}",
                1024
            );
            
            $wasRejected = false;
            try {
                $this->service->uploadFile($invalidTypeFile, $this->user);
            } catch (ValidationException $e) {
                $wasRejected = true;
            }
            
            $this->assertTrue($wasRejected,
                "Invalid file type {$randomInvalidType} should be rejected (iteration {$iteration})");
            
            // Test 3: File exceeding size limit should be rejected
            $oversizedFile = UploadedFile::fake()->create(
                "oversized-{$iteration}.jpg",
                10241, // Just over 10MB
                'image/jpeg'
            );
            
            $wasRejected = false;
            try {
                $this->service->uploadFile($oversizedFile, $this->user);
            } catch (ValidationException $e) {
                $wasRejected = true;
            }
            
            $this->assertTrue($wasRejected,
                "File exceeding 10MB limit should be rejected (iteration {$iteration})");
        }
    }

    /**
     * Feature: university-cms-upgrade, Property 19: Unique Filename Generation
     * For any set of file uploads including files with duplicate original names,
     * all generated filenames SHALL be unique.
     * 
     * **Validates: Requirements 7.6**
     */
    public function test_unique_filename_generation_for_duplicate_uploads()
    {
        // Test with 100+ iterations of duplicate filename scenarios
        for ($iteration = 0; $iteration < 100; $iteration++) {
            $generatedFilenames = [];
            
            // Generate random number of duplicate uploads (2-10)
            $duplicateCount = rand(2, 10);
            $originalName = "test-file-{$iteration}.jpg";
            
            // Upload multiple files with the same original name
            for ($i = 0; $i < $duplicateCount; $i++) {
                $file = UploadedFile::fake()->image($originalName, 800, 600)->size(1024);
                
                $media = $this->service->uploadFile($file, $this->user);
                
                $this->assertNotNull($media->filename,
                    "Generated filename should not be null (iteration {$iteration}, upload {$i})");
                
                $generatedFilenames[] = $media->filename;
                
                // Verify original name is preserved
                $this->assertEquals($originalName, $media->original_name,
                    "Original name should be preserved (iteration {$iteration}, upload {$i})");
            }
            
            // Verify all generated filenames are unique
            $uniqueFilenames = array_unique($generatedFilenames);
            $this->assertCount(
                count($generatedFilenames),
                $uniqueFilenames,
                "All generated filenames should be unique for duplicate uploads. Got: " . 
                implode(', ', $generatedFilenames) . " (iteration {$iteration})"
            );
            
            // Verify no collisions in database
            foreach ($generatedFilenames as $filename) {
                $count = Media::where('filename', $filename)->count();
                $this->assertEquals(1, $count,
                    "Each filename should appear exactly once in database: {$filename} (iteration {$iteration})");
            }
            
            // Test with various special characters in filenames
            $specialNames = [
                "File With Spaces {$iteration}.jpg",
                "File-With-Dashes-{$iteration}.png",
                "File_With_Underscores_{$iteration}.pdf",
                "File!@#$%^&*(){$iteration}.jpg",
                "UPPERCASE-FILE-{$iteration}.JPG",
            ];
            
            $specialFilenames = [];
            foreach ($specialNames as $specialName) {
                $file = UploadedFile::fake()->create($specialName, 1024, 'image/jpeg');
                $media = $this->service->uploadFile($file, $this->user);
                $specialFilenames[] = $media->filename;
            }
            
            // Verify special character filenames are also unique
            $uniqueSpecialFilenames = array_unique($specialFilenames);
            $this->assertCount(
                count($specialFilenames),
                $uniqueSpecialFilenames,
                "Filenames with special characters should be unique (iteration {$iteration})"
            );
        }
    }

    /**
     * Feature: university-cms-upgrade, Property 21: Media Reference Integrity
     * For any media file referenced in published content, deletion attempts SHALL
     * fail to maintain referential integrity.
     * 
     * **Validates: Requirements 7.10**
     */
    public function test_media_reference_integrity_prevents_deletion_of_referenced_files()
    {
        // Test with 100+ iterations of various reference scenarios
        for ($iteration = 0; $iteration < 100; $iteration++) {
            // Test 1: Media referenced in News
            $newsMedia = Media::factory()->create(['uploaded_by' => $this->user->id]);
            News::factory()->create(['featured_image_id' => $newsMedia->id]);
            
            $deletionFailed = false;
            try {
                $this->service->deleteFile($newsMedia, $this->user);
            } catch (ValidationException $e) {
                $deletionFailed = true;
            }
            
            $this->assertTrue($deletionFailed,
                "Deletion of media referenced in News should fail (iteration {$iteration})");
            $this->assertDatabaseHas('media', ['id' => $newsMedia->id]);
            
            // Test 2: Media referenced in Events
            $eventMedia = Media::factory()->create(['uploaded_by' => $this->user->id]);
            Event::factory()->create(['image_id' => $eventMedia->id]);
            
            $deletionFailed = false;
            try {
                $this->service->deleteFile($eventMedia, $this->user);
            } catch (ValidationException $e) {
                $deletionFailed = true;
            }
            
            $this->assertTrue($deletionFailed,
                "Deletion of media referenced in Events should fail (iteration {$iteration})");
            $this->assertDatabaseHas('media', ['id' => $eventMedia->id]);
            
            // Test 3: Media referenced in ContentBlocks (various types)
            $blockTypes = ['hero', 'gallery', 'testimonial'];
            $randomBlockType = $blockTypes[array_rand($blockTypes)];
            
            $blockMedia = Media::factory()->create([
                'uploaded_by' => $this->user->id,
                'filename' => "block-media-{$iteration}.jpg",
            ]);
            
            $page = Page::factory()->create(['created_by' => $this->user->id]);
            
            // Create content block with media reference based on type
            $content = match($randomBlockType) {
                'hero' => [
                    'title' => "Hero Title {$iteration}",
                    'description' => "Hero Description {$iteration}",
                    'image' => $blockMedia->filename,
                ],
                'gallery' => [
                    'images' => [
                        ['url' => $blockMedia->filename],
                        ['url' => 'other-image.jpg'],
                    ],
                ],
                'testimonial' => [
                    'items' => [
                        [
                            'name' => "Person {$iteration}",
                            'role' => 'Student',
                            'content' => 'Great experience!',
                            'image' => $blockMedia->filename,
                        ],
                    ],
                ],
            };
            
            ContentBlock::factory()->create([
                'page_id' => $page->id,
                'type' => $randomBlockType,
                'content' => $content,
                'created_by' => $this->user->id,
            ]);
            
            $deletionFailed = false;
            try {
                $this->service->deleteFile($blockMedia, $this->user);
            } catch (ValidationException $e) {
                $deletionFailed = true;
            }
            
            $this->assertTrue($deletionFailed,
                "Deletion of media referenced in ContentBlock ({$randomBlockType}) should fail (iteration {$iteration})");
            $this->assertDatabaseHas('media', ['id' => $blockMedia->id]);
            
            // Test 4: Unreferenced media should be deletable
            $unreferencedMedia = Media::factory()->create(['uploaded_by' => $this->user->id]);
            
            try {
                $result = $this->service->deleteFile($unreferencedMedia, $this->user);
                $this->assertTrue($result,
                    "Deletion of unreferenced media should succeed (iteration {$iteration})");
                $this->assertDatabaseMissing('media', ['id' => $unreferencedMedia->id]);
            } catch (ValidationException $e) {
                $this->fail("Unreferenced media should be deletable but deletion failed (iteration {$iteration})");
            }
        }
    }
}
