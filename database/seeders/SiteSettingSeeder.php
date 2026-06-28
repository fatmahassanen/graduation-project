<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'New Cairo University of Technology', 'type' => 'text'],
            ['key' => 'site_tagline', 'value' => 'Leading Technological Education in Egypt', 'type' => 'text'],
            ['key' => 'contact_email', 'value' => 'info@nctu.edu.eg', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '0225390250', 'type' => 'text'],
            ['key' => 'contact_mobile', 'value' => '+20 111 133 5725', 'type' => 'text'],
            ['key' => 'contact_address', 'value' => 'El Lotus, First New Cairo, New Cairo', 'type' => 'text'],
            ['key' => 'facebook_url', 'value' => 'https://www.facebook.com/nctu.edu.eg/?locale=ar_AR', 'type' => 'text'],
            ['key' => 'instagram_url', 'value' => 'https://www.instagram.com/explore/locations/113014853445529/new-cairo-technological-university/', 'type' => 'text'],
            ['key' => 'linkedin_url', 'value' => 'https://www.linkedin.com/school/nct-uni/', 'type' => 'text'],
            ['key' => 'telegram_url', 'value' => 'https://t.me/+hu88qUXmcXNlNmQ0', 'type' => 'text'],
            ['key' => 'website_url', 'value' => 'nctu.edu.eg', 'type' => 'text'],
            ['key' => 'logo', 'value' => 'img/sub-logo.png', 'type' => 'image'],
            ['key' => 'footer_text', 'value' => '© 2025 New Cairo Technological University. All Rights Reserved.', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }
}
