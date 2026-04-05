<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite doesn't support MODIFY COLUMN, so we skip this for SQLite
        // The validation is handled at the application level
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE content_blocks MODIFY COLUMN type ENUM('hero','text','card_grid','video','faq','testimonial','gallery','contact_form','html') NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE content_blocks MODIFY COLUMN type ENUM('hero','text','card_grid','video','faq','testimonial','gallery','contact_form') NOT NULL");
        }
    }
};
