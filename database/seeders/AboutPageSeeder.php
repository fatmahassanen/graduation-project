<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the about page
        $aboutPage = Page::where('slug', 'about')->first();

        if (! $aboutPage) {
            $this->command->warn('About page not found. Skipping FAQ seeding.');

            return;
        }

        // Delete existing FAQ sections for idempotency
        PageSection::where('page_id', $aboutPage->id)
            ->where('section_key', 'faq')
            ->delete();

        // Define FAQ data extracted from old-design/about.html
        $faqs = $this->getFaqData();

        // Insert FAQ sections
        foreach ($faqs as $index => $faq) {
            PageSection::create([
                'page_id' => $aboutPage->id,
                'section_key' => 'faq',
                'section_title' => $faq['question'],
                'section_content' => $faq['answer'],
                'section_order' => $index + 1,
                'is_active' => true,
            ]);

            $this->command->info('Created FAQ #'.($index + 1).": {$faq['question']}");
        }

        $this->command->info('FAQ sections seeded successfully!');
    }

    /**
     * Get FAQ data extracted from old-design/about.html
     */
    private function getFaqData(): array
    {
        return [
            [
                'question' => 'What is New Cairo Technological University (NCTU)?',
                'answer' => 'It\'s a public technological university in Egypt that offers advanced applied education, focusing on linking studies directly to the job market.',
            ],
            [
                'question' => 'How is it different from regular universities?',
                'answer' => 'Education here is more practical and hands-on. It prepares students directly for the job market and accepts students after high school or diploma.',
            ],
            [
                'question' => 'What majors or programs are available?',
                'answer' => 'Programs vary by year, but usually include: Mechatronics, Information Technology, New and Renewable Energy, Prosthetics Technology, Control and Monitoring Systems, Equipment Operation and Maintenance Technology.',
            ],
            [
                'question' => 'How many years is the study program?',
                'answer' => 'It\'s a 4-year program divided into two stages: First 2 years: Higher Technological Diploma, Last 2 years: Technological Bachelor\'s Degree (with certain conditions).',
            ],
            [
                'question' => 'Is the Technological Bachelor\'s degree recognized?',
                'answer' => 'Yes, it is officially recognized by the Supreme Council of Universities and is equivalent to any bachelor\'s degree from other universities. You can also pursue postgraduate studies.',
            ],
            [
                'question' => 'Is there practical training?',
                'answer' => 'Yes, practical training is a key part of the program and takes place both inside the university and at companies/factories.',
            ],
            [
                'question' => 'Is it part of the national admission system (Thanaweya Amma)?',
                'answer' => 'Yes, the university is included in the national coordination system, and admission depends on the yearly minimum grade requirements.',
            ],
            [
                'question' => 'Does the university accept diploma holders?',
                'answer' => 'Yes, it accepts graduates of technical diplomas (3 or 5-year systems) and technical institutes, but applicants must pass entrance exams.',
            ],
            [
                'question' => 'Is there on-campus housing?',
                'answer' => 'Currently, there\'s no dormitory, but there are nearby housing options in areas like New Cairo or Katameya.',
            ],
            [
                'question' => 'Are there tuition fees?',
                'answer' => 'Yes, there are fees. They\'re slightly higher than traditional public universities, but still much cheaper than private universities.',
            ],
            [
                'question' => 'What are the job opportunities after graduation from NCTU?',
                'answer' => 'Graduates are qualified for technical and engineering-related jobs in both public and private sectors. The university focuses on practical skills, so students can work in industries like automation, IT, energy, manufacturing, or even start their own business.',
            ],
        ];
    }
}
