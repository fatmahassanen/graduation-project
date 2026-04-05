<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        $editor = User::where('role', 'content_editor')->first();

        if (!$admin || !$editor) {
            $this->command->warn('Users not found. Please run UserSeeder first.');
            return;
        }

        // Get sample event images if available
        $conferenceImage = Media::where('filename', 'event-conference.jpg')->first();
        $workshopImage = Media::where('filename', 'event-workshop.jpg')->first();

        $events = [
            // Competitions
            [
                'title' => 'Annual Robotics Competition',
                'description' => 'Join us for the annual robotics competition where students showcase their innovative robot designs and compete for prizes. Teams will demonstrate autonomous navigation, object manipulation, and problem-solving capabilities.',
                'start_date' => now()->addDays(15),
                'end_date' => now()->addDays(16),
                'location' => 'Engineering Building, Hall A',
                'category' => 'competition',
                'image_id' => $conferenceImage?->id,
                'is_recurring' => false,
                'language' => 'en',
                'status' => 'published',
                'created_by' => $editor->id,
            ],
            [
                'title' => 'Hackathon 2024',
                'description' => '48-hour coding marathon where students develop innovative software solutions. Prizes for best projects in categories: AI/ML, Web Development, Mobile Apps, and Social Impact.',
                'start_date' => now()->addDays(30),
                'end_date' => now()->addDays(32),
                'location' => 'IT Faculty Computer Labs',
                'category' => 'competition',
                'image_id' => null,
                'is_recurring' => false,
                'language' => 'en',
                'status' => 'published',
                'created_by' => $editor->id,
            ],
            [
                'title' => 'Business Plan Competition',
                'description' => 'Entrepreneurship competition for students to pitch their business ideas to industry experts and investors. Winners receive seed funding and mentorship.',
                'start_date' => now()->addDays(45),
                'end_date' => now()->addDays(45),
                'location' => 'Business Faculty Auditorium',
                'category' => 'competition',
                'image_id' => null,
                'is_recurring' => false,
                'language' => 'en',
                'status' => 'published',
                'created_by' => $admin->id,
            ],

            // Conferences
            [
                'title' => 'International Technology Conference 2024',
                'description' => 'Premier technology conference featuring keynote speakers from leading tech companies, research presentations, and networking opportunities. Topics include AI, IoT, Cybersecurity, and Cloud Computing.',
                'start_date' => now()->addDays(60),
                'end_date' => now()->addDays(62),
                'location' => 'NCTU Main Auditorium',
                'category' => 'conference',
                'image_id' => $conferenceImage?->id,
                'is_recurring' => true,
                'recurrence_rule' => 'FREQ=YEARLY;INTERVAL=1',
                'language' => 'en',
                'status' => 'published',
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Engineering Education Summit',
                'description' => 'Annual summit bringing together educators, researchers, and industry professionals to discuss the future of engineering education and emerging trends.',
                'start_date' => now()->addDays(75),
                'end_date' => now()->addDays(76),
                'location' => 'Conference Center',
                'category' => 'conference',
                'image_id' => null,
                'is_recurring' => true,
                'recurrence_rule' => 'FREQ=YEARLY;INTERVAL=1',
                'language' => 'en',
                'status' => 'published',
                'created_by' => $admin->id,
            ],

            // Exhibitions
            [
                'title' => 'Student Innovation Exhibition',
                'description' => 'Showcase of student projects and innovations across all faculties. Open to public, featuring interactive demonstrations and presentations.',
                'start_date' => now()->addDays(20),
                'end_date' => now()->addDays(22),
                'location' => 'Campus Exhibition Hall',
                'category' => 'exhibition',
                'image_id' => null,
                'is_recurring' => false,
                'language' => 'en',
                'status' => 'published',
                'created_by' => $editor->id,
            ],
            [
                'title' => 'Career Fair 2024',
                'description' => 'Annual career fair connecting students with leading employers. Meet recruiters, submit resumes, and explore internship and job opportunities.',
                'start_date' => now()->addDays(40),
                'end_date' => now()->addDays(41),
                'location' => 'Sports Complex',
                'category' => 'exhibition',
                'image_id' => null,
                'is_recurring' => true,
                'recurrence_rule' => 'FREQ=YEARLY;INTERVAL=1',
                'language' => 'en',
                'status' => 'published',
                'created_by' => $admin->id,
            ],

            // Workshops
            [
                'title' => 'Machine Learning Workshop',
                'description' => 'Hands-on workshop covering fundamentals of machine learning, neural networks, and practical applications using Python and TensorFlow.',
                'start_date' => now()->addDays(10),
                'end_date' => now()->addDays(10),
                'location' => 'IT Lab 301',
                'category' => 'workshop',
                'image_id' => $workshopImage?->id,
                'is_recurring' => false,
                'language' => 'en',
                'status' => 'published',
                'created_by' => $editor->id,
            ],
            [
                'title' => 'Web Development Bootcamp',
                'description' => 'Intensive 3-day bootcamp covering modern web development: HTML5, CSS3, JavaScript, React, and Node.js. Suitable for beginners.',
                'start_date' => now()->addDays(25),
                'end_date' => now()->addDays(27),
                'location' => 'IT Lab 205',
                'category' => 'workshop',
                'image_id' => null,
                'is_recurring' => false,
                'language' => 'en',
                'status' => 'published',
                'created_by' => $editor->id,
            ],
            [
                'title' => 'Digital Marketing Workshop',
                'description' => 'Learn essential digital marketing skills including SEO, social media marketing, content strategy, and analytics.',
                'start_date' => now()->addDays(35),
                'end_date' => now()->addDays(35),
                'location' => 'Business Faculty Room 102',
                'category' => 'workshop',
                'image_id' => null,
                'is_recurring' => false,
                'language' => 'en',
                'status' => 'published',
                'created_by' => $editor->id,
            ],

            // Seminars
            [
                'title' => 'Cybersecurity Best Practices Seminar',
                'description' => 'Expert-led seminar on cybersecurity threats, defense strategies, and best practices for protecting digital assets.',
                'start_date' => now()->addDays(12),
                'end_date' => now()->addDays(12),
                'location' => 'Lecture Hall B',
                'category' => 'seminar',
                'image_id' => null,
                'is_recurring' => false,
                'language' => 'en',
                'status' => 'published',
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Entrepreneurship and Startups',
                'description' => 'Seminar featuring successful entrepreneurs sharing their journey, challenges, and insights on building successful startups.',
                'start_date' => now()->addDays(28),
                'end_date' => now()->addDays(28),
                'location' => 'Auditorium C',
                'category' => 'seminar',
                'image_id' => null,
                'is_recurring' => false,
                'language' => 'en',
                'status' => 'published',
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Sustainable Engineering Practices',
                'description' => 'Seminar on sustainable engineering, green technologies, and environmental responsibility in modern engineering projects.',
                'start_date' => now()->addDays(50),
                'end_date' => now()->addDays(50),
                'location' => 'Engineering Auditorium',
                'category' => 'seminar',
                'image_id' => null,
                'is_recurring' => false,
                'language' => 'en',
                'status' => 'published',
                'created_by' => $admin->id,
            ],

            // Past event
            [
                'title' => 'Orientation Week 2024',
                'description' => 'Welcome event for new students featuring campus tours, faculty introductions, and student activities.',
                'start_date' => now()->subDays(30),
                'end_date' => now()->subDays(26),
                'location' => 'Campus Wide',
                'category' => 'seminar',
                'image_id' => null,
                'is_recurring' => true,
                'recurrence_rule' => 'FREQ=YEARLY;INTERVAL=1',
                'language' => 'en',
                'status' => 'published',
                'created_by' => $admin->id,
            ],

            // Draft event
            [
                'title' => 'Research Symposium',
                'description' => 'Annual research symposium showcasing faculty and student research projects.',
                'start_date' => now()->addDays(90),
                'end_date' => now()->addDays(91),
                'location' => 'TBD',
                'category' => 'conference',
                'image_id' => null,
                'is_recurring' => false,
                'language' => 'en',
                'status' => 'draft',
                'created_by' => $admin->id,
            ],
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }
    }
}
