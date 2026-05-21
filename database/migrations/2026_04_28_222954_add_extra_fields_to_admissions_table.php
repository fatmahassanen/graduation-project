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
            $table->string('religion')->nullable()->after('fourth_name');
            $table->date('birth_date')->nullable()->after('religion');
            $table->string('governorate')->nullable()->after('birth_date');
            $table->text('full_address')->nullable()->after('governorate');
            $table->string('father_occupation')->nullable()->after('parent_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            $table->dropColumn(['religion', 'birth_date', 'governorate', 'full_address', 'father_occupation']);
        });
    }
};
