<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class AllPagesContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        
        if (!$admin) {
            $this->command->warn('Admin user not found.');
            return;
        }

        $pagesContent = [
            'about' => [
                [
                    'type' => 'hero',
                    'content' => [
                        'title' => 'About NCTU',
                        'description' => 'New Cairo Technological University is a leading institution dedicated to excellence in technological education.',
                        'image' => '/img/univercty2.jpg',
                    ],
                    'display_order' => 1,
                ],
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h2>Our Story</h2><p>New Cairo Technological University (NCTU) was established to meet the growing demand for skilled professionals in technology and engineering fields. We combine theoretical knowledge with practical skills to prepare students for successful careers.</p><h3>Our Values</h3><ul><li>Excellence in Education</li><li>Innovation and Research</li><li>Industry Partnerships</li><li>Student Success</li></ul>',
                    ],
                    'display_order' => 2,
                ],
            ],
            'admissions' => [
                [
                    'type' => 'hero',
                    'content' => [
                        'title' => 'Admissions',
                        'description' => 'Start your journey at NCTU. Learn about our admission requirements and application process.',
                        'image' => '/img/univercty2.jpg',
                    ],
                    'display_order' => 1,
                ],
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h2>Admission Requirements</h2><p>NCTU welcomes applications from qualified students. 80% of seats are allocated to technical diploma holders, while 20% are reserved for general secondary certificate holders.</p><h3>Required Documents</h3><ul><li>High school diploma or equivalent</li><li>Official transcripts</li><li>National ID or passport</li><li>Birth certificate</li><li>Recent photographs</li></ul>',
                    ],
                    'display_order' => 2,
                ],
            ],
            'application-process' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Application Process</h1><h3>Step 1: Online Registration</h3><p>Create an account on our admission portal and fill out the application form.</p><h3>Step 2: Submit Documents</h3><p>Upload all required documents in PDF format.</p><h3>Step 3: Pay Application Fee</h3><p>Complete the payment process online.</p><h3>Step 4: Wait for Review</h3><p>Our admissions team will review your application within 2-3 weeks.</p><h3>Step 5: Receive Decision</h3><p>You will be notified via email about the admission decision.</p>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'tuition-fees' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Tuition and Fees</h1><h3>Undergraduate Programs</h3><p>Annual tuition fees vary by program. Scholarships and financial aid are available for qualified students.</p><h3>Payment Options</h3><ul><li>Full payment discount available</li><li>Semester payment plans</li><li>Monthly installments</li></ul><h3>Scholarships</h3><p>We offer merit-based and need-based scholarships. Contact the financial aid office for more information.</p>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'faculty-engineering' => [
                [
                    'type' => 'hero',
                    'content' => [
                        'title' => 'Faculty of Engineering',
                        'description' => 'Explore cutting-edge engineering programs designed for the future.',
                        'image' => '/img/index/mecha.jpeg',
                    ],
                    'display_order' => 1,
                ],
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h2>Engineering Programs</h2><p>Our Faculty of Engineering offers comprehensive programs in various engineering disciplines.</p><h3>Departments</h3><ul><li>Mechanical Engineering</li><li>Electrical Engineering</li><li>Civil Engineering</li><li>Automotive Engineering</li><li>Mechatronics Engineering</li></ul>',
                    ],
                    'display_order' => 2,
                ],
            ],
            'faculty-it' => [
                [
                    'type' => 'hero',
                    'content' => [
                        'title' => 'Faculty of Information Technology',
                        'description' => 'Master the technologies shaping our digital future.',
                        'image' => '/img/index/info.jpeg',
                    ],
                    'display_order' => 1,
                ],
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h2>IT Programs</h2><p>Stay ahead in the rapidly evolving tech industry with our comprehensive IT programs.</p><h3>Specializations</h3><ul><li>Software Engineering</li><li>Computer Science</li><li>Information Systems</li><li>Cybersecurity</li><li>Data Science</li></ul>',
                    ],
                    'display_order' => 2,
                ],
            ],
            'faculty-business' => [
                [
                    'type' => 'hero',
                    'content' => [
                        'title' => 'Faculty of Business',
                        'description' => 'Develop leadership skills and business acumen for tomorrow\'s challenges.',
                        'image' => '/img/index/auto.jpeg',
                    ],
                    'display_order' => 1,
                ],
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h2>Business Programs</h2><p>Our business programs combine theoretical knowledge with practical experience.</p><h3>Programs</h3><ul><li>Business Administration</li><li>Marketing</li><li>Finance</li><li>Entrepreneurship</li><li>International Business</li></ul>',
                    ],
                    'display_order' => 2,
                ],
            ],
            'mission-vision' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Mission and Vision</h1><h2>Our Mission</h2><p>To provide world-class technological education that prepares students for successful careers and contributes to Egypt\'s technological advancement.</p><h2>Our Vision</h2><p>To be the leading technological university in Egypt and the region, recognized for excellence in education, research, and innovation.</p><h2>Our Goals</h2><ul><li>Deliver high-quality education aligned with industry needs</li><li>Foster innovation and entrepreneurship</li><li>Build strong partnerships with industry</li><li>Contribute to community development</li></ul>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'leadership' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Leadership Team</h1><h2>University President</h2><p>Prof. Mahmoud El-Sheikh leads NCTU with a vision for excellence in technological education.</p><h2>Administrative Team</h2><p>Our experienced leadership team is dedicated to student success and institutional excellence.</p>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'quality-assurance' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Quality Assurance</h1><p>NCTU is committed to maintaining the highest standards of educational quality through continuous improvement and assessment.</p><h3>Quality Standards</h3><ul><li>Regular program reviews</li><li>Student feedback systems</li><li>Faculty development programs</li><li>Industry advisory boards</li></ul>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'accreditation' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Accreditation</h1><p>NCTU programs are accredited by relevant national and international bodies, ensuring our degrees are recognized globally.</p><h3>Accrediting Bodies</h3><ul><li>Egyptian Ministry of Higher Education</li><li>National Authority for Quality Assurance and Accreditation of Education (NAQAAE)</li></ul>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'campus-life' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Campus Life</h1><p>Experience a vibrant campus community with numerous opportunities for personal growth and development.</p><h3>Student Activities</h3><ul><li>Student clubs and organizations</li><li>Sports and recreation</li><li>Cultural events</li><li>Community service</li></ul>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'facilities' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Campus Facilities</h1><p>NCTU offers state-of-the-art facilities to support student learning and development.</p><h3>Our Facilities</h3><ul><li>Modern laboratories</li><li>Computer centers</li><li>Library and learning resources</li><li>Sports facilities</li><li>Student center</li><li>Cafeteria and dining</li></ul>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'student-services' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Student Services</h1><p>We provide comprehensive support services to ensure student success.</p><h3>Available Services</h3><ul><li>Academic advising</li><li>Career counseling</li><li>Health services</li><li>Counseling and wellness</li><li>Disability support</li></ul>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'library' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Library Services</h1><p>Our library provides access to extensive print and digital resources.</p><h3>Resources</h3><ul><li>Books and journals</li><li>Online databases</li><li>Study spaces</li><li>Research assistance</li><li>Computer workstations</li></ul>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'career-services' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Career Services</h1><p>We help students prepare for successful careers through various programs and services.</p><h3>Services Offered</h3><ul><li>Career counseling</li><li>Resume and interview preparation</li><li>Job fairs and recruitment events</li><li>Internship placement</li><li>Alumni networking</li></ul>',
                    ],
                    'display_order' => 1,
                ],
            ],
        ];

        foreach ($pagesContent as $slug => $blocks) {
            $page = Page::where('slug', $slug)->where('language', 'en')->first();
            
            if (!$page) {
                $this->command->warn("Page not found: {$slug}");
                continue;
            }

            // Delete existing content blocks
            ContentBlock::where('page_id', $page->id)->delete();

            // Create new content blocks
            foreach ($blocks as $blockData) {
                ContentBlock::create([
                    'page_id' => $page->id,
                    'type' => $blockData['type'],
                    'content' => $blockData['content'],
                    'display_order' => $blockData['display_order'],
                    'created_by' => $admin->id,
                ]);
            }

            $this->command->info("Content added to: {$slug}");
        }

        $this->command->info('All pages populated with content successfully.');
    }
}
