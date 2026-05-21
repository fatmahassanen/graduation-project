<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'home',
                'title' => 'New Cairo University of Technology',
                'meta_description' => 'New Cairo University of Technology - Leading technological education in Egypt',
                'meta_keywords' => 'NCTU, technology, university, Cairo, Egypt, education',
                'hero_title' => 'New Cairo University of Technology',
                'hero_subtitle' => 'The university has established the basic infrastructure of human resources necessary for the technical plans for social development in particular.',
                'hero_image' => 'img/unvircity1.jpg',
                'content' => '<p>Welcome to New Cairo University of Technology</p>',
                'is_active' => true,
            ],
            [
                'slug' => 'about',
                'title' => 'About NCT',
                'meta_description' => 'Learn about New Cairo University of Technology',
                'meta_keywords' => 'about, NCTU, history, mission, vision',
                'hero_title' => 'About Us',
                'hero_subtitle' => 'Discover our mission and vision',
                'hero_image' => 'img/univercty2.jpg',
                'content' => '<p>We bring you the latest updates regarding your future and the opportunities provided by the New Technological University.</p>',
                'is_active' => true,
            ],
            [
                'slug' => 'contact',
                'title' => 'Contact Us',
                'meta_description' => 'Get in touch with New Cairo University of Technology',
                'meta_keywords' => 'contact, NCTU, address, phone, email',
                'hero_title' => 'Contacts',
                'hero_subtitle' => 'Contact us for any inquiries',
                'hero_image' => 'img/univercty2.jpg',
                'content' => '<p>This website helps you easily access the Technology College at Cairo University.</p>',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
