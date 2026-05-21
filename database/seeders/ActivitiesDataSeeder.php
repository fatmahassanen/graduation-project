<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitiesDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            ['title' => 'ICT Reboot Ideathon', 'description' => 'Solar Loop team achieved second place and received an internship at Orange Egypt.', 'image' => 'activities1.jpg', 'category' => 'Competition'],
            ['title' => 'National Skills 2025', 'description' => 'Philip Emad qualified to represent Egypt in WorldSkills 2026 in Shanghai, China.', 'image' => 'activities2.jpg', 'category' => 'Award'],
            ['title' => 'Smart Glasses Innovation', 'description' => 'Radwa Waref won 1st place for her smart glasses design for the visually impaired.', 'image' => 'activities3.jpg', 'category' => 'Innovation'],
            ['title' => 'Africa Tech Challenge', 'description' => 'NCTU students won 2nd place in Mobile Applications among 12 African countries.', 'image' => 'activities4.jpg', 'category' => 'International'],
            ['title' => 'Biogas Project', 'description' => 'Student team won 2nd place in Intelaqa 3 for converting organic waste into clean energy.', 'image' => 'activities5.jpg', 'category' => 'Sustainability'],
            ['title' => 'Best Eco-Friendly University', 'description' => 'NCTU won 1st place in 2025 as the best green university in Egypt.', 'image' => 'activities6.jpg', 'category' => 'Achievement'],
            ['title' => 'Alamein Championship', 'description' => 'Participation in football, padel, and volleyball in the New Alamein City sports event.', 'image' => 'activities7.jpg', 'category' => 'Sports'],
            ['title' => 'GEN Z - Fit Socket', 'description' => 'Female team received 1M EGP funding for their AI-controlled prosthetic socket.', 'image' => 'activities8.jpg', 'category' => 'Innovation'],
            ['title' => 'Anti-Drug Marathon', 'description' => 'Participation in the Administrative Capital marathon with over 1000 students.', 'image' => 'activities9.jpg', 'category' => 'Social'],
            ['title' => 'Startup Olympics 2024', 'description' => 'Innovation projects in mechatronics and renewable energy presented in Helwan.', 'image' => 'activities10.jpg', 'category' => 'Entrepreneurship'],
            ['title' => 'Universities Youth Week', 'description' => '600 students participated in the first tech youth week in Alexandria.', 'image' => 'activities11.jpg', 'category' => 'Community'],
            ['title' => 'Five-a-Side Football', 'description' => 'NCTU football team represented the university in the Katameya championship.', 'image' => 'activities12.jpg', 'category' => 'Sports'],
            ['title' => 'National Kung Fu', 'description' => 'Ziad Alaa (Bronze) and Radwa Sayed (Silver) in the national individual sports.', 'image' => 'activities13.jpg', 'category' => 'Sports'],
            ['title' => 'Bodybuilding Champ', 'description' => 'Mohamed Yasser won 2nd place in Physique category at national level.', 'image' => 'activities14.jpg', 'category' => 'Sports'],
            ['title' => 'Hult Prize & Genius Forum', 'description' => 'Students qualified for global finals in India for scientific innovations.', 'image' => 'activities15.jpg', 'category' => 'Achievement'],
            ['title' => 'Boxing Championship 1', 'description' => 'Youssef Salah (2nd) and Rana Allam (3rd) in the universities boxing league.', 'image' => 'activities16.jpg', 'category' => 'Sports'],
            ['title' => 'Tennis & Padel', 'description' => 'University secured 2nd place in national individual games for Tennis.', 'image' => 'activities17.jpg', 'category' => 'Sports'],
            ['title' => 'Boxing Championship 2', 'description' => 'One of our female students achieved 1st place in the 5th Sector Boxing.', 'image' => 'activities18.jpg', 'category' => 'Sports'],
        ];

        foreach ($activities as $activity) {
            Activity::create([
                'title' => $activity['title'],
                'description' => $activity['description'],
                'image' => 'img/'.$activity['image'],
                'category' => $activity['category'],
                'is_active' => true,
            ]);
        }
    }
}
