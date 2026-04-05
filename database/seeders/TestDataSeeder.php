<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Get the super admin user
        $admin = User::where('role', 'super_admin')->first();
        
        if (!$admin) {
            $admin = User::create([
                'name' => 'Super Admin',
                'email' => 'admin@nctu.edu.eg',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]);
        }

        // Create sample pages
        $homePage = DB::table('pages')->insertGetId([
            'title' => 'Home',
            'slug' => 'home',
            'category' => 'about',
            'status' => 'published',
            'language' => 'en',
            'meta_title' => 'NCTU - New Cairo Technological University',
            'meta_description' => 'Welcome to New Cairo Technological University',
            'created_by' => $admin->id,
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $aboutPage = DB::table('pages')->insertGetId([
            'title' => 'About Us',
            'slug' => 'about',
            'category' => 'about',
            'status' => 'published',
            'language' => 'en',
            'meta_title' => 'About NCTU',
            'meta_description' => 'Learn more about New Cairo Technological University',
            'created_by' => $admin->id,
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $admissionsPage = DB::table('pages')->insertGetId([
            'title' => 'Admissions',
            'slug' => 'admissions',
            'category' => 'admissions',
            'status' => 'published',
            'language' => 'en',
            'meta_title' => 'Admissions - NCTU',
            'meta_description' => 'Apply to New Cairo Technological University',
            'created_by' => $admin->id,
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create sample content blocks for home page
        DB::table('content_blocks')->insert([
            [
                'page_id' => $homePage,
                'type' => 'hero',
                'content' => json_encode([
                    'title' => 'Welcome to NCTU',
                    'description' => 'New Cairo Technological University - Shaping the Future',
                    'image' => '/images/hero-bg.jpg',
                    'ctaText' => 'Learn More',
                    'ctaLink' => '/about',
                ]),
                'display_order' => 1,
                'is_reusable' => false,
                'created_by' => $admin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => $homePage,
                'type' => 'card_grid',
                'content' => json_encode([
                    'columns' => 3,
                    'cards' => [
                        [
                            'title' => 'Academic Excellence',
                            'description' => 'World-class education with cutting-edge technology',
                            'icon' => 'fa-graduation-cap',
                        ],
                        [
                            'title' => 'Research Innovation',
                            'description' => 'Leading research in technology and engineering',
                            'icon' => 'fa-flask',
                        ],
                        [
                            'title' => 'Industry Partnerships',
                            'description' => 'Strong connections with leading companies',
                            'icon' => 'fa-handshake',
                        ],
                    ],
                ]),
                'display_order' => 2,
                'is_reusable' => false,
                'created_by' => $admin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create sample content block for about page
        DB::table('content_blocks')->insert([
            'page_id' => $aboutPage,
            'type' => 'text',
            'content' => json_encode([
                'body' => '<h2>About NCTU</h2><p>New Cairo Technological University is a leading institution dedicated to excellence in education, research, and innovation.</p>',
            ]),
            'display_order' => 1,
            'is_reusable' => false,
            'created_by' => $admin->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create sample events
        DB::table('events')->insert([
            [
                'title' => 'Tech Innovation Conference 2024',
                'description' => 'Annual conference showcasing the latest in technology and innovation',
                'start_date' => now()->addDays(30),
                'end_date' => now()->addDays(32),
                'location' => 'NCTU Main Campus',
                'category' => 'conference',
                'language' => 'en',
                'status' => 'published',
                'created_by' => $admin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Engineering Competition',
                'description' => 'Student engineering design competition',
                'start_date' => now()->addDays(45),
                'end_date' => now()->addDays(45),
                'location' => 'Engineering Building',
                'category' => 'competition',
                'language' => 'en',
                'status' => 'published',
                'created_by' => $admin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create sample news
        DB::table('news')->insert([
            [
                'title' => 'NCTU Launches New AI Research Center',
                'slug' => 'nctu-launches-new-ai-research-center',
                'excerpt' => 'University announces state-of-the-art artificial intelligence research facility',
                'body' => '<p>New Cairo Technological University is proud to announce the opening of our new AI Research Center, equipped with cutting-edge technology and staffed by world-renowned researchers.</p>',
                'author_id' => $admin->id,
                'category' => 'announcement',
                'is_featured' => true,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Students Win International Robotics Competition',
                'slug' => 'students-win-international-robotics-competition',
                'excerpt' => 'NCTU team takes first place in global robotics challenge',
                'body' => '<p>Our talented students have brought home the gold medal from the International Robotics Competition, showcasing their exceptional skills and innovation.</p>',
                'author_id' => $admin->id,
                'category' => 'achievement',
                'is_featured' => false,
                'language' => 'en',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
