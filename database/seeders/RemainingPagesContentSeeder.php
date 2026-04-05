<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class RemainingPagesContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        
        if (!$admin) {
            $this->command->warn('Admin user not found.');
            return;
        }

        $pagesContent = [
            'events' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Upcoming Events</h1><p>Stay updated with the latest events at NCTU. Check back regularly for new events and activities.</p>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'past-events' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Past Events</h1><p>Browse our archive of past events and activities at NCTU.</p>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'news' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>News and Updates</h1><p>Stay informed with the latest news from NCTU.</p>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'gallery' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Photo Gallery</h1><p>Explore photos from NCTU campus life, events, and facilities.</p>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'campus-map' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Campus Map</h1><p>Navigate our campus with ease. Our campus is designed to provide easy access to all facilities.</p>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'faculty-members' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Faculty Members</h1><p>Our distinguished faculty members bring years of academic and industry experience to the classroom.</p>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'administrative-staff' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Administrative Staff</h1><p>Our dedicated administrative team ensures smooth operations and excellent student services.</p>',
                    ],
                    'display_order' => 1,
                ],
            ],
            'research-centers' => [
                [
                    'type' => 'text',
                    'content' => [
                        'body' => '<h1>Research Centers</h1><p>NCTU hosts several research centers focused on cutting-edge technology and innovation.</p>',
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

            // Skip if page already has content
            if ($page->contentBlocks()->count() > 0) {
                $this->command->info("Page already has content: {$slug}");
                continue;
            }

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

        $this->command->info('Remaining pages populated with content successfully.');
    }
}
