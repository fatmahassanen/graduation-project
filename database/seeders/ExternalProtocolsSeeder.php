<?php

namespace Database\Seeders;

use App\Models\ExternalProtocol;
use Illuminate\Database\Seeder;

class ExternalProtocolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $protocols = [
            // 2025
            [
                'title' => 'Yangzhou University',
                'description' => 'The agreement aims to localize the latest manufacturing technologies and establish large-scale silo chains in regions such as the New Delta.',
                'organization_name' => 'College of Electrical & Energy Engineering',
                'image' => null,
                'year' => 2025,
                'order' => 1,
            ],
            [
                'title' => 'Shanxi University of Finance and Economics',
                'description' => 'The agreement facilitates faculty exchange, student exchange programs and development of technological education.',
                'organization_name' => null,
                'image' => null,
                'year' => 2025,
                'order' => 2,
            ],
            [
                'title' => 'Jilin International Studies University',
                'description' => 'The cooperation aims to exchange expertise related to achieving international quality standards in higher education institutions.',
                'organization_name' => null,
                'image' => null,
                'year' => 2025,
                'order' => 3,
            ],
            [
                'title' => 'Taiyuan University of Technology – China',
                'description' => 'The memorandum includes faculty exchange, research cooperation and joint training programs.',
                'organization_name' => null,
                'image' => null,
                'year' => 2025,
                'order' => 4,
            ],

            // 2024
            [
                'title' => 'Beijing Youth Politics College',
                'description' => 'The agreement aims to exchange students and faculty members and organize short academic programs.',
                'organization_name' => null,
                'image' => null,
                'year' => 2024,
                'order' => 1,
            ],
            [
                'title' => 'Shanghai University of Electric Power',
                'description' => 'The memorandum establishes a joint academic degree program in automation and artificial intelligence.',
                'organization_name' => null,
                'image' => null,
                'year' => 2024,
                'order' => 2,
            ],
            [
                'title' => 'North China Electric Power University',
                'description' => 'The protocol promotes scientific cooperation through faculty exchange visits and joint workshops.',
                'organization_name' => null,
                'image' => null,
                'year' => 2024,
                'order' => 3,
            ],
            [
                'title' => 'Higher Technical Institute – Italy',
                'description' => 'A quadrilateral memorandum between the university, Italian institute, Danieli Company and Don Bosco Institute.',
                'organization_name' => null,
                'image' => null,
                'year' => 2024,
                'order' => 4,
            ],
            [
                'title' => 'Human Restart – Germany',
                'description' => 'The protocol supports international partnerships and provides employment opportunities for graduates.',
                'organization_name' => null,
                'image' => null,
                'year' => 2024,
                'order' => 5,
            ],

            // 2022
            [
                'title' => 'University of Strathclyde',
                'description' => 'The agreement aims to develop curricula and establish training programs in prosthetics and orthotics.',
                'organization_name' => null,
                'image' => null,
                'year' => 2022,
                'order' => 1,
            ],
            [
                'title' => 'Akdo4ren Renewable Energy Company',
                'description' => 'The protocol strengthens cooperation in renewable energy maintenance and training programs.',
                'organization_name' => null,
                'image' => null,
                'year' => 2022,
                'order' => 2,
            ],
        ];

        foreach ($protocols as $protocol) {
            ExternalProtocol::create($protocol);
        }
    }
}
