<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class QualityUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing Quality pages for idempotency
        Page::where('slug', 'like', 'quality-%')->delete();

        $qualityPages = $this->getQualityPagesMapping();

        foreach ($qualityPages as $pageData) {
            // Try multiple possible locations for the HTML files
            $possiblePaths = [
                base_path('missed files/'.$pageData['file']),
                base_path('old-design/'.$pageData['file']),
                base_path($pageData['file']),
            ];

            $filePath = null;
            foreach ($possiblePaths as $path) {
                if (File::exists($path)) {
                    $filePath = $path;
                    break;
                }
            }

            if (! $filePath) {
                $this->command->warn("File not found: {$pageData['file']}");
                continue;
            }

            try {
                $content = $this->extractContent($filePath);
                $content = $this->convertAssetPaths($content);

                Page::create([
                    'slug' => $pageData['slug'],
                    'title' => $pageData['title'],
                    'content' => $content,
                    'is_active' => true,
                ]);

                $this->command->info("Created: {$pageData['slug']}");
            } catch (\Exception $e) {
                $this->command->error("Failed to create {$pageData['slug']}: ".$e->getMessage());
            }
        }

        $this->command->info('Quality Unit pages seeded successfully!');
    }

    /**
     * Get mapping of Quality HTML files to page data
     */
    private function getQualityPagesMapping(): array
    {
        return [
            ['file' => 'Quality_IntroToQuality.html', 'slug' => 'quality-intro-to-quality', 'title' => 'Introduction to the Quality Assurance Unit'],
            ['file' => 'Quality_VisionMission.html', 'slug' => 'quality-vision-mission', 'title' => 'Vision and Mission'],
            ['file' => 'Quality_PeriodicalPub.html', 'slug' => 'quality-periodical-pub', 'title' => 'The unit\'s periodical publication'],
            ['file' => 'Quality_Tasks.html', 'slug' => 'quality-tasks', 'title' => 'Unit Tasks and Objectives'],
            ['file' => 'Quality_InternalRegulations.html', 'slug' => 'quality-internal-regulations', 'title' => 'Internal Regulations of the Unit'],
            ['file' => 'Quality_OrgStructure.html', 'slug' => 'quality-org-structure', 'title' => 'Organizational Structure and Responsibilities'],
            ['file' => 'Quality_ExecutiveCouncil.html', 'slug' => 'quality-executive-council', 'title' => 'Executive Council'],
            ['file' => 'Quality_AdministrativeCouncil.html', 'slug' => 'quality-administrative-council', 'title' => 'Formation of the Administrative Council'],
            ['file' => 'Quality_academicstandards.html', 'slug' => 'quality-academic-standards', 'title' => 'Academic Standards'],
            ['file' => 'Quality_unitActivities.html', 'slug' => 'quality-unit-activities', 'title' => 'Unit Activities'],
            ['file' => 'Quality_CoursesWorkshops.html', 'slug' => 'quality-courses-workshops', 'title' => 'Courses and Workshops'],
        ];
    }

    /**
     * Extract content from HTML file (between navbar and footer)
     */
    private function extractContent(string $filePath): string
    {
        $htmlContent = File::get($filePath);

        // Remove navbar placeholder and script
        $htmlContent = preg_replace('/<div id="navbar-placeholder"><\/div>.*?<script>.*?fetch\("navbar\.html"\).*?<\/script>/s', '', $htmlContent);

        // Remove footer placeholder and script
        $htmlContent = preg_replace('/<div id="footer-placeholder"><\/div>.*?<script>.*?fetch\("footer\.html"\).*?<\/script>/s', '', $htmlContent);

        // Extract content between <!-- Header End --> and <!-- Footer Start -->
        if (preg_match('/<!-- Header End -->(.*?)<!-- Footer Start -->/s', $htmlContent, $matches)) {
            $content = $matches[1];
        } else {
            // Fallback: extract everything between body tags
            if (preg_match('/<body[^>]*>(.*?)<\/body>/s', $htmlContent, $matches)) {
                $content = $matches[1];
            } else {
                $content = $htmlContent;
            }
        }

        // Extract inline styles from head and prepend to content
        $inlineStyles = '';
        if (preg_match('/<style>(.*?)<\/style>/s', $htmlContent, $styleMatches)) {
            $inlineStyles = '<style>'.$styleMatches[1].'</style>';
        }

        return $inlineStyles.trim($content);
    }

    /**
     * Convert static asset paths to Laravel asset() helper syntax
     */
    private function convertAssetPaths(string $html): string
    {
        // Convert img src attributes
        $html = preg_replace(
            '/src="(?!http|https|\/\/|\{\{)([^"]+)"/',
            'src="{{ asset(\'$1\') }}"',
            $html
        );

        // Convert href attributes (for CSS/links, but skip anchors and external URLs)
        $html = preg_replace(
            '/href="(?!http|https|\/\/|#|\{\{)([^"]+)"/',
            'href="{{ asset(\'$1\') }}"',
            $html
        );

        // Normalize relative paths
        $html = str_replace('../img/', 'img/', $html);
        $html = str_replace('../css/', 'css/', $html);
        $html = str_replace('../js/', 'js/', $html);
        $html = str_replace('../lib/', 'lib/', $html);

        return $html;
    }
}
