<?php

namespace App\Traits;

use App\Support\ImageProcessor;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

/**
 * Trait HandlesImageUploads
 *
 * Provides reusable methods for handling image uploads and deletions.
 * Follows DRY (Don't Repeat Yourself) principle.
 * 
 * Images are stored directly in public/uploads directory.
 * Database stores the relative path: uploads/filename.jpg
 * Views use: asset($model->image)
 */
trait HandlesImageUploads
{
    /**
     * Upload a single image to public/uploads directory.
     *
     * @param  UploadedFile  $file  The uploaded file
     * @param  string  $directory  Subdirectory within uploads (e.g., 'trainings', 'departments')
     * @param  string|null  $oldPath  Path to old image to delete
     * @return string The stored path (uploads/filename.jpg)
     */
    protected function uploadImage(UploadedFile $file, string $directory, ?string $oldPath = null): string
    {
        return $this->processSmartImage($file, $oldPath, false);
    }

    /**
     * Process an uploaded image with Intervention Image.
     *
     * @param  UploadedFile  $file  The uploaded file
     * @param  string|null  $oldPath  Path to old image to delete
     * @param  bool  $wasCropped  Whether the browser cropper was used
     * @param  int  $cropSize  Target square size when cropped
     */
    protected function processSmartImage(
        UploadedFile $file,
        ?string $oldPath = null,
        bool $wasCropped = false,
        int $cropSize = 400
    ): string {
        return ImageProcessor::storeUploadedImage($file, $wasCropped, $cropSize, $oldPath);
    }

    /**
     * Resolve whether the client used the cropper for a given field.
     */
    protected function imageWasCropped(Request $request, string $field): bool
    {
        return $request->boolean($field.'_cropped');
    }

    /**
     * Delete an image from public directory.
     *
     * @param  string  $path  The relative path to delete (e.g., 'uploads/filename.jpg')
     * @return bool True if deleted, false otherwise
     */
    protected function deleteImage(string $path): bool
    {
        $fullPath = public_path($path);
        
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }

        return false;
    }

    /**
     * Upload multiple images to public/uploads directory.
     *
     * @param  array  $files  Array of uploaded files
     * @param  string  $directory  Subdirectory within uploads
     * @param  array  $oldPaths  Array of old image paths to delete
     * @return array Array of stored paths (uploads/filename.jpg)
     */
    protected function uploadMultipleImages(array $files, string $directory, array $oldPaths = []): array
    {
        // Delete old images
        foreach ($oldPaths as $oldPath) {
            $this->deleteImage($oldPath);
        }

        // Upload new images
        $paths = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $filename = time() . '_' . uniqid() . '.' . $file->extension();
                $file->move(public_path('uploads'), $filename);
                $paths[] = 'uploads/' . $filename;
            }
        }

        return $paths;
    }
}
