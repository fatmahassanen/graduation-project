<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'student_name' => 'Fatima (Tomi)',
                'department' => 'ICT Department',
                'testimonial' => 'The practical training at NCTU helped me master Laravel and web development.',
                'photo' => null,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'student_name' => 'Ahmed Hassan',
                'department' => 'Mechatronics Department',
                'testimonial' => 'NCTU provided me with hands-on experience in robotics and automation that prepared me for my career.',
                'photo' => null,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'student_name' => 'Sara Mohamed',
                'department' => 'Petroleum Department',
                'testimonial' => 'The field training program gave me real-world experience in the oil and gas industry.',
                'photo' => null,
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
