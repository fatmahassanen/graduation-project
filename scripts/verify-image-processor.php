<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use App\Support\ImageProcessor;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$candidates = array_merge(
    glob(public_path('uploads/*.{jpg,jpeg,png,gif,webp}'), GLOB_BRACE) ?: [],
    glob(public_path('img/*.{jpg,jpeg,png,gif,webp}'), GLOB_BRACE) ?: []
);

if ($candidates === []) {
    fwrite(STDERR, "No sample image found.\n");
    exit(1);
}

$source = $candidates[0];
$temp = sys_get_temp_dir().DIRECTORY_SEPARATOR.'vibe-processor-test-'.uniqid().'.jpg';
copy($source, $temp);

$uploaded = new UploadedFile($temp, basename($temp), mime_content_type($temp) ?: 'image/jpeg', null, true);

try {
    $path = ImageProcessor::storeUploadedImage($uploaded, true, 400);
    $full = public_path($path);
    echo 'OK '.$path.' '.filesize($full)." bytes\n";
    ImageProcessor::deleteStoredImage($path);
    exit(0);
} catch (Throwable $e) {
    fwrite(STDERR, 'FAIL '.$e::class.': '.$e->getMessage()."\n");
    exit(1);
} finally {
    @unlink($temp);
}
