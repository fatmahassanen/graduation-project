<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite doesn't support MODIFY COLUMN, skip this migration
            return;
        }
        
        DB::statement("ALTER TABLE content_blocks MODIFY COLUMN type ENUM('hero','text','card_grid','video','faq','testimonial','gallery','contact_form','html','image') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite doesn't support MODIFY COLUMN, skip this migration
            return;
        }
        
        DB::statement("ALTER TABLE content_blocks MODIFY COLUMN type ENUM('hero','text','card_grid','video','faq','testimonial','gallery','contact_form','html') NOT NULL");
    }
};
