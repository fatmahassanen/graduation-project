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
        // Step 1: Add new single image column
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('image', 255)->nullable()->after('description');
        });

        // Step 2: Migrate existing data (take first available image)
        DB::table('trainings')->get()->each(function ($training) {
            $firstImage = $training->image1 
                ?? $training->image2 
                ?? $training->image3 
                ?? $training->image4;
            
            if ($firstImage) {
                DB::table('trainings')
                    ->where('id', $training->id)
                    ->update(['image' => $firstImage]);
            }
        });

        // Step 3: Drop old image columns
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['image1', 'image2', 'image3', 'image4']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore old structure
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('image1', 255)->nullable()->after('description');
            $table->string('image2', 255)->nullable()->after('image1');
            $table->string('image3', 255)->nullable()->after('image2');
            $table->string('image4', 255)->nullable()->after('image3');
        });

        // Migrate data back (put single image into image1)
        DB::table('trainings')->get()->each(function ($training) {
            if ($training->image) {
                DB::table('trainings')
                    ->where('id', $training->id)
                    ->update(['image1' => $training->image]);
            }
        });

        // Drop new column
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
