<?php

namespace Database\Seeders;

use App\Models\PresidentContent;
use Illuminate\Database\Seeder;

class PresidentContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PresidentContent::create([
            'full_name' => 'Professor Dr. Tarek Abdelmalak',
            'title' => 'Professor',
            'position' => 'President of New Cairo Technological University',
            'image' => null, // Will use default image from public/img/present.png
            'welcome_text' => "On behalf of all faculty members and their assistants at New Cairo Technological University (NCT), I warmly welcome you as new members of our university family.\nWe believe that true success is not limited to academics but also includes building character, developing skills, and broadening horizons.",
            'education' => "PhD (Mechanical Power Engineering), Shanghai University, China – 2002\nMaster's Degree (Mechanical Power Engineering), Cairo University, Egypt – 1996\nBachelor's Degree (Mechanical Power Engineering), Menoufia University, Egypt – 1991",
            'postdoctoral' => "2003-2005: Scientific mission at KAIST, South Korea\n2017: Short research visit at Kumamoto University, Japan",
            'administrative' => "Consultant at Niaf Paper Products Company (2005-2006)\nConsultant at Ramen Paper Products Company (2008-2012)\nProject Manager for Training Centers – Funded by Korean Government (2015-2017)\nMember of the Advisory Committee at the Science and Technology Development Fund (STDF)\nHonored as one of the Top Ten Directors of Technological Education Centers in Africa by the African Union (2015)",
        ]);
    }
}
