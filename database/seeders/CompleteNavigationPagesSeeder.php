<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompleteNavigationPagesSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        
        if (!$admin) {
            $this->command->warn('Admin user not found.');
            return;
        }

        // Define all pages from navigation with their content
        $pages = [
            // About section
            'president' => [
                'title' => 'University President',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>University President</h1><p>Prof. Mahmoud El-Sheikh leads New Cairo Technological University with a vision for excellence in technological education and innovation.</p><h3>Biography</h3><p>With extensive experience in higher education and technology, the university president is committed to advancing NCTU as a leading institution in Egypt and the region.</p>'], 'display_order' => 1],
                ],
            ],
            'dean1' => [
                'title' => 'Dean of Industrial & Energy Technology',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Dean of Industrial & Energy Technology</h1><p>The Faculty of Industrial and Energy Technology is led by an experienced dean dedicated to preparing students for careers in industrial and energy sectors.</p><h3>Faculty Overview</h3><p>Our faculty offers cutting-edge programs in industrial engineering, energy systems, and related technologies.</p>'], 'display_order' => 1],
                ],
            ],
            'dean2' => [
                'title' => 'Dean of Applied Health Sciences Technology',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Dean of Applied Health Sciences Technology</h1><p>The Faculty of Applied Health Sciences Technology combines healthcare knowledge with technological innovation.</p><h3>Programs</h3><p>We offer specialized programs in medical technology, prosthetics, and health informatics.</p>'], 'display_order' => 1],
                ],
            ],
            'dean3' => [
                'title' => 'Students Affairs Vice Dean',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Students Affairs Vice Dean</h1><p>The Vice Dean for Student Affairs oversees all student services, activities, and support programs at NCTU.</p><h3>Student Support</h3><p>We are committed to ensuring every student has a positive and enriching university experience.</p>'], 'display_order' => 1],
                ],
            ],
            'campus' => [
                'title' => 'Campus Tour',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Campus Tour</h1><p>Explore our modern campus facilities designed to support learning, research, and student life.</p><h3>Campus Highlights</h3><ul><li>State-of-the-art laboratories</li><li>Modern classrooms with smart technology</li><li>Extensive library and learning resources</li><li>Sports and recreation facilities</li><li>Student center and cafeteria</li></ul>'], 'display_order' => 1],
                ],
            ],
            'internal-protocols' => [
                'title' => 'Internal Protocols',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Internal Protocols</h1><p>NCTU maintains comprehensive internal protocols to ensure smooth operations and high-quality education delivery.</p><h3>Key Protocols</h3><ul><li>Academic integrity policies</li><li>Student conduct guidelines</li><li>Faculty responsibilities</li><li>Administrative procedures</li></ul>'], 'display_order' => 1],
                ],
            ],
            'external-protocols' => [
                'title' => 'External Protocols',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>External Protocols</h1><p>NCTU collaborates with industry partners, international institutions, and government agencies through formal protocols.</p><h3>Partnership Areas</h3><ul><li>Industry collaboration</li><li>International exchange programs</li><li>Research partnerships</li><li>Community engagement</li></ul>'], 'display_order' => 1],
                ],
            ],
            'reasons' => [
                'title' => 'Top 10 Reasons',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Top 10 Reasons to Choose NCTU</h1><ol><li><strong>Industry-Focused Education:</strong> Programs designed with industry input</li><li><strong>Modern Facilities:</strong> State-of-the-art labs and equipment</li><li><strong>Experienced Faculty:</strong> Professors with industry and academic expertise</li><li><strong>Practical Training:</strong> Hands-on learning and internships</li><li><strong>Career Support:</strong> Dedicated career services and job placement</li><li><strong>Flexible Programs:</strong> 2+2 system allowing early career entry</li><li><strong>Scholarships Available:</strong> Financial aid for qualified students</li><li><strong>Strategic Location:</strong> Located in New Cairo with easy access</li><li><strong>Industry Partnerships:</strong> Strong connections with leading companies</li><li><strong>Accredited Programs:</strong> Nationally recognized degrees</li></ol>'], 'display_order' => 1],
                ],
            ],
            'competitions' => [
                'title' => 'Competitions',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Competitions</h1><p>NCTU students participate in various national and international competitions, showcasing their skills and innovation.</p><h3>Competition Areas</h3><ul><li>Engineering design competitions</li><li>Programming contests</li><li>Innovation challenges</li><li>Business plan competitions</li><li>Research presentations</li></ul>'], 'display_order' => 1],
                ],
            ],
            'graduates' => [
                'title' => 'Graduate Achievements',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Graduate Achievements</h1><p>Our graduates excel in their careers and make significant contributions to their fields.</p><h3>Success Stories</h3><p>NCTU alumni work at leading companies and organizations across Egypt and internationally, applying their technical skills and knowledge to solve real-world challenges.</p>'], 'display_order' => 1],
                ],
            ],

            // Units section
            'digital-transformation' => [
                'title' => 'Digital Transformation',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Digital Transformation Unit</h1><p>The Digital Transformation Unit leads NCTU\'s efforts to integrate technology into all aspects of university operations and education.</p><h3>Initiatives</h3><ul><li>Digital learning platforms</li><li>Smart campus systems</li><li>Online services</li><li>Data analytics</li></ul>'], 'display_order' => 1],
                ],
            ],
            'international-cooperation' => [
                'title' => 'International Cooperation',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>International Cooperation</h1><p>NCTU actively seeks partnerships with international universities and organizations to enhance educational quality and student opportunities.</p><h3>Programs</h3><ul><li>Student exchange programs</li><li>Joint research projects</li><li>Faculty exchange</li><li>International conferences</li></ul>'], 'display_order' => 1],
                ],
            ],
            'quality' => [
                'title' => 'Quality Assurance',
                'category' => 'quality',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Quality Assurance Unit</h1><p>The Quality Assurance Unit ensures NCTU maintains the highest standards in education, research, and services.</p><h3>Quality Standards</h3><ul><li>Regular program reviews</li><li>Student feedback systems</li><li>Faculty development</li><li>Continuous improvement processes</li></ul>'], 'display_order' => 1],
                ],
            ],
            'evaluation' => [
                'title' => 'Measurement and Evaluation',
                'category' => 'quality',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Measurement and Evaluation</h1><p>We use comprehensive measurement and evaluation systems to assess student learning, program effectiveness, and institutional performance.</p><h3>Assessment Methods</h3><ul><li>Student learning outcomes assessment</li><li>Program evaluation</li><li>Faculty performance review</li><li>Institutional effectiveness measures</li></ul>'], 'display_order' => 1],
                ],
            ],
            'women' => [
                'title' => 'Combating Violence Against Women',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Combating Violence Against Women Unit</h1><p>NCTU is committed to providing a safe and respectful environment for all students and staff.</p><h3>Services</h3><ul><li>Awareness programs</li><li>Support services</li><li>Reporting mechanisms</li><li>Prevention initiatives</li></ul>'], 'display_order' => 1],
                ],
            ],

            // Faculties
            'faculty-health' => [
                'title' => 'Faculty of Applied Health Sciences Technology',
                'category' => 'faculties',
                'content' => [
                    ['type' => 'hero', 'content' => ['title' => 'Faculty of Applied Health Sciences Technology', 'description' => 'Combining healthcare knowledge with technological innovation', 'image' => '/img/univercty2.jpg'], 'display_order' => 1],
                    ['type' => 'text', 'content' => ['body' => '<h2>Programs</h2><p>Our faculty offers specialized programs that prepare students for careers in healthcare technology.</p><h3>Departments</h3><ul><li>Medical Technology</li><li>Prosthetics and Orthotics</li><li>Health Informatics</li><li>Biomedical Engineering</li></ul>'], 'display_order' => 2],
                ],
            ],

            // Admissions
            'how-apply' => [
                'title' => 'How to Apply Online',
                'category' => 'admissions',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>How to Apply Online</h1><h3>Online Application Process</h3><ol><li>Visit the NCTU admissions portal</li><li>Create an account with your email</li><li>Fill out the application form</li><li>Upload required documents</li><li>Pay the application fee online</li><li>Submit your application</li><li>Track your application status</li></ol><h3>Required Documents</h3><ul><li>High school diploma or equivalent</li><li>Official transcripts</li><li>National ID or passport copy</li><li>Birth certificate</li><li>Recent photographs</li></ul>'], 'display_order' => 1],
                ],
            ],
            'faculties-requirements' => [
                'title' => 'Faculties Requirements',
                'category' => 'admissions',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Faculties Requirements</h1><h3>Faculty of Industrial and Energy Technology</h3><p>Minimum requirements: Technical diploma or secondary certificate with mathematics and physics.</p><h3>Faculty of Applied Health Sciences Technology</h3><p>Minimum requirements: Technical diploma or secondary certificate with biology and chemistry.</p><h3>General Requirements</h3><ul><li>Minimum grade requirements vary by program</li><li>English language proficiency</li><li>Medical fitness certificate</li></ul>'], 'display_order' => 1],
                ],
            ],
            'postgraduate-studies' => [
                'title' => 'Postgraduate Programs',
                'category' => 'admissions',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Postgraduate Programs</h1><p>NCTU offers professional master\'s and doctoral programs in technology fields.</p><h3>Available Programs</h3><ul><li>Professional Master\'s Degree in Technology</li><li>Professional Doctorate in Technology</li></ul><h3>Admission Requirements</h3><ul><li>Bachelor\'s degree in relevant field</li><li>Minimum GPA requirements</li><li>Work experience (for some programs)</li><li>Research proposal (for doctoral programs)</li></ul>'], 'display_order' => 1],
                ],
            ],
            'fees' => [
                'title' => 'Tuition Fees & Scholarships',
                'category' => 'admissions',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Tuition Fees & Scholarships</h1><h3>Tuition Fees</h3><p>Tuition fees vary by program and level. Contact the admissions office for current fee schedules.</p><h3>Payment Options</h3><ul><li>Full payment with discount</li><li>Semester installments</li><li>Monthly payment plans</li></ul><h3>Scholarships</h3><p>NCTU offers various scholarships based on:</p><ul><li>Academic merit</li><li>Financial need</li><li>Special talents</li><li>Community service</li></ul>'], 'display_order' => 1],
                ],
            ],

            // Campus
            'entrepreneur' => [
                'title' => 'Entrepreneur',
                'category' => 'campus',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Entrepreneurship at NCTU</h1><p>NCTU encourages entrepreneurship and innovation among students through various programs and support services.</p><h3>Entrepreneurship Programs</h3><ul><li>Business incubator</li><li>Startup mentorship</li><li>Funding opportunities</li><li>Networking events</li><li>Business plan competitions</li></ul>'], 'display_order' => 1],
                ],
            ],
            'activities' => [
                'title' => 'Student Activities',
                'category' => 'campus',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Student Activities</h1><p>NCTU offers a vibrant campus life with numerous student activities and organizations.</p><h3>Activities</h3><ul><li>Student clubs and societies</li><li>Sports teams and competitions</li><li>Cultural events and festivals</li><li>Community service projects</li><li>Leadership development programs</li></ul>'], 'display_order' => 1],
                ],
            ],

            // Staff
            'staff-lms' => [
                'title' => 'Staff LMS',
                'category' => 'staff',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Staff Learning Management System</h1><p>Access the staff portal for course management, grading, and communication with students.</p><h3>Features</h3><ul><li>Course content management</li><li>Assignment and grading tools</li><li>Student communication</li><li>Attendance tracking</li><li>Performance analytics</li></ul>'], 'display_order' => 1],
                ],
            ],
            'profile' => [
                'title' => 'Profile',
                'category' => 'staff',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Staff Profile</h1><p>Manage your staff profile, update information, and access university resources.</p>'], 'display_order' => 1],
                ],
            ],
            'members' => [
                'title' => 'Staff Members',
                'category' => 'staff',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Staff Members</h1><p>Browse our directory of faculty and staff members at NCTU.</p><h3>Departments</h3><ul><li>Academic faculty</li><li>Administrative staff</li><li>Technical support</li><li>Student services</li></ul>'], 'display_order' => 1],
                ],
            ],

            // Student Services
            'student-service' => [
                'title' => 'Students LMS',
                'category' => 'student_services',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Student Learning Management System</h1><p>Access your courses, assignments, grades, and communicate with instructors through the student portal.</p><h3>Features</h3><ul><li>Course materials and resources</li><li>Assignment submission</li><li>Grade viewing</li><li>Discussion forums</li><li>Calendar and announcements</li></ul>'], 'display_order' => 1],
                ],
            ],
            'student-booking' => [
                'title' => 'Student Affairs',
                'category' => 'student_services',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Student Affairs</h1><p>The Student Affairs office provides comprehensive support services for all students.</p><h3>Services</h3><ul><li>Registration and enrollment</li><li>Academic advising</li><li>Student activities coordination</li><li>Housing assistance</li><li>Student ID services</li></ul>'], 'display_order' => 1],
                ],
            ],
            'trainings' => [
                'title' => 'Training',
                'category' => 'student_services',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Training Programs</h1><p>NCTU offers various training programs to enhance student skills and employability.</p><h3>Training Areas</h3><ul><li>Technical skills workshops</li><li>Soft skills development</li><li>Industry certifications</li><li>Internship programs</li><li>Career preparation</li></ul>'], 'display_order' => 1],
                ],
            ],

            // Contact
            'contact' => [
                'title' => 'Contacts',
                'category' => 'about',
                'content' => [
                    ['type' => 'text', 'content' => ['body' => '<h1>Contact Us</h1><h3>Get in Touch</h3><p>We\'re here to answer your questions and provide information about NCTU.</p><h3>Contact Information</h3><p><strong>Address:</strong> New Cairo, Egypt</p><p><strong>Phone:</strong> +20 XXX XXX XXXX</p><p><strong>Email:</strong> info@nctu.edu.eg</p><h3>Office Hours</h3><p>Sunday - Thursday: 9:00 AM - 4:00 PM</p>'], 'display_order' => 1],
                ],
            ],
        ];

        foreach ($pages as $slug => $pageData) {
            // Create or update page
            $page = Page::firstOrCreate(
                ['slug' => $slug, 'language' => 'en'],
                [
                    'title' => $pageData['title'],
                    'category' => $pageData['category'],
                    'status' => 'published',
                    'meta_title' => $pageData['title'] . ' - NCTU',
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                    'published_at' => now(),
                ]
            );

            // Delete existing content blocks
            ContentBlock::where('page_id', $page->id)->delete();

            // Create content blocks
            foreach ($pageData['content'] as $blockData) {
                ContentBlock::create([
                    'page_id' => $page->id,
                    'type' => $blockData['type'],
                    'content' => $blockData['content'],
                    'display_order' => $blockData['display_order'],
                    'created_by' => $admin->id,
                ]);
            }

            $this->command->info("Created/Updated: {$slug}");
        }

        $this->command->info('All navigation pages created successfully!');
    }
}
