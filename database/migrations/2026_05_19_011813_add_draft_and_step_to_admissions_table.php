<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            // Change status enum to include 'draft'
            $table->enum('status', ['draft', 'pending', 'accepted', 'rejected'])->default('draft')->change();
            
            // Add current_step to track wizard progress
            $table->integer('current_step')->default(1)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            // Revert status enum back to original
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending')->change();
            
            // Drop current_step column
            $table->dropColumn('current_step');
        });
    }
};
