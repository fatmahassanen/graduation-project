<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\TuitionFee;
use Illuminate\Database\Seeder;

class TuitionFeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set academic year in site settings
        SiteSetting::set('academic_year', '2025–2026');
        SiteSetting::set('fees_announcement', 'As announced in August 2025, there will be no increase in tuition fees for the upcoming year.');

        // Create tuition fee categories
        TuitionFee::create([
            'year_range' => 'Year 1 & Year 2',
            'amount' => 15000.00,
            'order' => 1,
            'is_active' => true,
        ]);

        TuitionFee::create([
            'year_range' => 'Year 3 & Year 4',
            'amount' => 20000.00,
            'order' => 2,
            'is_active' => true,
        ]);
    }
}
