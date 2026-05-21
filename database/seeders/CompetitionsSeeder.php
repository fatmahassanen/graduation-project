<?php

namespace Database\Seeders;

use App\Models\Competition;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class CompetitionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set the competition video URL
        SiteSetting::set('competitions_video_url', asset('img/videos/comptions.mp4'));

        // Competition 1
        Competition::create([
            'title' => 'NCTU Students Honored by AVIC INNO for Achieving Second Place in Mobile Applications',
            'description' => 'Under the patronage of Prof. Dr. Tarek Abdel Malak, NCTU students were honored by AVIC INNO for securing second place in mobile applications at the 10th Africa Technological Challenge.

The competition gathered 142 teams and 568 participants from across Africa under the slogan "Dream and Innovate Your Future." Participants underwent five weeks of intensive training by professional Chinese trainers.

Winning Team:
• Abdullah Ahmed Hassan Saad
• Abdel Rahman Yahia Ibrahim
• Demiana Samy Ounis

Abdullah Ahmed Hassan Saad individually secured second place, earning a study opportunity in China. Since 2014, ATC has empowered over 1,000 African youth technicians.',
            'date' => 'September 28, 2025',
            'image' => 'Events/CO.jpg',
            'is_active' => true,
            'order' => 1,
        ]);

        // Competition 2
        Competition::create([
            'title' => 'NCTU Hosts Ain Shams Racing Team',
            'description' => 'Under the patronage of Prof. Dr. Tarek Abdel Malak, New Cairo Technological University welcomed Ain Shams University Racing Team for technical collaboration.

The visit featured:
• Workshop tours of NCTU\'s automotive facilities
• Technical sessions between both racing teams
• Project presentations on electric vehicles
• Certificate ceremony honoring the visiting team

The event strengthened inter-university cooperation in automotive innovation and student development.',
            'date' => 'December 11, 2023',
            'image' => 'Events/co2.jpg',
            'is_active' => true,
            'order' => 2,
        ]);

        // Competition 3
        Competition::create([
            'title' => 'A Year of Excellence & Innovation - NCTU Student Activities 2024/2025 Highlights',
            'description' => 'Under the patronage of Prof. Dr. Tarek Abdel Malak, New Cairo Technological University students achieved outstanding success in the 2024/2025 academic year.

The achievements included:
• Award-winning innovations in Hult Prize and Gen Z competitions
• International recognition through global conference participation
• Sports excellence in design and athletic competitions
• Specialized competition victories in PetroCamp and ministry contests
• Student-led initiatives including Google Developer Group
• National representation at Technology Universities Week

These accomplishments demonstrate NCTU\'s commitment to developing well-rounded technological leaders and innovators.',
            'date' => '2024/2025',
            'image' => 'Events/co4.jpg',
            'is_active' => true,
            'order' => 3,
        ]);

        // Competition 4
        Competition::create([
            'title' => 'NCTU Wins First Place in Anti-Drug Awareness Campaign',
            'description' => 'Under the patronage of Prof. Dr. Mahmoud El-Sheikh, University President, and Prof. Dr. Tarek Abdel Malak Mikhail, Dean of the Faculty of Industrial Technology and Energy, New Cairo Technological University participated in a national anti-drug campaign.

The program included:
• Leadership training for student volunteers
• Technology projects promoting drug prevention
• Awareness initiatives from the Addiction Prevention Fund
• Sports competitions encouraging healthy lifestyles

NCTU won first place in football during the camp, demonstrating the university\'s active role in student development and social responsibility.',
            'date' => 'August 8, 2023',
            'image' => 'Events/co3.jpg',
            'is_active' => true,
            'order' => 4,
        ]);
    }
}
