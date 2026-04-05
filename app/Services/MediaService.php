<?php

namespace App\Services;

use App\Models\ContentBlock;
use App\Models\Event;
use App\Models\Media;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MediaService
{
    /**
     * Allowed file types and their MIME types.
     */
    protected array $allowedTypes = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    /**
     * Maximum file size in bytes (10MB).
     */
    protected int $maxFileSize = 10485760;

    /**
     * Upload a file and create a media record.
     */
    public function uploadFile(UploadedFile $file, User $user): Media
    {
        // Validate file type
        $extension = strtolower($file->getClientOriginalExtension());
        if (!isset($this->allowedTypes[$extension])) {
            throw ValidationException::withMessages([
                'file' => ['File type not allowed. Allowed types: jpg, jpeg, png, gif, svg, pdf, doc, docx'],
            ]);
        }

        // Validate file size (max 10MB)
        if ($file->getSize() > $this->maxFileSize) {
            throw ValidationException::withMessages([
                'file' => ['File size exceeds maximum allowed size of 10MB'],
            ]);
        }

        // Validate MIME type
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $this->allowedTypes)) {
            throw ValidationException::withMessages([
                'file' => ['Invalid file MIME type'],
            ]);
        }

        // Generate unique filename
        $originalName = $file->getClientOriginalName();
        $uniqueFilename = $this->generateUniqueFilename($originalName);

        // Optimize image if it's an image file
        if ($this->isImage($mimeType)) {
            $optimizedFile = $this->optimizeImage($file, $uniqueFilename);
            $path = $optimizedFile['path'];
            $fileSize = $optimizedFile['size'];
        } else {
            // Store file in storage/app/public/media
            $path = $file->storeAs('media', $uniqueFilename, 'public');
            $fileSize = $file->getSize();
        }

        // Create media record
        $media = Media::create([
            'filename' => $uniqueFilename,
            'original_name' => $originalName,
            'mime_type' => $mimeType,
            'size' => $fileSize,
            'path' => $path,
            'uploaded_by' => $user->id,
        ]);

        return $media;
    }

    /**
     * Check if MIME type is an image
     */
    protected function isImage(string $mimeType): bool
    {
        return in_array($mimeType, [
            'image/jpeg',
            'image/png',
            'image/gif',
        ]);
    }

    /**
     * Optimize image by compressing and generating WebP version
     */
    protected function optimizeImage(UploadedFile $file, string $filename): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $tempPath = $file->getRealPath();
        
        // Check if file is a real image file (not a fake test file)
        $imageInfo = @getimagesize($tempPath);
        if ($imageInfo === false) {
            // Fallback for fake/invalid images: store original file
            $path = $file->storeAs('media', $filename, 'public');
            return ['path' => $path, 'size' => $file->getSize()];
        }
        
        // Load image based on type
        $image = match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($tempPath),
            'png' => @imagecreatefrompng($tempPath),
            'gif' => @imagecreatefromgif($tempPath),
            default => null,
        };

        if (!$image) {
            // Fallback: store original file
            $path = $file->storeAs('media', $filename, 'public');
            return ['path' => $path, 'size' => $file->getSize()];
        }

        // Get image dimensions
        $width = imagesx($image);
        $height = imagesy($image);

        // Create a temporary file for the compressed image
        $tempCompressedPath = sys_get_temp_dir() . '/' . $filename;

        // Save compressed image (80% quality)
        if ($extension === 'png') {
            // PNG compression (0-9, where 9 is maximum compression)
            imagepng($image, $tempCompressedPath, 8);
        } else {
            // JPEG compression (0-100, where 100 is best quality)
            imagejpeg($image, $tempCompressedPath, 80);
        }

        // Store the compressed image using Storage facade
        $path = 'media/' . $filename;
        Storage::disk('public')->put($path, file_get_contents($tempCompressedPath));
        $fileSize = filesize($tempCompressedPath);

        // Generate WebP version for modern browsers
        if (function_exists('imagewebp')) {
            $webpFilename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
            $tempWebpPath = sys_get_temp_dir() . '/' . $webpFilename;
            imagewebp($image, $tempWebpPath, 80);
            
            $webpPath = 'media/' . $webpFilename;
            Storage::disk('public')->put($webpPath, file_get_contents($tempWebpPath));
            
            // Clean up temp WebP file
            @unlink($tempWebpPath);
        }

        // Clean up
        imagedestroy($image);
        @unlink($tempCompressedPath);

        return [
            'path' => $path,
            'size' => $fileSize,
        ];
    }

    /**
     * Delete a media file and its database record.
     */
    public function deleteFile(Media $media, User $user): bool
    {
        // Check if file is referenced
        if ($this->isFileReferenced($media)) {
            throw ValidationException::withMessages([
                'media' => ['Cannot delete media file that is referenced in published content'],
            ]);
        }

        // Delete file from storage
        if (Storage::disk('public')->exists($media->path)) {
            Storage::disk('public')->delete($media->path);
        }

        // Delete database record
        return $media->delete();
    }

    /**
     * Check if a media file is referenced in content.
     */
    public function isFileReferenced(Media $media): bool
    {
        // Check if referenced in news articles (featured_image_id)
        $referencedInNews = News::where('featured_image_id', $media->id)->exists();
        if ($referencedInNews) {
            return true;
        }

        // Check if referenced in events (image_id)
        $referencedInEvents = Event::where('image_id', $media->id)->exists();
        if ($referencedInEvents) {
            return true;
        }

        // Check if referenced in content blocks (JSON content field)
        // Use database-agnostic approach by fetching and checking in PHP
        $contentBlocks = ContentBlock::all();
        
        foreach ($contentBlocks as $block) {
            $content = json_encode($block->content);
            
            // Check if filename or media ID appears in the JSON content
            if (str_contains($content, $media->filename) || 
                str_contains($content, (string) $media->id)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Search media with filters.
     */
    public function searchMedia(string $query, array $filters = []): Collection
    {
        $queryBuilder = Media::query();

        // Search by filename or alt_text
        if (!empty($query)) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('filename', 'like', '%' . $query . '%')
                    ->orWhere('original_name', 'like', '%' . $query . '%')
                    ->orWhere('alt_text', 'like', '%' . $query . '%');
            });
        }

        // Filter by mime_type
        if (isset($filters['mime_type']) && !empty($filters['mime_type'])) {
            $queryBuilder->where('mime_type', $filters['mime_type']);
        }

        // Filter by uploaded_by
        if (isset($filters['uploaded_by']) && !empty($filters['uploaded_by'])) {
            $queryBuilder->where('uploaded_by', $filters['uploaded_by']);
        }

        // Filter by date range
        if (isset($filters['date_from']) && !empty($filters['date_from'])) {
            $queryBuilder->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to']) && !empty($filters['date_to'])) {
            $queryBuilder->whereDate('created_at', '<=', $filters['date_to']);
        }

        // Order by most recent first
        $queryBuilder->orderBy('created_at', 'desc');

        return $queryBuilder->get();
    }

    /**
     * Generate a unique filename to prevent collisions.
     */
    public function generateUniqueFilename(string $originalName): string
    {
        // Get file extension
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);

        // Sanitize filename
        $sanitized = Str::slug($nameWithoutExtension);

        // Generate unique filename with timestamp and random string
        $uniqueFilename = $sanitized . '-' . time() . '-' . Str::random(8) . '.' . $extension;

        // Ensure filename doesn't exist in database
        while (Media::where('filename', $uniqueFilename)->exists()) {
            $uniqueFilename = $sanitized . '-' . time() . '-' . Str::random(8) . '.' . $extension;
        }

        return $uniqueFilename;
    }
}
