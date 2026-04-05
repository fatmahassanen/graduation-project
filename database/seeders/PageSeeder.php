<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();

        if (!$admin) {
            $this->command->warn('Super admin not found. Please run UserSeeder first.');
            return;
        }

        $pages = [
            // Home page
            [
                'title' => 'Welcome to NCTU',
                'slug' => 'home',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'New Cairo Technological University - NCTU',
                'meta_description' => 'Welcome to New Cairo Technological University - A leading institution for higher education in Egypt',
                'published_at' => now(),
            ],

            // Admissions category
            [
                'title' => 'Admissions Overview',
                'slug' => 'admissions',
                'category' => 'admissions',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Admissions - NCTU',
                'meta_description' => 'Learn about admission requirements and application process at NCTU',
                'published_at' => now(),
            ],
            [
                'title' => 'Application Process',
                'slug' => 'application-process',
                'category' => 'admissions',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Application Process - NCTU',
                'meta_description' => 'Step-by-step guide to applying to NCTU',
                'published_at' => now(),
            ],
            [
                'title' => 'Tuition and Fees',
                'slug' => 'tuition-fees',
                'category' => 'admissions',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Tuition and Fees - NCTU',
                'meta_description' => 'Information about tuition costs and payment options',
                'published_at' => now(),
            ],

            // Faculties category
            [
                'title' => 'Faculty of Engineering',
                'slug' => 'faculty-engineering',
                'category' => 'faculties',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Faculty of Engineering - NCTU',
                'meta_description' => 'Explore engineering programs at NCTU',
                'published_at' => now(),
            ],
            [
                'title' => 'Faculty of Information Technology',
                'slug' => 'faculty-it',
                'category' => 'faculties',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Faculty of IT - NCTU',
                'meta_description' => 'Discover IT programs and courses at NCTU',
                'published_at' => now(),
            ],
            [
                'title' => 'Faculty of Business',
                'slug' => 'faculty-business',
                'category' => 'faculties',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Faculty of Business - NCTU',
                'meta_description' => 'Business administration and management programs',
                'published_at' => now(),
            ],

            // Events category
            [
                'title' => 'Upcoming Events',
                'slug' => 'events',
                'category' => 'events',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Events - NCTU',
                'meta_description' => 'Stay updated with NCTU events and activities',
                'published_at' => now(),
            ],
            [
                'title' => 'Past Events',
                'slug' => 'past-events',
                'category' => 'events',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Past Events - NCTU',
                'meta_description' => 'Browse our archive of past events',
                'published_at' => now(),
            ],

            // About category
            [
                'title' => 'About NCTU',
                'slug' => 'about',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'About Us - NCTU',
                'meta_description' => 'Learn about New Cairo Technological University',
                'published_at' => now(),
            ],
            [
                'title' => 'Our Mission and Vision',
                'slug' => 'mission-vision',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Mission and Vision - NCTU',
                'meta_description' => 'Our mission and vision for excellence in education',
                'published_at' => now(),
            ],
            [
                'title' => 'Leadership Team',
                'slug' => 'leadership',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Leadership - NCTU',
                'meta_description' => 'Meet the leadership team at NCTU',
                'published_at' => now(),
            ],

            // Quality category
            [
                'title' => 'Quality Assurance',
                'slug' => 'quality-assurance',
                'category' => 'quality',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Quality Assurance - NCTU',
                'meta_description' => 'Our commitment to quality education',
                'published_at' => now(),
            ],
            [
                'title' => 'Accreditation',
                'slug' => 'accreditation',
                'category' => 'quality',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Accreditation - NCTU',
                'meta_description' => 'NCTU accreditation and certifications',
                'published_at' => now(),
            ],

            // Media category
            [
                'title' => 'Photo Gallery',
                'slug' => 'gallery',
                'category' => 'media',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Photo Gallery - NCTU',
                'meta_description' => 'Browse photos from NCTU campus and events',
                'published_at' => now(),
            ],
            [
                'title' => 'News and Updates',
                'slug' => 'news',
                'category' => 'media',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'News - NCTU',
                'meta_description' => 'Latest news and updates from NCTU',
                'published_at' => now(),
            ],

            // Campus category
            [
                'title' => 'Campus Life',
                'slug' => 'campus-life',
                'category' => 'campus',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Campus Life - NCTU',
                'meta_description' => 'Experience life at NCTU campus',
                'published_at' => now(),
            ],
            [
                'title' => 'Campus Facilities',
                'slug' => 'facilities',
                'category' => 'campus',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Facilities - NCTU',
                'meta_description' => 'Explore our state-of-the-art facilities',
                'published_at' => now(),
            ],
            [
                'title' => 'Campus Map',
                'slug' => 'campus-map',
                'category' => 'campus',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Campus Map - NCTU',
                'meta_description' => 'Navigate NCTU campus with our interactive map',
                'published_at' => now(),
            ],

            // Staff category
            [
                'title' => 'Faculty Members',
                'slug' => 'faculty-members',
                'category' => 'staff',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Faculty Members - NCTU',
                'meta_description' => 'Meet our distinguished faculty members',
                'published_at' => now(),
            ],
            [
                'title' => 'Administrative Staff',
                'slug' => 'administrative-staff',
                'category' => 'staff',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Administrative Staff - NCTU',
                'meta_description' => 'Our dedicated administrative team',
                'published_at' => now(),
            ],

            // Student Services category
            [
                'title' => 'Student Services',
                'slug' => 'student-services',
                'category' => 'student_services',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Student Services - NCTU',
                'meta_description' => 'Support services for NCTU students',
                'published_at' => now(),
            ],
            [
                'title' => 'Library Services',
                'slug' => 'library',
                'category' => 'student_services',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Library - NCTU',
                'meta_description' => 'Access our comprehensive library resources',
                'published_at' => now(),
            ],
            [
                'title' => 'Career Services',
                'slug' => 'career-services',
                'category' => 'student_services',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Career Services - NCTU',
                'meta_description' => 'Career guidance and placement support',
                'published_at' => now(),
            ],

            // Draft pages for testing
            [
                'title' => 'Research Centers',
                'slug' => 'research-centers',
                'category' => 'about',
                'status' => 'draft',
                'language' => 'en',
                'meta_title' => 'Research Centers - NCTU',
                'meta_description' => 'Explore our research facilities',
                'published_at' => null,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::firstOrCreate(
                ['slug' => $pageData['slug'], 'language' => $pageData['language']],
                array_merge($pageData, [
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ])
            );
        }
    }
}
