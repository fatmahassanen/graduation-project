<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Mechatronics',
                'slug' => 'mechatronics',
                'description' => 'Mechatronics Technology combines mechanical engineering, electronics, computer science, and control engineering.',
                'image' => 'img/Mecha.jpg',
                'icon' => null,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Auto-tronics',
                'slug' => 'auto-tronics',
                'description' => 'Automotive Technology focuses on the design, development, and maintenance of automotive systems.',
                'image' => 'img/Auto.jpg',
                'icon' => null,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Information Technology',
                'slug' => 'information-technology',
                'description' => 'Information Technology covers software development, networking, cybersecurity, and data management.',
                'image' => 'img/ICT.jpg',
                'icon' => null,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Petroleum',
                'slug' => 'petroleum',
                'description' => 'Petroleum Technology focuses on exploration, extraction, and processing of petroleum resources.',
                'image' => 'img/petrol.jpg',
                'icon' => null,
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Renewable Energy',
                'slug' => 'renewable-energy',
                'description' => 'Renewable Energy Technology covers solar, wind, and other sustainable energy sources.',
                'image' => 'img/Renew.jpg',
                'icon' => null,
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Prosthetics',
                'slug' => 'prosthetics',
                'description' => 'Prosthetics & Orthotics Technology focuses on designing and manufacturing artificial limbs and orthotic devices.',
                'image' => 'img/Prosthetics.jpg',
                'icon' => null,
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
