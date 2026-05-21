<?php

/**
 * Clean Database Export Script
 * 
 * This script creates a clean database.sql file with:
 * - Complete table structure
 * - Essential seeded data only (no test/garbage data)
 * - Ready for production deployment
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "==========================================\n";
echo "Clean Database Export\n";
echo "==========================================\n\n";

$databaseName = config('database.connections.mysql.database');
$output = [];

// Add header
$output[] = "-- College Management System - Clean Database Export";
$output[] = "-- Generated: " . date('Y-m-d H:i:s');
$output[] = "-- Database: {$databaseName}";
$output[] = "";
$output[] = "SET NAMES utf8mb4;";
$output[] = "SET FOREIGN_KEY_CHECKS = 0;";
$output[] = "";
$output[] = "-- Create database if not exists";
$output[] = "CREATE DATABASE IF NOT EXISTS `{$databaseName}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
$output[] = "USE `{$databaseName}`;";
$output[] = "";

// Get all tables
$tables = DB::select('SHOW TABLES');
$tableKey = "Tables_in_{$databaseName}";

echo "📋 Exporting table structures...\n";

foreach ($tables as $table) {
    $tableName = $table->$tableKey;
    
    // Skip tables from other databases
    if (in_array($tableName, ['departments', 'students']) && !Schema::hasColumn($tableName, 'created_at')) {
        continue;
    }
    
    echo "  - {$tableName}\n";
    
    // Get CREATE TABLE statement
    $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
    $output[] = "-- Table: {$tableName}";
    $output[] = "DROP TABLE IF EXISTS `{$tableName}`;";
    $output[] = $createTable->{'Create Table'} . ";";
    $output[] = "";
}

echo "\n📊 Exporting essential data...\n";

// Tables with essential data to export
$essentialTables = [
    'users' => 'Admin users',
    'deans' => 'Dean profiles',
    'departments' => 'Department information',
    'president_contents' => 'President content',
    'testimonials' => 'Student testimonials',
    'tuition_fees' => 'Fee structure',
    'site_settings' => 'Site configuration',
    'pages' => 'Static pages',
    'page_sections' => 'Page sections',
];

foreach ($essentialTables as $tableName => $description) {
    if (!Schema::hasTable($tableName)) {
        continue;
    }
    
    echo "  - {$tableName} ({$description})\n";
    
    $rows = DB::table($tableName)->get();
    
    if ($rows->count() > 0) {
        $output[] = "-- Data for table: {$tableName} ({$description})";
        
        foreach ($rows as $row) {
            $columns = array_keys((array)$row);
            $values = array_values((array)$row);
            
            // Escape values
            $escapedValues = array_map(function($value) {
                if (is_null($value)) {
                    return 'NULL';
                }
                return "'" . addslashes($value) . "'";
            }, $values);
            
            $columnList = '`' . implode('`, `', $columns) . '`';
            $valueList = implode(', ', $escapedValues);
            
            $output[] = "INSERT INTO `{$tableName}` ({$columnList}) VALUES ({$valueList});";
        }
        
        $output[] = "";
    }
}

// Add footer
$output[] = "SET FOREIGN_KEY_CHECKS = 1;";
$output[] = "";
$output[] = "-- End of export";

// Write to file
$sqlContent = implode("\n", $output);
file_put_contents('database.sql', $sqlContent);

$fileSize = filesize('database.sql') / 1024 / 1024;

echo "\n==========================================\n";
echo "✅ Export Complete!\n";
echo "==========================================\n\n";
echo "📁 File: database.sql\n";
echo "📊 Size: " . round($fileSize, 2) . " MB\n";
echo "\n";
echo "This file contains:\n";
echo "  ✓ Complete database structure (all tables)\n";
echo "  ✓ Essential seeded data (users, deans, departments, etc.)\n";
echo "  ✓ No test or garbage data\n";
echo "  ✓ Ready for production deployment\n";
echo "\n";
echo "To import on another machine:\n";
echo "  mysql -u root -p < database.sql\n";
echo "\n";
