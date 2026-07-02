<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadHelper
{
    /**
     * Upload a file with its original name (with timestamp to prevent overwriting).
     *
     * @param UploadedFile $file The uploaded file
     * @param string $directory The directory to store the file (e.g., 'admissions/documents')
     * @param string|null $oldFilePath The old file path to delete (optional)
     * @return string The stored file path
     */
    public static function uploadWithOriginalName(UploadedFile $file, string $directory, ?string $oldFilePath = null): string
    {
        // Get the original filename
        $originalName = $file->getClientOriginalName();
        
        // Get file extension
        $extension = $file->getClientOriginalExtension();
        
        // Get filename without extension
        $filenameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
        
        // Clean the filename (remove special characters)
        $cleanFilename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $filenameWithoutExt);
        
        // Create new filename with timestamp to prevent overwriting
        $timestamp = time();
        $newFilename = $timestamp . '_' . $cleanFilename . '.' . $extension;
        
        // Delete old file if exists
        if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
            Storage::disk('public')->delete($oldFilePath);
        }
        
        // Store the file with the new filename
        $path = Storage::disk('public')->putFileAs($directory, $file, $newFilename);
        
        return $path;
    }

    /**
     * Delete a file from storage.
     *
     * @param string|null $filePath The file path to delete
     * @return bool
     */
    public static function deleteFile(?string $filePath): bool
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }
        
        return false;
    }
}
