<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
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

        // Get sample news images if available
        $researchImage = Media::where('filename', 'news-research.jpg')->first();
        $achievementImage = Media::where('filename', 'news-achievement.jpg')->first();

        $newsArticles = [
            // Announcements
            [
                'title' => 'NCTU Launches New AI Research Center',
                'slug' => 'nctu-launches-new-ai-research-center',
                'excerpt' => 'University announces state-of-the-art artificial intelligence research facility equipped with cutting-edge technology and staffed by world-renowned researchers.',
                'body' => '<p>New Cairo Technological University is proud to announce the opening of our new AI Research Center, a state-of-the-art facility dedicated to advancing artificial intelligence research and education.</p><p>The center features high-performance computing clusters, specialized AI hardware, and collaborative research spaces. It will serve as a hub for interdisciplinary research in machine learning, computer vision, natural language processing, and robotics.</p><p>"This center represents our commitment to being at the forefront of AI innovation," said the university president. "We aim to contribute significantly to AI research while preparing our students for the future of technology."</p>',
                'featured_image_id' => $researchImage?->id,
                'featured_image' => 'img/Picture1.jpg',
                'author_id' => $admin->id,
                'category' => 'announcement',
                'is_featured' => true,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'New Scholarship Program for Engineering Students',
                'slug' => 'new-scholarship-program-engineering-students',
                'excerpt' => 'NCTU introduces comprehensive scholarship program covering tuition and living expenses for outstanding engineering students.',
                'body' => '<p>NCTU is pleased to announce a new scholarship program designed to support talented engineering students. The program will provide full tuition coverage and living stipends to qualified applicants.</p><p>Eligible students must demonstrate academic excellence, leadership potential, and commitment to engineering innovation. Applications are now open for the upcoming academic year.</p><p>The scholarship program is made possible through partnerships with leading technology companies and generous alumni donations.</p>',
                'featured_image_id' => null,
                'featured_image' => 'img/Picture2.jpg',
                'author_id' => $admin->id,
                'category' => 'announcement',
                'is_featured' => false,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Campus Expansion Project Begins',
                'slug' => 'campus-expansion-project-begins',
                'excerpt' => 'Construction begins on new academic buildings and student facilities as part of the university\'s five-year expansion plan.',
                'body' => '<p>NCTU has broken ground on a major campus expansion project that will add 50,000 square meters of new facilities over the next three years.</p><p>The expansion includes new lecture halls, research laboratories, a modern library, and enhanced student recreation facilities. The project is designed with sustainability in mind, incorporating green building practices and renewable energy systems.</p><p>The expansion will accommodate growing student enrollment and support the university\'s research initiatives.</p>',
                'featured_image_id' => null,
                'featured_image' => 'img/univercty2.jpg',
                'author_id' => $editor->id,
                'category' => 'announcement',
                'is_featured' => false,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now()->subDays(10),
            ],

            // Achievements
            [
                'title' => 'NCTU Students Win International Robotics Competition',
                'slug' => 'students-win-international-robotics-competition',
                'excerpt' => 'NCTU robotics team takes first place in prestigious international competition, defeating teams from 30 countries.',
                'body' => '<p>A team of NCTU engineering students has won first place at the International Robotics Challenge, competing against teams from 30 countries worldwide.</p><p>The team\'s robot demonstrated exceptional performance in autonomous navigation, object manipulation, and problem-solving tasks. The victory showcases the high quality of engineering education at NCTU.</p><p>"We are incredibly proud of our students," said the faculty advisor. "Their dedication, creativity, and technical skills were outstanding throughout the competition."</p><p>The winning team will represent Egypt at the World Robotics Championship next year.</p>',
                'featured_image_id' => $achievementImage?->id,
                'featured_image' => 'img/Events/competition .jpg',
                'author_id' => $admin->id,
                'category' => 'achievement',
                'is_featured' => true,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Faculty Member Receives Prestigious Research Award',
                'slug' => 'faculty-member-receives-research-award',
                'excerpt' => 'Dr. Ahmed Hassan honored with national research excellence award for groundbreaking work in renewable energy.',
                'body' => '<p>Dr. Ahmed Hassan, professor in the Faculty of Engineering, has been awarded the National Research Excellence Award for his pioneering research in renewable energy systems.</p><p>Dr. Hassan\'s research focuses on improving solar panel efficiency and developing innovative energy storage solutions. His work has resulted in multiple patents and publications in top-tier journals.</p><p>The award recognizes researchers who have made significant contributions to scientific advancement and technological innovation in Egypt.</p>',
                'featured_image_id' => null,
                'featured_image' => 'img/Departments/Renewable energy.jpg',
                'author_id' => $editor->id,
                'category' => 'achievement',
                'is_featured' => false,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'NCTU Ranks Among Top Universities in Egypt',
                'slug' => 'nctu-ranks-top-universities-egypt',
                'excerpt' => 'Latest university rankings place NCTU in top 5 for engineering and technology programs in Egypt.',
                'body' => '<p>NCTU has been ranked among the top 5 universities in Egypt for engineering and technology programs according to the latest national university rankings.</p><p>The rankings evaluate universities based on academic reputation, research output, graduate employability, and industry partnerships. NCTU scored particularly high in research quality and industry collaboration.</p><p>"This recognition validates our commitment to excellence in education and research," said the dean of engineering. "We will continue to raise the bar and provide world-class education to our students."</p>',
                'featured_image_id' => null,
                'featured_image' => 'img/Picture4.jpg',
                'author_id' => $admin->id,
                'category' => 'achievement',
                'is_featured' => false,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now()->subDays(15),
            ],

            // Research
            [
                'title' => 'Breakthrough in Quantum Computing Research',
                'slug' => 'breakthrough-quantum-computing-research',
                'excerpt' => 'NCTU researchers achieve significant advancement in quantum computing algorithms with potential applications in cryptography.',
                'body' => '<p>Researchers at NCTU have made a significant breakthrough in quantum computing, developing new algorithms that could revolutionize data encryption and processing.</p><p>The research team, led by Dr. Sarah Mohamed, has published their findings in the prestigious journal Nature Quantum Information. Their work addresses key challenges in quantum error correction and algorithm optimization.</p><p>"This research opens new possibilities for practical quantum computing applications," explained Dr. Mohamed. "We are excited about the potential impact on cybersecurity and computational science."</p><p>The project was funded by the National Science Foundation and involved collaboration with international research institutions.</p>',
                'featured_image_id' => $researchImage?->id,
                'featured_image' => 'img/Picture5.jpg',
                'author_id' => $admin->id,
                'category' => 'research',
                'is_featured' => true,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'New Medical Device Developed by NCTU Engineers',
                'slug' => 'new-medical-device-developed-nctu-engineers',
                'excerpt' => 'Engineering team creates innovative low-cost diagnostic device for rural healthcare applications.',
                'body' => '<p>A team of biomedical engineering students and faculty at NCTU has developed a portable, low-cost diagnostic device designed for use in rural healthcare settings.</p><p>The device can perform multiple diagnostic tests using minimal power and resources, making it ideal for areas with limited medical infrastructure. Initial trials have shown promising results.</p><p>The team is now working with healthcare providers to conduct field testing and refine the device based on real-world feedback. They hope to bring the device to market within two years.</p>',
                'featured_image_id' => null,
                'featured_image' => 'img/Departments/Prosthetics.jpg',
                'author_id' => $editor->id,
                'category' => 'research',
                'is_featured' => false,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Climate Change Research Initiative Launched',
                'slug' => 'climate-change-research-initiative-launched',
                'excerpt' => 'NCTU establishes new research initiative focused on climate change mitigation and adaptation strategies.',
                'body' => '<p>NCTU has launched a comprehensive research initiative to address climate change challenges through innovative technological solutions.</p><p>The initiative brings together researchers from multiple disciplines including engineering, environmental science, and data analytics. Focus areas include renewable energy, carbon capture, sustainable agriculture, and climate modeling.</p><p>The university has committed significant resources to the initiative and is seeking partnerships with government agencies and international organizations.</p>',
                'featured_image_id' => null,
                'featured_image' => 'img/Picture6.jpg',
                'author_id' => $admin->id,
                'category' => 'research',
                'is_featured' => false,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now()->subDays(20),
            ],

            // Partnerships
            [
                'title' => 'NCTU Partners with Leading Tech Companies',
                'slug' => 'nctu-partners-leading-tech-companies',
                'excerpt' => 'University signs strategic partnerships with major technology companies to enhance student opportunities and research collaboration.',
                'body' => '<p>NCTU has announced strategic partnerships with several leading technology companies including Microsoft, IBM, and Siemens.</p><p>The partnerships will provide students with access to industry-standard tools, internship opportunities, and real-world project experience. Companies will also collaborate with faculty on research projects and curriculum development.</p><p>"These partnerships bridge the gap between academia and industry," said the vice president for industry relations. "Our students will graduate with skills and experience that employers value."</p><p>The partnerships include funding for research projects, guest lectures from industry experts, and joint innovation labs on campus.</p>',
                'featured_image_id' => null,
                'featured_image' => 'img/Picture7.jpg',
                'author_id' => $admin->id,
                'category' => 'partnership',
                'is_featured' => true,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'International University Collaboration Agreement',
                'slug' => 'international-university-collaboration-agreement',
                'excerpt' => 'NCTU signs memorandum of understanding with European universities for student exchange and joint research programs.',
                'body' => '<p>NCTU has signed a memorandum of understanding with three leading European universities to establish student exchange programs and joint research initiatives.</p><p>The agreement will enable NCTU students to study abroad for a semester and participate in international research projects. Faculty members will also benefit from exchange opportunities and collaborative research funding.</p><p>The partnership aims to enhance the international dimension of education at NCTU and expose students to diverse academic and cultural perspectives.</p>',
                'featured_image_id' => null,
                'featured_image' => 'img/Events/Conferences.jpg',
                'author_id' => $editor->id,
                'category' => 'partnership',
                'is_featured' => false,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now()->subDays(14),
            ],
            [
                'title' => 'Industry Advisory Board Established',
                'slug' => 'industry-advisory-board-established',
                'excerpt' => 'NCTU creates advisory board comprising industry leaders to guide curriculum development and strategic planning.',
                'body' => '<p>NCTU has established an Industry Advisory Board consisting of executives and technical leaders from major companies across various sectors.</p><p>The board will provide guidance on curriculum development, ensuring that programs remain relevant to industry needs. Members will also advise on research priorities and help identify emerging technology trends.</p><p>The first board meeting focused on skills gaps in the technology sector and how universities can better prepare graduates for the workforce.</p>',
                'featured_image_id' => null,
                'featured_image' => 'img/Picture10.jpg',
                'author_id' => $admin->id,
                'category' => 'partnership',
                'is_featured' => false,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now()->subDays(18),
            ],

            // Draft article
            [
                'title' => 'Upcoming Alumni Reunion Event',
                'slug' => 'upcoming-alumni-reunion-event',
                'excerpt' => 'Save the date for the annual alumni reunion featuring networking, campus tours, and special presentations.',
                'body' => '<p>Details coming soon about our annual alumni reunion event. Stay tuned for more information.</p>',
                'featured_image_id' => null,
                'featured_image' => 'img/Events/gradution.jpg',
                'author_id' => $editor->id,
                'category' => 'announcement',
                'is_featured' => false,
                'language' => 'en',
                'status' => 'draft',
                'published_at' => null,
            ],
        ];

        foreach ($newsArticles as $articleData) {
            News::firstOrCreate(
                ['slug' => $articleData['slug']],
                $articleData
            );
        }
    }
}
