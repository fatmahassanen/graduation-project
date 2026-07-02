<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

/**
 * Central smart-image pipeline for Intervention Image v4.
 *
 * Browser cropper sets {field}_cropped=1; when true we enforce a square cover crop.
 * All uploads are normalized to JPEG (quality 80) under public/uploads/.
 */
class ImageProcessor
{
    public static function storeUploadedImage(
        UploadedFile $file,
        bool $wasCropped,
        int $size = 400,
        ?string $oldPath = null,
        bool $useOriginalName = false
    ): string {
        // #region agent log
        self::debugLog('ImageProcessor.php:storeUploadedImage:entry', 'Processing upload', [
            'hypothesisId' => 'H1',
            'wasCropped' => $wasCropped,
            'size' => $size,
            'mime' => $file->getMimeType(),
            'originalName' => $file->getClientOriginalName(),
            'useOriginalName' => $useOriginalName,
        ]);
        // #endregion

        if ($oldPath) {
            self::deleteStoredImage($oldPath);
        }

        $manager = ImageManager::usingDriver(Driver::class);
        $image = $manager->decode($file);

        if ($wasCropped) {
            $image->scale(width: $size);
        }

        $encoded = $image->encodeUsingFormat(Format::JPEG, quality: 80);

        // Generate filename based on preference
        if ($useOriginalName) {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
            $filename = time().'_'.$cleanName.'.jpg';
        } else {
            $filename = time().'_'.uniqid().'.jpg';
        }

        $relativePath = 'uploads/'.$filename;
        $absolutePath = public_path($relativePath);

        if (! is_dir(dirname($absolutePath))) {
            mkdir(dirname($absolutePath), 0755, true);
        }

        $encoded->save($absolutePath);

        // #region agent log
        self::debugLog('ImageProcessor.php:storeUploadedImage:exit', 'Image stored', [
            'hypothesisId' => 'H1',
            'path' => $relativePath,
            'bytes' => file_exists($absolutePath) ? filesize($absolutePath) : 0,
            'wasCropped' => $wasCropped,
            'useOriginalName' => $useOriginalName,
        ]);
        // #endregion

        return $relativePath;
    }

    public static function croppedFromRequest(Request $request, string $field): bool
    {
        return $request->boolean($field.'_cropped');
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

    // #region agent log
    private static function debugLog(string $location, string $message, array $data = []): void
    {
        $payload = array_merge([
            'sessionId' => '6e401c',
            'runId' => 'pre-fix',
            'location' => $location,
            'message' => $message,
            'timestamp' => (int) round(microtime(true) * 1000),
        ], $data);

        @file_put_contents(base_path('debug-6e401c.log'), json_encode($payload)."\n", FILE_APPEND);
    }
    // #endregion
}
