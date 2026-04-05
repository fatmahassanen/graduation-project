<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        $editor = User::where('role', 'content_editor')->first();

        if (!$admin || !$editor) {
            $this->command->warn('Users not found. Please run UserSeeder first.');
            return;
        }

        // Sample hero images
        Media::factory()->create([
            'filename' => 'hero-campus.jpg',
            'original_name' => 'campus-hero.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 2048000,
            'path' => 'media/hero-campus.jpg',
            'uploaded_by' => $admin->id,
            'alt_text' => 'NCTU Campus Overview',
        ]);

        Media::factory()->create([
            'filename' => 'hero-students.jpg',
            'original_name' => 'students-learning.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1856000,
            'path' => 'media/hero-students.jpg',
            'uploaded_by' => $admin->id,
            'alt_text' => 'Students in classroom',
        ]);

        // Sample faculty images
        Media::factory()->create([
            'filename' => 'faculty-engineering.jpg',
            'original_name' => 'engineering-building.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1920000,
            'path' => 'media/faculty-engineering.jpg',
            'uploaded_by' => $editor->id,
            'alt_text' => 'Engineering Faculty Building',
        ]);

        Media::factory()->create([
            'filename' => 'faculty-it.jpg',
            'original_name' => 'it-lab.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1750000,
            'path' => 'media/faculty-it.jpg',
            'uploaded_by' => $editor->id,
            'alt_text' => 'IT Faculty Computer Lab',
        ]);

        // Sample event images
        Media::factory()->create([
            'filename' => 'event-conference.jpg',
            'original_name' => 'tech-conference.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1680000,
            'path' => 'media/event-conference.jpg',
            'uploaded_by' => $editor->id,
            'alt_text' => 'Technology Conference',
        ]);

        Media::factory()->create([
            'filename' => 'event-workshop.jpg',
            'original_name' => 'student-workshop.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1540000,
            'path' => 'media/event-workshop.jpg',
            'uploaded_by' => $editor->id,
            'alt_text' => 'Student Workshop',
        ]);

        // Sample news images
        Media::factory()->create([
            'filename' => 'news-research.jpg',
            'original_name' => 'research-lab.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1820000,
            'path' => 'media/news-research.jpg',
            'uploaded_by' => $admin->id,
            'alt_text' => 'Research Laboratory',
        ]);

        Media::factory()->create([
            'filename' => 'news-achievement.jpg',
            'original_name' => 'award-ceremony.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1650000,
            'path' => 'media/news-achievement.jpg',
            'uploaded_by' => $admin->id,
            'alt_text' => 'Award Ceremony',
        ]);

        // Sample gallery images
        Media::factory()->create([
            'filename' => 'gallery-campus-1.jpg',
            'original_name' => 'campus-view-1.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1450000,
            'path' => 'media/gallery-campus-1.jpg',
            'uploaded_by' => $editor->id,
            'alt_text' => 'Campus View 1',
        ]);

        Media::factory()->create([
            'filename' => 'gallery-campus-2.jpg',
            'original_name' => 'campus-view-2.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1520000,
            'path' => 'media/gallery-campus-2.jpg',
            'uploaded_by' => $editor->id,
            'alt_text' => 'Campus View 2',
        ]);

        // Sample PDF documents
        Media::factory()->create([
            'filename' => 'admission-guide.pdf',
            'original_name' => 'Admission Guide 2024.pdf',
            'mime_type' => 'application/pdf',
            'size' => 3500000,
            'path' => 'media/admission-guide.pdf',
            'uploaded_by' => $admin->id,
            'alt_text' => 'Admission Guide 2024',
        ]);

        Media::factory()->create([
            'filename' => 'course-catalog.pdf',
            'original_name' => 'Course Catalog.pdf',
            'mime_type' => 'application/pdf',
            'size' => 4200000,
            'path' => 'media/course-catalog.pdf',
            'uploaded_by' => $admin->id,
            'alt_text' => 'Course Catalog',
        ]);
    }
}
