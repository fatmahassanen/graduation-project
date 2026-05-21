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
            // National ID field (14 digits, unique, indexed)
            $table->string('national_id', 14)->unique()->after('user_id')->index();

            // Gender (auto-extracted from national_id, editable)
            $table->enum('gender', ['male', 'female'])->after('fourth_name');

            // Governorate fields (two separate fields)
            $table->string('birth_governorate')->after('gender'); // From national_id, editable
            $table->string('current_governorate')->after('birth_governorate'); // User selects

            // Address breakdown (replacing full_address)
            $table->string('city_center')->after('current_governorate');
            $table->string('village_district')->after('city_center');
            $table->text('street_address')->after('village_district');

            // Drop old fields that are being replaced
            $table->dropColumn(['governorate', 'full_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            // Drop new fields
            $table->dropColumn([
                'national_id',
                'gender',
                'birth_governorate',
                'current_governorate',
                'city_center',
                'village_district',
                'street_address',
            ]);

            // Restore old fields
            $table->string('governorate')->after('birth_date');
            $table->text('full_address')->after('governorate');
        });
    }
};
