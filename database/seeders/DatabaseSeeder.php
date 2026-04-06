<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MediaSeeder::class,
            PageSeeder::class,
            HomePageContentSeeder::class,
            AllPagesContentSeeder::class,
            CompleteNavigationPagesSeeder::class,
            GalleryContentSeeder::class,
            StaffPagesContentSeeder::class,
            RemainingPagesContentSeeder::class,
            EventSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
