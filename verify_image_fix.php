<?php
/**
 * Image Upload Fix Verification Script
 * 
 * Run this script to verify all image paths are correct in the database
 * Usage: php verify_image_fix.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Image Upload Fix Verification ===\n\n";

// Models to check
$models = [
    'App\Models\Activity' => 'image',
    'App\Models\Competition' => 'image',
    'App\Models\Graduate' => 'image',
    'App\Models\Event' => 'image',
    'App\Models\Gallery' => 'image',
    'App\Models\InternalProtocol' => 'image',
    'App\Models\ExternalProtocol' => 'image',
    'App\Models\PresidentContent' => 'image',
    'App\Models\Dean' => 'image',
    'App\Models\Department' => 'image',
    'App\Models\Testimonial' => 'photo',
    'App\Models\Training' => ['image1', 'image2', 'image3', 'image4'],
];

$totalChecked = 0;
$correctPaths = 0;
$incorrectPaths = 0;
$missingFiles = 0;

foreach ($models as $modelClass => $fields) {
    if (!class_exists($modelClass)) {
        echo "⚠️  Model $modelClass not found\n";
        continue;
    }

    $modelName = class_basename($modelClass);
    $fields = is_array($fields) ? $fields : [$fields];
    
    echo "Checking $modelName...\n";
    
    $records = $modelClass::all();
    
    foreach ($records as $record) {
        foreach ($fields as $field) {
            if (!empty($record->$field)) {
                $totalChecked++;
                $path = $record->$field;
                
                // Check if path starts with 'uploads/'
                if (strpos($path, 'uploads/') === 0) {
                    $correctPaths++;
                    
                    // Check if file exists
                    $fullPath = public_path($path);
                    if (!file_exists($fullPath)) {
                        echo "  ⚠️  File missing: $path (ID: {$record->id})\n";
                        $missingFiles++;
                    }
                } else {
                    $incorrectPaths++;
                    echo "  ❌ Incorrect path format: $path (ID: {$record->id})\n";
                    
                    // Suggest fix
                    if (strpos($path, 'storage/') === 0) {
                        echo "     Suggestion: Remove 'storage/' prefix\n";
                    } elseif (strpos($path, 'img/') === 0) {
                        echo "     Suggestion: Change 'img/' to 'uploads/'\n";
                    }
                }
            }
        }
    }
    
    echo "  ✓ Checked " . $records->count() . " records\n\n";
}

echo "=== Summary ===\n";
echo "Total images checked: $totalChecked\n";
echo "✅ Correct paths: $correctPaths\n";
echo "❌ Incorrect paths: $incorrectPaths\n";
echo "⚠️  Missing files: $missingFiles\n\n";

if ($incorrectPaths === 0 && $missingFiles === 0) {
    echo "🎉 All image paths are correct and files exist!\n";
} elseif ($incorrectPaths > 0) {
    echo "⚠️  Some paths need to be fixed in the database.\n";
    echo "   You may need to update old records or re-upload images.\n";
} else {
    echo "⚠️  Some image files are missing from the uploads directory.\n";
    echo "   You may need to re-upload these images.\n";
}

echo "\n=== Verification Complete ===\n";
