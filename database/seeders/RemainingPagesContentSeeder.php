<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\ContentBlock;
use App\Models\User;
use Illuminate\Database\Seeder;

class RemainingPagesContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        
        if (!$admin) {
            $this->command->warn('Admin user not found. Skipping seeder.');
            return;
        }

        // Events page - Note about dynamic content
        $this->seedEventsPage($admin);
        
        // Past Events page - Note about dynamic content
        $this->seedPastEventsPage($admin);
        
        // News page - Note about dynamic content
        $this->seedNewsPage($admin);
        
        // Campus Map page
        $this->seedCampusMapPage($admin);
        
        // Faculty Members page
        $this->seedFacultyMembersPage($admin);
        
        // Administrative Staff page
        $this->seedAdministrativeStaffPage($admin);
        
        // Research Centers page
        $this->seedResearchCentersPage($admin);
        
        $this->command->info('Remaining pages populated successfully!');
    }

    private function seedEventsPage($admin)
    {
        $page = Page::where('slug', 'events')->first();
        if (!$page) return;

        ContentBlock::create([
            'page_id' => $page->id,
            'type' => 'text',
            'content' => [
                'body' => '<div class="alert alert-info">
                    <h5><i class="fa fa-info-circle"></i> Dynamic Content</h5>
                    <p>This page displays events dynamically from the database. Events are managed through the admin panel.</p>
                </div>'
            ],
            'display_order' => 1,
            'created_by' => $admin->id,
        ]);
    }

    private function seedPastEventsPage($admin)
    {
        $page = Page::where('slug', 'past-events')->first();
        if (!$page) return;

        ContentBlock::create([
            'page_id' => $page->id,
            'type' => 'text',
            'content' => [
                'body' => '<div class="alert alert-info">
                    <h5><i class="fa fa-info-circle"></i> Dynamic Content</h5>
                    <p>This page displays past events dynamically from the database.</p>
                </div>'
            ],
            'display_order' => 1,
            'created_by' => $admin->id,
        ]);
    }

    private function seedNewsPage($admin)
    {
        $page = Page::where('slug', 'news')->first();
        if (!$page) return;

        ContentBlock::create([
            'page_id' => $page->id,
            'type' => 'text',
            'content' => [
                'body' => '<div class="alert alert-info">
                    <h5><i class="fa fa-info-circle"></i> Dynamic Content</h5>
                    <p>This page displays news articles dynamically from the database. News is managed through the admin panel.</p>
                </div>'
            ],
            'display_order' => 1,
            'created_by' => $admin->id,
        ]);
    }

    private function seedCampusMapPage($admin)
    {
        $page = Page::where('slug', 'campus-map')->first();
        if (!$page) return;

        ContentBlock::create([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Campus Map',
                'description' => 'Explore our beautiful campus and find your way around',
                'image' => 'img/campus.jpg',
            ],
            'display_order' => 1,
            'created_by' => $admin->id,
        ]);

        ContentBlock::create([
            'page_id' => $page->id,
            'type' => 'text',
            'content' => [
                'body' => '<div class="row">
                    <div class="col-lg-8 mx-auto">
                        <h3>Interactive Campus Map</h3>
                        <p>Our campus spans across multiple buildings and facilities designed to provide students with the best learning environment.</p>
                        <div class="alert alert-warning mt-4">
                            <i class="fa fa-map-marked-alt"></i> Interactive map will be embedded here. Contact IT department to integrate campus map service.
                        </div>
                    </div>
                </div>'
            ],
            'display_order' => 2,
            'created_by' => $admin->id,
        ]);
    }

    private function seedFacultyMembersPage($admin)
    {
        $page = Page::where('slug', 'faculty-members')->first();
        if (!$page) return;

        ContentBlock::create([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Our Faculty Members',
                'description' => 'Meet our distinguished professors and instructors',
                'image' => 'img/team.jpg',
            ],
            'display_order' => 1,
            'created_by' => $admin->id,
        ]);

        ContentBlock::create([
            'page_id' => $page->id,
            'type' => 'text',
            'content' => [
                'body' => '<div class="text-center mb-5">
                    <h3>Distinguished Faculty</h3>
                    <p class="lead">Our faculty members are experts in their fields with extensive academic and professional experience.</p>
                </div>
                <div class="alert alert-info">
                    <i class="fa fa-users"></i> Faculty directory will be displayed here. This section requires integration with the staff management system.
                </div>'
            ],
            'display_order' => 2,
            'created_by' => $admin->id,
        ]);
    }

    private function seedAdministrativeStaffPage($admin)
    {
        $page = Page::where('slug', 'administrative-staff')->first();
        if (!$page) return;

        ContentBlock::create([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Administrative Staff',
                'description' => 'Our dedicated team supporting university operations',
                'image' => 'img/team.jpg',
            ],
            'display_order' => 1,
            'created_by' => $admin->id,
        ]);

        ContentBlock::create([
            'page_id' => $page->id,
            'type' => 'card_grid',
            'content' => [
                'cards' => [
                    [
                        'title' => 'Administration Office',
                        'description' => 'General administrative support and inquiries',
                        'icon' => 'fa-building',
                        'link' => '/contact'
                    ],
                    [
                        'title' => 'Student Affairs',
                        'description' => 'Student services and support',
                        'icon' => 'fa-user-graduate',
                        'link' => '/student-services'
                    ],
                    [
                        'title' => 'Finance Department',
                        'description' => 'Tuition and financial matters',
                        'icon' => 'fa-dollar-sign',
                        'link' => '/tuition-fees'
                    ],
                    [
                        'title' => 'IT Support',
                        'description' => 'Technical assistance and support',
                        'icon' => 'fa-laptop',
                        'link' => '/contact'
                    ],
                    [
                        'title' => 'Library Services',
                        'description' => 'Library staff and resources',
                        'icon' => 'fa-book',
                        'link' => '/library'
                    ],
                    [
                        'title' => 'HR Department',
                        'description' => 'Human resources and employment',
                        'icon' => 'fa-users',
                        'link' => '/contact'
                    ],
                ],
                'columns' => 3
            ],
            'display_order' => 2,
            'created_by' => $admin->id,
        ]);
    }

    private function seedResearchCentersPage($admin)
    {
        $page = Page::where('slug', 'research-centers')->first();
        if (!$page) return;

        ContentBlock::create([
            'page_id' => $page->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Research Centers',
                'description' => 'Leading innovation and academic excellence',
                'image' => 'img/research.jpg',
            ],
            'display_order' => 1,
            'created_by' => $admin->id,
        ]);

        ContentBlock::create([
            'page_id' => $page->id,
            'type' => 'text',
            'content' => [
                'body' => '<div class="text-center mb-5">
                    <h3>Centers of Excellence</h3>
                    <p class="lead">Our research centers drive innovation and contribute to advancing knowledge in various fields.</p>
                </div>'
            ],
            'display_order' => 2,
            'created_by' => $admin->id,
        ]);

        ContentBlock::create([
            'page_id' => $page->id,
            'type' => 'card_grid',
            'content' => [
                'cards' => [
                    [
                        'title' => 'AI & Machine Learning Center',
                        'description' => 'Research in artificial intelligence, deep learning, and data science',
                        'icon' => 'fa-brain',
                    ],
                    [
                        'title' => 'Cybersecurity Research Lab',
                        'description' => 'Network security, cryptography, and information protection',
                        'icon' => 'fa-shield-alt',
                    ],
                    [
                        'title' => 'Renewable Energy Center',
                        'description' => 'Sustainable energy solutions and environmental research',
                        'icon' => 'fa-solar-panel',
                    ],
                    [
                        'title' => 'Biomedical Engineering Lab',
                        'description' => 'Medical devices, healthcare technology, and biotechnology',
                        'icon' => 'fa-heartbeat',
                    ],
                    [
                        'title' => 'Business Innovation Hub',
                        'description' => 'Entrepreneurship, management research, and business analytics',
                        'icon' => 'fa-lightbulb',
                    ],
                    [
                        'title' => 'Digital Transformation Center',
                        'description' => 'Industry 4.0, IoT, and smart systems research',
                        'icon' => 'fa-microchip',
                    ],
                ],
                'columns' => 3
            ],
            'display_order' => 3,
            'created_by' => $admin->id,
        ]);
    }
}
