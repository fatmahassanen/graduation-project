<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

/**
 * Smart image processing using Intervention Image v4.
 *
 * When the client skipped cropping, the full image is compressed to JPEG.
 * When the client cropped in the browser, the image is locked to a square cover crop.
 */
class ImageProcessor
{
    public static function storeUploadedImage(
        UploadedFile $file,
        bool $wasCropped,
        int $size = 400,
        ?string $oldPath = null
    ): string {
        if ($oldPath) {
            self::deleteStoredImage($oldPath);
        }

        $manager = ImageManager::usingDriver(Driver::class);
        $image = $manager->read($file->getRealPath());

        if ($wasCropped) {
            $image->cover($size, $size);
        }

        $encoded = $image->encodeUsingFormat(Format::JPEG, quality: 80);

        $filename = time().'_'.uniqid().'.jpg';
        $relativePath = 'uploads/'.$filename;
        $encoded->save(public_path($relativePath));

        return $relativePath;
    }

    public static function deleteStoredImage(?string $path): void
    {
        if (! $path) {
            return;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');
        $normalized = preg_replace('#^(?:public/|storage/)+#', '', $normalized);

        $fullPath = public_path($normalized);
        if (file_exists($fullPath)) {
            unlink($fullPath);

            return;
        }

        $storagePath = storage_path('app/public/'.$normalized);
        if (file_exists($storagePath)) {
            unlink($storagePath);
        }
    }
}
