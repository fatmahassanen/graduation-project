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

            // Leadership and Administration
            [
                'title' => 'University President',
                'slug' => 'president',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'University President - NCTU',
                'meta_description' => 'Meet the president of New Cairo Technological University',
                'published_at' => now(),
            ],
            [
                'title' => 'Dean of Industrial & Energy Technology',
                'slug' => 'dean1',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Dean of Industrial & Energy Technology - NCTU',
                'meta_description' => 'Leadership of the Faculty of Industrial and Energy Technology',
                'published_at' => now(),
            ],
            [
                'title' => 'Dean of Applied Health Sciences Technology',
                'slug' => 'dean2',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Dean of Applied Health Sciences Technology - NCTU',
                'meta_description' => 'Leadership of the Faculty of Applied Health Sciences Technology',
                'published_at' => now(),
            ],
            [
                'title' => 'Students Affairs Vice Dean',
                'slug' => 'dean3',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Students Affairs Vice Dean - NCTU',
                'meta_description' => 'Vice Dean overseeing student affairs and services',
                'published_at' => now(),
            ],

            // Campus and Protocols
            [
                'title' => 'Campus Tour',
                'slug' => 'campus',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Campus Tour - NCTU',
                'meta_description' => 'Explore our modern campus facilities and infrastructure',
                'published_at' => now(),
            ],
            [
                'title' => 'Internal Protocols',
                'slug' => 'internal-protocols',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Internal Protocols - NCTU',
                'meta_description' => 'University internal protocols and procedures',
                'published_at' => now(),
            ],
            [
                'title' => 'External Protocols',
                'slug' => 'external-protocols',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'External Protocols - NCTU',
                'meta_description' => 'External partnerships and collaboration protocols',
                'published_at' => now(),
            ],

            // About NCTU
            [
                'title' => 'Top 10 Reasons',
                'slug' => 'reasons',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Top 10 Reasons to Choose NCTU',
                'meta_description' => 'Discover why NCTU is the right choice for your education',
                'published_at' => now(),
            ],
            [
                'title' => 'Competitions',
                'slug' => 'competitions',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Competitions - NCTU',
                'meta_description' => 'Student competitions and achievements at NCTU',
                'published_at' => now(),
            ],
            [
                'title' => 'Graduate Achievements',
                'slug' => 'graduates',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Graduate Achievements - NCTU',
                'meta_description' => 'Success stories and achievements of NCTU graduates',
                'published_at' => now(),
            ],
            [
                'title' => 'Contacts',
                'slug' => 'contact',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Contact Us - NCTU',
                'meta_description' => 'Get in touch with New Cairo Technological University',
                'published_at' => now(),
            ],

            // University Units
            [
                'title' => 'Digital Transformation',
                'slug' => 'digital-transformation',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Digital Transformation - NCTU',
                'meta_description' => 'Digital transformation initiatives at NCTU',
                'published_at' => now(),
            ],
            [
                'title' => 'International Cooperation',
                'slug' => 'international-cooperation',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'International Cooperation - NCTU',
                'meta_description' => 'International partnerships and exchange programs',
                'published_at' => now(),
            ],
            [
                'title' => 'Quality Assurance',
                'slug' => 'quality',
                'category' => 'quality',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Quality Assurance - NCTU',
                'meta_description' => 'Quality assurance and standards at NCTU',
                'published_at' => now(),
            ],
            [
                'title' => 'Measurement and Evaluation',
                'slug' => 'evaluation',
                'category' => 'quality',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Measurement and Evaluation - NCTU',
                'meta_description' => 'Assessment and evaluation systems at NCTU',
                'published_at' => now(),
            ],
            [
                'title' => 'Combating Violence Against Women',
                'slug' => 'women',
                'category' => 'about',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Combating Violence Against Women - NCTU',
                'meta_description' => 'Support and prevention services for a safe campus environment',
                'published_at' => now(),
            ],

            // Additional Faculty
            [
                'title' => 'Faculty of Applied Health Sciences Technology',
                'slug' => 'faculty-health',
                'category' => 'faculties',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Faculty of Applied Health Sciences Technology - NCTU',
                'meta_description' => 'Healthcare technology programs and departments',
                'published_at' => now(),
            ],

            // Admissions
            [
                'title' => 'How to Apply Online',
                'slug' => 'how-apply',
                'category' => 'admissions',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'How to Apply Online - NCTU',
                'meta_description' => 'Step-by-step guide to online application process',
                'published_at' => now(),
            ],
            [
                'title' => 'Faculties Requirements',
                'slug' => 'faculties-requirements',
                'category' => 'admissions',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Faculties Requirements - NCTU',
                'meta_description' => 'Admission requirements for each faculty',
                'published_at' => now(),
            ],
            [
                'title' => 'Postgraduate Programs',
                'slug' => 'postgraduate-studies',
                'category' => 'admissions',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Postgraduate Programs - NCTU',
                'meta_description' => 'Master and doctoral programs at NCTU',
                'published_at' => now(),
            ],
            [
                'title' => 'Tuition Fees & Scholarships',
                'slug' => 'fees',
                'category' => 'admissions',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Tuition Fees & Scholarships - NCTU',
                'meta_description' => 'Information about tuition fees and available scholarships',
                'published_at' => now(),
            ],

            // Campus Life
            [
                'title' => 'Entrepreneur',
                'slug' => 'entrepreneur',
                'category' => 'campus',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Entrepreneurship - NCTU',
                'meta_description' => 'Entrepreneurship programs and startup support at NCTU',
                'published_at' => now(),
            ],
            [
                'title' => 'Student Activities',
                'slug' => 'activities',
                'category' => 'campus',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Student Activities - NCTU',
                'meta_description' => 'Clubs, sports, and student organizations at NCTU',
                'published_at' => now(),
            ],

            // Staff
            [
                'title' => 'Staff LMS',
                'slug' => 'staff-lms',
                'category' => 'staff',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Staff LMS - NCTU',
                'meta_description' => 'Staff learning management system portal',
                'published_at' => now(),
            ],
            [
                'title' => 'Profile',
                'slug' => 'profile',
                'category' => 'staff',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Staff Profile - NCTU',
                'meta_description' => 'Manage your staff profile and information',
                'published_at' => now(),
            ],
            [
                'title' => 'Staff Members',
                'slug' => 'members',
                'category' => 'staff',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Staff Members - NCTU',
                'meta_description' => 'Directory of faculty and staff members',
                'published_at' => now(),
            ],

            // Student Services
            [
                'title' => 'Students LMS',
                'slug' => 'student-service',
                'category' => 'student_services',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Students LMS - NCTU',
                'meta_description' => 'Student learning management system portal',
                'published_at' => now(),
            ],
            [
                'title' => 'Student Affairs',
                'slug' => 'student-booking',
                'category' => 'student_services',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Student Affairs - NCTU',
                'meta_description' => 'Student affairs office and services',
                'published_at' => now(),
            ],
            [
                'title' => 'Training',
                'slug' => 'trainings',
                'category' => 'student_services',
                'status' => 'published',
                'language' => 'en',
                'meta_title' => 'Training Programs - NCTU',
                'meta_description' => 'Skills training and professional development programs',
                'published_at' => now(),
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
