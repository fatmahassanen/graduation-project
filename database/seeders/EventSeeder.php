<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing events for idempotency
        Event::truncate();

        $events = [
            [
                'title' => 'Annual Technology Innovation Fair 2025',
                'slug' => 'tech-innovation-fair-2025',
                'category' => 'exhibition',
                'description' => 'Join us for the Annual Technology Innovation Fair showcasing student projects, research innovations, and industry partnerships. Experience cutting-edge technology demonstrations and network with industry leaders.',
                'event_date' => Carbon::now()->addDays(15),
                'location' => 'NCTU Main Campus, Exhibition Hall',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Robotics Workshop for Beginners',
                'slug' => 'robotics-workshop-beginners',
                'category' => 'training',
                'description' => 'A hands-on workshop introducing students to the fundamentals of robotics, programming, and automation. Perfect for beginners interested in mechatronics and robotics engineering.',
                'event_date' => Carbon::now()->addDays(10),
                'location' => 'Mechatronics Lab, Building A',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Career Day: Meet Industry Professionals',
                'slug' => 'career-day-2025',
                'category' => 'conference',
                'description' => 'Connect with leading companies in technology, engineering, and renewable energy sectors. Explore internship opportunities, full-time positions, and career guidance from industry experts.',
                'event_date' => Carbon::now()->addDays(20),
                'location' => 'NCTU Conference Center',
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
            $this->command->info("Created event: {$eventData['title']}");
        }

        $this->command->info('Events seeded successfully!');
    }
}
