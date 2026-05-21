<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventsDataSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            // Conferences
            [
                'title' => 'International Technology Conference 2026',
                'description' => 'Join us for the annual International Technology Conference featuring renowned speakers and cutting-edge research from various fields. Location: Main Auditorium, NCTU Campus. Date: May 15, 2026 at 9:00 AM.',
                'image' => null,
                'link' => '/conferences',
            ],
            [
                'title' => 'Engineering Excellence Summit',
                'description' => 'A premier gathering of engineering professionals and students to explore innovations in civil, mechanical, and electrical engineering. Location: Conference Hall B. Date: June 20, 2026 at 10:00 AM.',
                'image' => null,
                'link' => '/conferences',
            ],
            [
                'title' => 'Digital Transformation Forum',
                'description' => 'Explore the future of digital transformation in education and industry. Learn about AI, machine learning, and how technology is reshaping our world. Location: Innovation Center. Date: July 10, 2026 at 11:00 AM.',
                'image' => null,
                'link' => '/conferences',
            ],

            // Trainings
            [
                'title' => 'Professional Development Workshop Series',
                'description' => 'Comprehensive training sessions designed to enhance professional skills for students and faculty members. Topics include leadership, communication, and project management. Location: Training Center, Building C. Date: May 25, 2026 at 2:00 PM.',
                'image' => null,
                'link' => '/trainings-events',
            ],
            [
                'title' => 'Advanced Programming Bootcamp',
                'description' => 'Intensive hands-on training in modern programming languages and frameworks. Learn Python, JavaScript, React, and Node.js from industry professionals. Location: Computer Lab 3. Date: June 5, 2026 at 9:00 AM.',
                'image' => null,
                'link' => '/trainings-events',
            ],
            [
                'title' => 'Research Methodology Training',
                'description' => 'Learn essential research skills including literature review, data collection, analysis techniques, and academic writing. Ideal for graduate students and faculty. Location: Research Center. Date: June 15, 2026 at 1:00 PM.',
                'image' => null,
                'link' => '/trainings-events',
            ],

            // Exhibitions
            [
                'title' => 'Innovation & Technology Exhibition 2026',
                'description' => 'Showcase of cutting-edge technology, art, and innovation featuring student and faculty creative work. Explore projects from robotics to sustainable design and digital art. Location: Exhibition Hall, Main Building. Date: May 30, 2026 at 10:00 AM.',
                'image' => null,
                'link' => '/exhibitions',
            ],
            [
                'title' => 'Student Art & Design Showcase',
                'description' => 'Annual exhibition featuring creative works from our talented students. View paintings, sculptures, digital art, architectural models, and multimedia installations. Location: Art Gallery, Cultural Center. Date: June 12, 2026 at 11:00 AM.',
                'image' => null,
                'link' => '/exhibitions',
            ],
            [
                'title' => 'Sustainable Engineering Solutions Expo',
                'description' => 'Exhibition highlighting sustainable engineering projects and green technology innovations. Discover how our students contribute to environmental sustainability. Location: Engineering Building Lobby. Date: July 5, 2026 at 9:00 AM.',
                'image' => null,
                'link' => '/exhibitions',
            ],

            // Graduation Projects
            [
                'title' => 'Senior Capstone Project Presentations',
                'description' => 'Final year projects demonstrating innovation, research, and technical expertise. Students present capstone projects in engineering, computer science, business, and applied sciences. Location: Auditorium Complex. Date: June 1, 2026 at 9:00 AM.',
                'image' => null,
                'link' => '/graduation-projects',
            ],
            [
                'title' => 'Engineering Design Projects Showcase',
                'description' => 'Explore innovative engineering solutions developed by graduating students. Projects include smart city applications, renewable energy systems, and IoT implementations. Location: Engineering Labs. Date: June 8, 2026 at 10:00 AM.',
                'image' => null,
                'link' => '/graduation-projects',
            ],
            [
                'title' => 'Computer Science Final Projects Demo Day',
                'description' => 'Live demonstrations of software applications, mobile apps, AI systems, and web platforms developed by computer science graduates. Location: IT Building, Demo Lab. Date: June 18, 2026 at 2:00 PM.',
                'image' => null,
                'link' => '/graduation-projects',
            ],

            // Competitions
            [
                'title' => 'Annual Hackathon Challenge',
                'description' => '48-hour coding marathon where teams compete to build innovative software solutions. Academic, technical competitions for students to showcase their skills. Prizes for top three teams. Location: Innovation Hub. Date: May 20, 2026 at 8:00 AM.',
                'image' => null,
                'link' => '/competitions',
            ],
            [
                'title' => 'Robotics Competition 2026',
                'description' => 'Students compete in designing and programming autonomous robots to complete challenging tasks. Categories include line following, maze solving, and object manipulation. Location: Robotics Lab. Date: June 25, 2026 at 10:00 AM.',
                'image' => null,
                'link' => '/competitions',
            ],
            [
                'title' => 'Business Plan Competition',
                'description' => 'Entrepreneurship competition where student teams pitch their business ideas to a panel of investors and industry experts. Winners receive seed funding and mentorship. Location: Business School Auditorium. Date: July 15, 2026 at 1:00 PM.',
                'image' => null,
                'link' => '/competitions',
            ],
            [
                'title' => 'Inter-University Sports Championship',
                'description' => 'Annual sports competition featuring football, basketball, volleyball, and athletics. NCTU teams compete against other universities in a week-long tournament. Location: Sports Complex. Date: May 10, 2026 at 8:00 AM.',
                'image' => null,
                'link' => '/competitions',
            ],
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }
    }
}
