<?php

namespace App\Traits;

use App\Support\ImageProcessor;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

/**
 * Trait HandlesImageUploads
 *
 * Thin wrapper around ImageProcessor for controllers that prefer trait ergonomics.
 */
trait HandlesImageUploads
{
    protected function processSmartImage(
        UploadedFile $file,
        ?string $oldPath = null,
        bool $wasCropped = false,
        int $cropSize = 400
    ): string {
        return ImageProcessor::storeUploadedImage($file, $wasCropped, $cropSize, $oldPath);
    }

    protected function imageWasCropped(Request $request, string $field): bool
    {
        return ImageProcessor::croppedFromRequest($request, $field);
    }

    protected function deleteImage(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        ImageProcessor::deleteStoredImage($path);

        return true;
    }
}
