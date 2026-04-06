<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();
        
        // SQLite doesn't support MODIFY COLUMN, so we skip this for SQLite
        // The validation is handled at the application level
        if ($driver === 'sqlite') {
            Log::warning('Skipping MODIFY COLUMN for SQLite compatibility in add_html_type_to_content_blocks_table migration');
            return;
        }
        
        DB::statement("ALTER TABLE content_blocks MODIFY COLUMN type ENUM('hero','text','card_grid','video','faq','testimonial','gallery','contact_form','html') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        
        // Revert back to original enum values
        if ($driver === 'sqlite') {
            Log::warning('Skipping MODIFY COLUMN for SQLite compatibility in add_html_type_to_content_blocks_table migration rollback');
            return;
        }
        
        DB::statement("ALTER TABLE content_blocks MODIFY COLUMN type ENUM('hero','text','card_grid','video','faq','testimonial','gallery','contact_form') NOT NULL");
    }
};
