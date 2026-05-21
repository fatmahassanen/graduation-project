<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('image1')->nullable()->after('description');
            $table->string('image2')->nullable()->after('image1');
            $table->string('image3')->nullable()->after('image2');
            $table->string('image4')->nullable()->after('image3');
        });

        // Migrate existing data: move 'image' to 'image1'
        DB::table('trainings')->whereNotNull('image')->update([
            'image1' => DB::raw('image'),
        ]);

        // Remove old 'image' and 'images' columns
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['image', 'images']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
            $table->json('images')->nullable()->after('image');
        });

        // Migrate back: move 'image1' to 'image'
        DB::table('trainings')->whereNotNull('image1')->update([
            'image' => DB::raw('image1'),
        ]);

        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['image1', 'image2', 'image3', 'image4']);
        });
    }
};
