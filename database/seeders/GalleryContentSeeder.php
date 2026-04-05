<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class GalleryContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        
        if (!$admin) {
            $this->command->warn('Admin user not found.');
            return;
        }

        $galleryPage = Page::where('slug', 'gallery')->where('language', 'en')->first();
        
        if (!$galleryPage) {
            $this->command->warn('Gallery page not found.');
            return;
        }

        // Delete existing content blocks
        ContentBlock::where('page_id', $galleryPage->id)->delete();

        // Create hero section
        ContentBlock::create([
            'page_id' => $galleryPage->id,
            'type' => 'hero',
            'content' => [
                'title' => 'Photo Gallery',
                'description' => 'Explore photos from NCTU campus life, events, and facilities.',
                'image' => '/img/univercty2.jpg',
            ],
            'display_order' => 1,
            'created_by' => $admin->id,
        ]);

        // Create gallery section with campus images
        ContentBlock::create([
            'page_id' => $galleryPage->id,
            'type' => 'gallery',
            'content' => [
                'images' => [
                    [
                        'url' => '/img/univercty2.jpg',
                        'title' => 'NCTU Campus',
                        'description' => 'Main campus building',
                    ],
                    [
                        'url' => '/img/unvircity1.jpg',
                        'title' => 'University Entrance',
                        'description' => 'Welcome to NCTU',
                    ],
                    [
                        'url' => '/img/Picture1.jpg',
                        'title' => 'Campus Facilities',
                        'description' => 'Modern learning environment',
                    ],
                    [
                        'url' => '/img/Picture2.jpg',
                        'title' => 'Student Activities',
                        'description' => 'Vibrant campus life',
                    ],
                    [
                        'url' => '/img/Picture4.jpg',
                        'title' => 'Academic Excellence',
                        'description' => 'Quality education',
                    ],
                    [
                        'url' => '/img/Picture5.jpg',
                        'title' => 'Campus Events',
                        'description' => 'Community engagement',
                    ],
                    [
                        'url' => '/img/Picture6.jpg',
                        'title' => 'Technology Labs',
                        'description' => 'State-of-the-art facilities',
                    ],
                    [
                        'url' => '/img/Picture7.jpg',
                        'title' => 'Student Life',
                        'description' => 'Campus activities',
                    ],
                    [
                        'url' => '/img/Picture10.jpg',
                        'title' => 'University Events',
                        'description' => 'Special occasions',
                    ],
                    [
                        'url' => '/img/Events/gradution.jpg',
                        'title' => 'Graduation Ceremony',
                        'description' => 'Celebrating achievements',
                    ],
                    [
                        'url' => '/img/Events/Conferences.jpg',
                        'title' => 'Academic Conferences',
                        'description' => 'Knowledge sharing',
                    ],
                    [
                        'url' => '/img/Events/Exh.jpg',
                        'title' => 'Student Exhibitions',
                        'description' => 'Showcasing innovation',
                    ],
                    [
                        'url' => '/img/Events/training.jpg',
                        'title' => 'Training Programs',
                        'description' => 'Skill development',
                    ],
                    [
                        'url' => '/img/Events/competition .jpg',
                        'title' => 'Student Competitions',
                        'description' => 'Excellence in action',
                    ],
                    [
                        'url' => '/img/Departments/Mechatronic.jpg',
                        'title' => 'Mechatronics Lab',
                        'description' => 'Engineering excellence',
                    ],
                    [
                        'url' => '/img/Departments/information technology.jpg',
                        'title' => 'IT Department',
                        'description' => 'Technology education',
                    ],
                    [
                        'url' => '/img/Departments/Renewable energy.jpg',
                        'title' => 'Renewable Energy',
                        'description' => 'Sustainable future',
                    ],
                    [
                        'url' => '/img/Departments/Prosthetics.jpg',
                        'title' => 'Prosthetics Lab',
                        'description' => 'Healthcare technology',
                    ],
                ],
            ],
            'display_order' => 2,
            'created_by' => $admin->id,
        ]);

        $this->command->info('Gallery content created successfully!');
    }
}
