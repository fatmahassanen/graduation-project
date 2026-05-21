<?php

namespace App\Traits;

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
        // Delete old image if exists
        if ($oldPath) {
            $this->deleteImage($oldPath);
        }

        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->extension();
        
        // Move file to public/uploads directory
        $file->move(public_path('uploads'), $filename);

        // Return the relative path
        return 'uploads/' . $filename;
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
