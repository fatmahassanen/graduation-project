<?php
/**
 * Fix Old Image Paths Script
 * 
 * This script updates old image paths in the database and moves files to the correct location.
 * 
 * Usage: php fix_old_image_paths.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Fixing Old Image Paths ===\n\n";

$totalFixed = 0;
$totalMoved = 0;
$totalErrors = 0;

// Define models and their image fields
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

foreach ($models as $modelClass => $fields) {
    if (!class_exists($modelClass)) {
        continue;
    }

    $modelName = class_basename($modelClass);
    $fields = is_array($fields) ? $fields : [$fields];
    
    echo "Processing $modelName...\n";
    
    $records = $modelClass::all();
    $modelFixed = 0;
    
    foreach ($records as $record) {
        $updated = false;
        
        foreach ($fields as $field) {
            if (!empty($record->$field)) {
                $oldPath = $record->$field;
                
                // Skip if already correct
                if (strpos($oldPath, 'uploads/') === 0) {
                    continue;
                }
                
                $newPath = null;
                $oldFullPath = null;
                
                // Determine old full path and new path
                if (strpos($oldPath, 'img/') === 0) {
                    // Path like: img/activities1.jpg or img/index/auto.jpeg
                    $filename = basename($oldPath);
                    $oldFullPath = public_path($oldPath);
                    $newPath = 'uploads/' . $filename;
                } elseif (strpos($oldPath, 'storage/') === 0) {
                    // Path like: storage/images/file.jpg
                    $filename = basename($oldPath);
                    $oldFullPath = public_path($oldPath);
                    $newPath = 'uploads/' . $filename;
                } elseif (strpos($oldPath, 'Events/') === 0 || strpos($oldPath, '/') !== false) {
                    // Path like: Events/CO.jpg
                    $filename = basename($oldPath);
                    $oldFullPath = public_path('img/' . $oldPath);
                    $newPath = 'uploads/' . $filename;
                } else {
                    // Path like: motafq.png (just filename)
                    $filename = $oldPath;
                    $oldFullPath = public_path('img/' . $oldPath);
                    $newPath = 'uploads/' . $filename;
                }
                
                // Try to move the file if it exists
                $newFullPath = public_path($newPath);
                
                if (file_exists($oldFullPath)) {
                    // Create uploads directory if it doesn't exist
                    $uploadsDir = dirname($newFullPath);
                    if (!is_dir($uploadsDir)) {
                        mkdir($uploadsDir, 0755, true);
                    }
                    
                    // Copy file to new location (don't delete old one yet, just in case)
                    if (copy($oldFullPath, $newFullPath)) {
                        echo "  ✓ Moved: $oldPath → $newPath\n";
                        $totalMoved++;
                    } else {
                        echo "  ⚠️  Failed to copy: $oldPath\n";
                        $totalErrors++;
                        continue; // Don't update database if file copy failed
                    }
                } else {
                    echo "  ⚠️  File not found: $oldFullPath (will update path anyway)\n";
                }
                
                // Update database
                $record->$field = $newPath;
                $updated = true;
            }
        }
        
        if ($updated) {
            $record->save();
            $modelFixed++;
            $totalFixed++;
        }
    }
    
    if ($modelFixed > 0) {
        echo "  ✓ Fixed $modelFixed records\n";
    }
    echo "\n";
}

echo "=== Summary ===\n";
echo "Total records fixed: $totalFixed\n";
echo "Total files moved: $totalMoved\n";
echo "Total errors: $totalErrors\n\n";

if ($totalFixed > 0) {
    echo "🎉 Successfully fixed $totalFixed records!\n";
    echo "\nNext steps:\n";
    echo "1. Test the website to ensure images display correctly\n";
    echo "2. If everything works, you can safely delete old image files from public/img/\n";
    echo "3. Run: php verify_image_fix.php to verify all paths are correct\n";
} else {
    echo "✓ No records needed fixing.\n";
}

echo "\n=== Fix Complete ===\n";
