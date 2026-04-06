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
            $this->command->warn('Admin user not found. Please run UserSeeder first.');
            return;
        }

        $galleryPage = Page::where('slug', 'gallery')->where('language', 'en')->first();
        
        if (!$galleryPage) {
            $this->command->error('Gallery page not found. Please run PageSeeder first.');
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

        // Gallery images data
        $galleryImages = [
            [
                'src' => 'img/univercty2.jpg',
                'alt' => 'NCTU Campus',
                'title' => 'NCTU Campus',
                'description' => 'Main campus building',
            ],
            [
                'src' => 'img/unvircity1.jpg',
                'alt' => 'University Entrance',
                'title' => 'University Entrance',
                'description' => 'Welcome to NCTU',
            ],
            [
                'src' => 'img/Picture1.jpg',
                'alt' => 'Campus Facilities',
                'title' => 'Campus Facilities',
                'description' => 'Modern learning environment',
            ],
            [
                'src' => 'img/Picture2.jpg',
                'alt' => 'Student Activities',
                'title' => 'Student Activities',
                'description' => 'Vibrant campus life',
            ],
            [
                'src' => 'img/Picture4.jpg',
                'alt' => 'Academic Excellence',
                'title' => 'Academic Excellence',
                'description' => 'Quality education',
            ],
            [
                'src' => 'img/Picture5.jpg',
                'alt' => 'Campus Events',
                'title' => 'Campus Events',
                'description' => 'Community engagement',
            ],
            [
                'src' => 'img/Picture6.jpg',
                'alt' => 'Technology Labs',
                'title' => 'Technology Labs',
                'description' => 'State-of-the-art facilities',
            ],
            [
                'src' => 'img/Picture7.jpg',
                'alt' => 'Student Life',
                'title' => 'Student Life',
                'description' => 'Campus activities',
            ],
            [
                'src' => 'img/Picture10.jpg',
                'alt' => 'University Events',
                'title' => 'University Events',
                'description' => 'Special occasions',
            ],
            [
                'src' => 'img/Events/gradution.jpg',
                'alt' => 'Graduation Ceremony',
                'title' => 'Graduation Ceremony',
                'description' => 'Celebrating achievements',
            ],
            [
                'src' => 'img/Events/Conferences.jpg',
                'alt' => 'Academic Conferences',
                'title' => 'Academic Conferences',
                'description' => 'Knowledge sharing',
            ],
            [
                'src' => 'img/Events/Exh.jpg',
                'alt' => 'Student Exhibitions',
                'title' => 'Student Exhibitions',
                'description' => 'Showcasing innovation',
            ],
            [
                'src' => 'img/Events/training.jpg',
                'alt' => 'Training Programs',
                'title' => 'Training Programs',
                'description' => 'Skill development',
            ],
            [
                'src' => 'img/Events/competition .jpg',
                'alt' => 'Student Competitions',
                'title' => 'Student Competitions',
                'description' => 'Excellence in action',
            ],
            [
                'src' => 'img/Departments/Mechatronic.jpg',
                'alt' => 'Mechatronics Lab',
                'title' => 'Mechatronics Lab',
                'description' => 'Engineering excellence',
            ],
            [
                'src' => 'img/Departments/information technology.jpg',
                'alt' => 'IT Department',
                'title' => 'IT Department',
                'description' => 'Technology education',
            ],
            [
                'src' => 'img/Departments/Renewable energy.jpg',
                'alt' => 'Renewable Energy',
                'title' => 'Renewable Energy',
                'description' => 'Sustainable future',
            ],
            [
                'src' => 'img/Departments/Prosthetics.jpg',
                'alt' => 'Prosthetics Lab',
                'title' => 'Prosthetics Lab',
                'description' => 'Healthcare technology',
            ],
        ];

        // Create 18 individual image content blocks
        foreach ($galleryImages as $index => $imageData) {
            $this->createGalleryBlock($galleryPage, $index + 2, $imageData);
        }

        $this->command->info('Gallery content created successfully with 18 image blocks!');
    }

    /**
     * Create a gallery image content block
     */
    private function createGalleryBlock(Page $page, int $order, array $imageData): void
    {
        $admin = User::where('role', 'super_admin')->first();

        ContentBlock::create([
            'page_id' => $page->id,
            'type' => 'image',
            'content' => [
                'src' => $imageData['src'],
                'alt' => $imageData['alt'],
                'title' => $imageData['title'],
                'description' => $imageData['description'],
            ],
            'display_order' => $order,
            'created_by' => $admin->id,
        ]);
    }
}
