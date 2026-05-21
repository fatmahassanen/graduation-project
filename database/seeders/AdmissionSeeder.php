<?php

namespace Database\Seeders;

use App\Models\Admission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 pending admissions for testing approval workflow
        Admission::factory()->count(5)->pending()->create();

        // Create 3 already accepted admissions with student codes
        Admission::factory()->count(3)->accepted()->create([
            'reviewed_by' => 1, // Admin user ID
        ]);

        // Create 2 rejected admissions
        Admission::factory()->count(2)->rejected()->create([
            'reviewed_by' => 1, // Admin user ID
        ]);
    }
}
