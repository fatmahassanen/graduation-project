<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class HomePageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        $home = Page::where('slug', 'home')->first();

        if (!$admin || !$home) {
            $this->command->warn('Admin user or home page not found.');
            return;
        }

        // Delete existing content blocks for home page
        ContentBlock::where('page_id', $home->id)->delete();

        // Create hero section
        ContentBlock::create([
            'page_id' => $home->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Welcome to New Cairo Technological University',
                'description' => 'A leading institution for higher education in Egypt, offering world-class programs in Engineering, IT, and Technology.',
                'image' => '/img/univercty2.jpg',
                'ctaText' => 'Learn More',
                'ctaLink' => '/about',
            ],
            'display_order' => 1,
            'created_by' => $admin->id,
        ]);

        // Create text section
        ContentBlock::create([
            'page_id' => $home->id,
            'type' => 'text',
            'content' => [
                'body' => '<h2>About NCTU</h2><p>New Cairo Technological University (NCTU) is committed to providing excellence in education and research. Our state-of-the-art facilities and experienced faculty ensure that students receive the best possible education.</p>',
            ],
            'display_order' => 2,
            'created_by' => $admin->id,
        ]);

        // Create card grid for faculties
        ContentBlock::create([
            'page_id' => $home->id,
            'type' => 'card_grid',
            'content' => [
                'cards' => [
                    [
                        'title' => 'Faculty of Engineering',
                        'description' => 'Explore our engineering programs',
                        'image' => '/img/index/mecha.jpeg',
                        'link' => '/faculty-engineering',
                    ],
                    [
                        'title' => 'Faculty of IT',
                        'description' => 'Discover IT programs and courses',
                        'image' => '/img/index/info.jpeg',
                        'link' => '/faculty-it',
                    ],
                    [
                        'title' => 'Faculty of Business',
                        'description' => 'Business administration programs',
                        'image' => '/img/index/auto.jpeg',
                        'link' => '/faculty-business',
                    ],
                ],
                'columns' => 3,
            ],
            'display_order' => 3,
            'created_by' => $admin->id,
        ]);

        $this->command->info('Home page content created successfully.');
    }
}
