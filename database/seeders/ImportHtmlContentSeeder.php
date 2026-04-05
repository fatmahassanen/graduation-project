<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DOMDocument;
use DOMXPath;

class ImportHtmlContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        
        if (!$admin) {
            $this->command->warn('Admin user not found.');
            return;
        }

        $htmlFiles = glob(base_path('old_files/*.html'));
        $imported = 0;

        foreach ($htmlFiles as $filePath) {
            $filename = basename($filePath, '.html');
            $slug = Str::slug($filename);
            
            // Skip navbar and footer files
            if (in_array($filename, ['navbar', 'footer'])) {
                continue;
            }

            // Find or create page
            $page = Page::where('slug', $slug)->first();
            
            if (!$page) {
                // Extract title from HTML
                $html = file_get_contents($filePath);
                $title = $this->extractTitle($html);
                
                $page = Page::create([
                    'title' => $title,
                    'slug' => $slug,
                    'category' => $this->determineCategory($filename),
                    'status' => 'published',
                    'language' => 'en',
                    'meta_title' => $title,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                    'published_at' => now(),
                ]);
            }

            // Delete existing content blocks
            ContentBlock::where('page_id', $page->id)->delete();

            // Extract body content (everything between navbar and footer)
            $bodyContent = $this->extractBodyContent($filePath);

            // Create single HTML content block
            ContentBlock::create([
                'page_id' => $page->id,
                'type' => 'html',
                'content' => [
                    'html' => $bodyContent,
                ],
                'display_order' => 1,
                'created_by' => $admin->id,
            ]);

            $imported++;
            $this->command->info("Imported: {$filename} -> {$slug}");
        }

        $this->command->info("Successfully imported {$imported} pages with full HTML content.");
    }

    private function extractTitle(string $html): string
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);
        
        // Try to get title from <title> tag
        $titleNodes = $xpath->query('//title');
        if ($titleNodes->length > 0) {
            return trim($titleNodes->item(0)->textContent);
        }
        
        // Try to get from page header h1
        $h1Nodes = $xpath->query('//h1');
        if ($h1Nodes->length > 0) {
            return trim($h1Nodes->item(0)->textContent);
        }
        
        return 'Untitled Page';
    }

    private function extractBodyContent(string $filePath): string
    {
        $html = file_get_contents($filePath);
        
        // Remove everything before the navbar end comment
        $html = preg_replace('/.*<!-+\s*Navbar End\s*-+>/s', '', $html);
        
        // Remove everything after the footer start comment
        $html = preg_replace('/<!-+\s*Footer Start\s*-+>.*/s', '', $html);
        
        // Remove script tags for navbar/footer loading
        $html = preg_replace('/<script>.*?fetch\("(navbar|footer)\.html"\).*?<\/script>/s', '', $html);
        $html = preg_replace('/<div id="(navbar|footer)-placeholder"><\/div>/s', '', $html);
        
        // Remove chatbase script
        $html = preg_replace('/<script>.*?chatbase.*?<\/script>/s', '', $html);
        
        // Clean up extra whitespace
        $html = preg_replace('/\n\s*\n/', "\n", $html);
        
        return trim($html);
    }

    private function determineCategory(string $filename): string
    {
        $filename = strtolower($filename);
        
        $categoryMap = [
            'admission' => 'admissions',
            'apply' => 'admissions',
            'fees' => 'admissions',
            'accepted' => 'admissions',
            'dean' => 'faculties',
            'faculty' => 'faculties',
            'department' => 'faculties',
            'automotive' => 'faculties',
            'energy' => 'faculties',
            'mechatronics' => 'faculties',
            'petroleum' => 'faculties',
            'prosthetics' => 'faculties',
            'information' => 'faculties',
            'event' => 'events',
            'competition' => 'events',
            'conference' => 'events',
            'exhibition' => 'events',
            'training' => 'events',
            'about' => 'about',
            'mission' => 'about',
            'vision' => 'about',
            'president' => 'about',
            'quality' => 'quality',
            'evaluation' => 'quality',
            'media' => 'media',
            'news' => 'media',
            'gallery' => 'media',
            'campus' => 'campus',
            'staff' => 'staff',
            'student' => 'student_services',
            'contact' => 'about',
            'postgraduate' => 'about',
        ];
        
        foreach ($categoryMap as $keyword => $category) {
            if (str_contains($filename, $keyword)) {
                return $category;
            }
        }
        
        return 'about';
    }
}
