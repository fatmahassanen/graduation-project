<?php

namespace Database\Seeders;

use App\Models\Graduate;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class GraduatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set hero section settings
        SiteSetting::set('graduates_hero_image', asset('img/kk.png'));
        SiteSetting::set('graduates_hero_title', 'Outstanding Students at New Cairo Technological University');

        // Graduate 1
        Graduate::create([
            'title' => 'Training of New Cairo Technological University Students at Petrojet',
            'description' => 'As part of its commitment to enhancing practical experience and aligning academic study with market needs, students from the Information and Communication Technology and New and Renewable Energy Technology programs at New Cairo Technological University completed field training at Petrojet from July 27 to August 7, 2025.

The training was held under the patronage of Prof. Dr. Tarek Abdel Malak, President of the University, and Prof. Dr. Walid El-Khatam, Dean of the Faculty of Industry and Energy Technology, and coordinated by Mr. Abdelrahman Omar, University Training Coordinator.

The program included hands-on sessions on network fundamentals, the company\'s technological infrastructure, and practical training on the SAP system used globally for resource and project management',
            'is_active' => true,
            'order' => 1,
        ]);

        // Graduate 2
        Graduate::create([
            'title' => 'NCTU Wins Three Awards at the 3rd "Entlaqah" Competition',
            'description' => 'Under the patronage of Prof. Dr. Tarek Abdel Malak, President of New Cairo Technological University, and Prof. Dr. Walid El-Khatam, Dean of the Faculty of Industry and Energy Technology, NCTU students achieved remarkable success by winning three awards in the third edition of the "Entlaqah" competition, organized by the Higher Technological Institute in Beni Suef at the Egyptian Space Agency.

The university participated with seven innovative projects from the Mechatronics, Renewable Energy, and Autotronics programs, supervised by Dr. Shereef El Hosary and Dr. Bothaina Mahmoud Fouad, Head of the Entrepreneurship Club.',
            'is_active' => true,
            'order' => 2,
        ]);

        // Graduate 3
        Graduate::create([
            'title' => 'NCTU Honors Students for Participation in ROV Submarine Competition',
            'description' => 'Under the patronage of Prof. Dr. Tarek Abdel Malak, President of New Cairo Technological University, and the university leadership, NCTU held a ceremony to honor its students for their outstanding participation in the ROV Underwater Robotics Project.

The competition, organized by the Arab Academy for Science, Technology & Maritime Transport under the title MATE ROV Egypt, aimed to promote innovation in underwater exploration technologies.

This recognition reflects the university\'s commitment to supporting creativity, research, and student excellence.',
            'is_active' => true,
            'order' => 3,
        ]);

        // Graduate 4
        Graduate::create([
            'title' => 'Green Hydrogen Research Collaboration',
            'description' => 'A meeting was held under Professor Dr. Tarek Abdelmalak\'s patronage to launch student and postgraduate research projects, focusing on the production and industrial application of green hydrogen.',
            'is_active' => true,
            'order' => 4,
        ]);

        // Graduate 5
        Graduate::create([
            'title' => 'NCTU Students Excel in Training Program with the Egyptian Drilling Company',
            'description' => 'Under the patronage of Prof. Dr. Tarek Abdel Malak, President of New Cairo Technological University, and in cooperation with the Ministry of Petroleum, Mineral Resources, and the Ministry of Labor, students and graduates of the Oil Production, Processing, and Transport Technology Program participated in a specialized training program organized by the Egyptian Drilling Company (EDC).

The program aimed to enhance technical and practical skills, preparing participants for real-world challenges in the energy sector.',
            'is_active' => true,
            'order' => 5,
        ]);

        // Graduate 6
        Graduate::create([
            'title' => 'NCTU Students Honored by AVIC INNO for Excellence in Africa Technology Challenge',
            'description' => 'Students of New Cairo Technological University (NCTU) were honored by AVIC Innovation Holding Limited (AVIC INNO) after achieving second place in the Mobile Applications category at the Africa Technology Challenge (ATC) — Season 10.

The competition brought together 142 university teams and 568 participants from across Africa, showcasing innovation and excellence among young tech talents.',
            'is_active' => true,
            'order' => 6,
        ]);

        // Graduate 7
        Graduate::create([
            'title' => 'NCTU Shines in the National Wushu Championship',
            'description' => 'New Cairo Technological University proudly participated in the National Wushu Championship, organized by the Ministry of Higher Education, where top athletes from Egyptian universities competed with great spirit and skill.

Ziad Alaa Mohamed won third place and the bronze medal,
Radwa Sayed Abdelkarim achieved second place and the silver medal.

NCTU congratulates its champions for their outstanding achievements and reaffirms its commitment to supporting talented students in all fields.',
            'is_active' => true,
            'order' => 7,
        ]);

        // Graduate 8
        Graduate::create([
            'title' => 'NCT Students Shine in Kung Fu Competitions',
            'description' => 'Students of New Cairo Technological University participated in the national Kung Fu championships among Egyptian universities, showcasing outstanding performance and remarkable sportsmanship.

This participation reflects the university\'s commitment to supporting its students physically and mentally, fostering a spirit of discipline, perseverance, and national pride — in line with Egypt\'s vision of empowering youth and encouraging excellence in all fields.',
            'is_active' => true,
            'order' => 8,
        ]);

        // Graduate 9
        Graduate::create([
            'title' => 'Active Student Participation in Sports and Cultural Events',
            'description' => 'NCTU students actively took part in a variety of sports competitions, including five-a-side football, padel tennis, beach volleyball, and marathon running, alongside cultural and entertainment activities that showcased their creativity and national pride.

This participation reflects the university\'s commitment to empowering students, enhancing their skills, and providing a well-rounded educational experience in line with Egypt\'s vision to build an innovative and aware generation.

NCTU extends its appreciation to its talented students for their dedication and wishes them continued success and excellence.',
            'is_active' => true,
            'order' => 9,
        ]);
    }
}
