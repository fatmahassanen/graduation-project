<?php

namespace Database\Seeders;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing news for idempotency
        News::truncate();

        $newsItems = [
            [
                'title' => 'NCTU Announces New Scholarship Program for 2025',
                'slug' => 'nctu-scholarship-program-2025',
                'excerpt' => 'New Cairo Technological University is proud to announce a comprehensive scholarship program for outstanding students in technological fields.',
                'content' => '<p>New Cairo Technological University is proud to announce a comprehensive scholarship program for outstanding students in technological fields. The program aims to support talented students pursuing careers in mechatronics, information technology, and renewable energy.</p>',
                'published_at' => Carbon::now()->subDays(2),
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'NCTU Partners with Leading Tech Companies',
                'slug' => 'nctu-tech-partnerships',
                'excerpt' => 'The university has signed partnership agreements with major technology companies to provide internship opportunities and hands-on training for students.',
                'content' => '<p>The university has signed partnership agreements with major technology companies to provide internship opportunities and hands-on training for students in various technological disciplines.</p>',
                'published_at' => Carbon::now()->subDays(5),
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Research Excellence: NCTU Faculty Wins National Award',
                'slug' => 'nctu-research-award',
                'excerpt' => 'Dr. Ahmed Hassan from the Renewable Energy Department has been awarded the National Research Excellence Award for his groundbreaking work in solar energy systems.',
                'content' => '<p>Dr. Ahmed Hassan from the Renewable Energy Department has been awarded the National Research Excellence Award for his groundbreaking work in solar energy systems and sustainable technology solutions.</p>',
                'published_at' => Carbon::now()->subDays(7),
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($newsItems as $newsData) {
            News::create($newsData);
            $this->command->info("Created news: {$newsData['title']}");
        }

        $this->command->info('News seeded successfully!');
    }
}
