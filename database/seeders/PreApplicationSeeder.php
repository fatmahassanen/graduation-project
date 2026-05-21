<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PreApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing pre-application pages for idempotency
        $slugs = ['how-to-apply', 'tuition-fees', 'faculties-requirements'];
        Page::whereIn('slug', $slugs)->delete();

        $preApplicationPages = $this->getPreApplicationPagesMapping();

        foreach ($preApplicationPages as $pageData) {
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

        $this->command->info('Pre-Application pages seeded successfully!');
    }

    /**
     * Get mapping of Pre-Application HTML files to page data
     */
    private function getPreApplicationPagesMapping(): array
    {
        return [
            [
                'file' => 'Admissions.html',
                'slug' => 'how-to-apply',
                'title' => 'How to Apply Online',
            ],
            [
                'file' => 'fees.html',
                'slug' => 'tuition-fees',
                'title' => 'Tuition Fees & Scholarships',
            ],
            [
                'file' => 'Faculties Requirements.html',
                'slug' => 'faculties-requirements',
                'title' => 'Faculties Requirements',
            ],
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

        // Fix internal cross-links to use dynamic routes
        $html = $this->fixInternalLinks($html);

        return $html;
    }

    /**
     * Fix internal cross-links to use dynamic Laravel routes
     */
    private function fixInternalLinks(string $html): string
    {
        // Replace hardcoded HTML file links with dynamic routes
        $linkMappings = [
            'Faculties Requirements.html' => "{{ route('page.show', ['slug' => 'faculties-requirements']) }}",
            'fees.html' => "{{ route('page.show', ['slug' => 'tuition-fees']) }}",
            'Admissions.html' => "{{ route('page.show', ['slug' => 'how-to-apply']) }}",
        ];

        foreach ($linkMappings as $oldLink => $newLink) {
            // Replace in href attributes
            $html = str_replace('href="'.$oldLink.'"', 'href="'.$newLink.'"', $html);
            $html = str_replace("href='".$oldLink."'", "href='".$newLink."'", $html);
        }

        return $html;
    }
}
