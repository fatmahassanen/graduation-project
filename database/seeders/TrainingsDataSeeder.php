<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Seeder;

class TrainingsDataSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $trainings = [
            [
                'title' => 'NCTU Students Train at the Heart of Egypt\'s Oil Fields',
                'description' => 'Students from the Petroleum Production program completed their 2024/2025 summer training in the Eastern Desert and South Sinai in collaboration with EGPC.',
                'instructor' => 'EGPC',
                'start_date' => '2025-07-28',
                'end_date' => null,
                'location' => 'Eastern Desert and South Sinai',
                'duration' => null,
                'capacity' => null,
                'category' => 'Technical',
                'is_active' => true,
            ],
            [
                'title' => 'Administrative Staff Training Program Launched',
                'description' => 'Specialized training for administrative staff focusing on technological and industrial advancements like SQL, ICDL, and Forms.',
                'instructor' => null,
                'start_date' => '2024-07-18',
                'end_date' => null,
                'location' => 'NCTU Campus',
                'duration' => null,
                'capacity' => null,
                'category' => 'Professional Development',
                'is_active' => true,
            ],
            [
                'title' => 'NTCU and LONGi Partner for Solar Energy Training',
                'description' => 'A three-day program combining theory and practice in PV systems and solar panel maintenance under LONGi supervision.',
                'instructor' => 'LONGi',
                'start_date' => '2024-09-18',
                'end_date' => '2024-09-20',
                'location' => 'NCTU Campus',
                'duration' => 24,
                'capacity' => null,
                'category' => 'Technical',
                'is_active' => true,
            ],
            [
                'title' => 'Mechatronics Students Summer Training at Qader Factory',
                'description' => 'Hands-on experience in automation control, mechanical systems, and electrical systems at the prestigious Qader Factory.',
                'instructor' => 'Qader Factory',
                'start_date' => '2025-07-21',
                'end_date' => null,
                'location' => 'Qader Factory',
                'duration' => null,
                'capacity' => null,
                'category' => 'Technical',
                'is_active' => true,
            ],
            [
                'title' => 'Field Training Program in Autotronics at Arab Contractors',
                'description' => 'Field training for first-year students to expose them to real work environments and modern automotive industry systems.',
                'instructor' => 'Arab Contractors',
                'start_date' => '2026-03-05',
                'end_date' => null,
                'location' => 'Arab Contractors',
                'duration' => null,
                'capacity' => null,
                'category' => 'Technical',
                'is_active' => true,
            ],
            [
                'title' => 'Free International Scholarship in Prosthetics',
                'description' => 'Collaboration for international accreditation in Prosthetics and Orthotics, aligning with Egypt\'s Vision 2030.',
                'instructor' => null,
                'start_date' => '2026-02-28',
                'end_date' => null,
                'location' => 'International',
                'duration' => null,
                'capacity' => null,
                'category' => 'Professional Development',
                'is_active' => true,
            ],
        ];

        foreach ($trainings as $training) {
            Training::create($training);
        }
    }
}
