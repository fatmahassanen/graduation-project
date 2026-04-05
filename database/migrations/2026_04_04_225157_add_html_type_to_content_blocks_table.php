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
        // Modify the type enum to include 'html'
        DB::statement("ALTER TABLE content_blocks MODIFY COLUMN type ENUM('hero','text','card_grid','video','faq','testimonial','gallery','contact_form','html') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE content_blocks MODIFY COLUMN type ENUM('hero','text','card_grid','video','faq','testimonial','gallery','contact_form') NOT NULL");
    }
};
