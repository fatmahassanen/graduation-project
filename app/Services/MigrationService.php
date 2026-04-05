<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrationService
{
    /**
     * Parse an HTML file and extract metadata.
     */
    public function parseHtmlFile(string $filePath): array
    {
        $html = file_get_contents($filePath);
        
        $dom = new DOMDocument();
        // Suppress warnings for malformed HTML
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        $xpath = new DOMXPath($dom);
        
        // Extract title
        $titleNodes = $xpath->query('//title');
        $title = $titleNodes->length > 0 ? trim($titleNodes->item(0)->textContent) : 'Untitled';
        
        // Extract meta description
        $metaDescNodes = $xpath->query('//meta[@name="description"]');
        $metaDescription = $metaDescNodes->length > 0 
            ? $metaDescNodes->item(0)->getAttribute('content') 
            : null;
        
        // Extract meta keywords
        $metaKeywordsNodes = $xpath->query('//meta[@name="keywords"]');
        $metaKeywords = $metaKeywordsNodes->length > 0 
            ? $metaKeywordsNodes->item(0)->getAttribute('content') 
            : null;
        
        // Extract page header title (h1 in page-header)
        $pageHeaderNodes = $xpath->query('//div[contains(@class, "page-header")]//h1');
        $pageTitle = $pageHeaderNodes->length > 0 
            ? trim($pageHeaderNodes->item(0)->textContent) 
            : $title;
        
        return [
            'title' => $pageTitle,
            'meta_title' => $title,
            'meta_description' => $metaDescription,
            'meta_keywords' => $metaKeywords,
        ];
    }
    
    /**
     * Identify content sections using DOM parsing.
     */
    public function identifyContentSections(string $filePath): array
    {
        $html = file_get_contents($filePath);
        
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        $xpath = new DOMXPath($dom);
        $sections = [];
        
        // Identify hero section (page-header)
        $heroNodes = $xpath->query('//div[contains(@class, "page-header")]');
        if ($heroNodes->length > 0) {
            $heroNode = $heroNodes->item(0);
            $h1Nodes = $xpath->query('.//h1', $heroNode);
            
            if ($h1Nodes->length > 0) {
                $sections[] = [
                    'type' => 'hero',
                    'content' => [
                        'title' => trim($h1Nodes->item(0)->textContent),
                        'description' => '',
                        'image' => '',
                    ],
                ];
            }
        }
        
        // Identify card grid sections (service-item or col-lg-3 patterns)
        $cardContainers = $xpath->query('//div[contains(@class, "row")]');
        foreach ($cardContainers as $container) {
            $cardNodes = $xpath->query('.//div[contains(@class, "service-item") or contains(@class, "admission-box")]', $container);
            
            if ($cardNodes->length >= 2) {
                $cards = [];
                foreach ($cardNodes as $cardNode) {
                    $titleNodes = $xpath->query('.//h5 | .//h3', $cardNode);
                    $pNodes = $xpath->query('.//p', $cardNode);
                    
                    if ($titleNodes->length > 0) {
                        $cards[] = [
                            'title' => trim($titleNodes->item(0)->textContent),
                            'description' => $pNodes->length > 0 ? trim($pNodes->item(0)->textContent) : '',
                        ];
                    }
                }
                
                if (count($cards) > 0) {
                    $sections[] = [
                        'type' => 'card_grid',
                        'content' => [
                            'columns' => min(count($cards), 4),
                            'cards' => $cards,
                        ],
                    ];
                }
            }
        }
        
        // Identify FAQ sections
        $faqNodes = $xpath->query('//div[contains(@class, "faq-section") or contains(@class, "faq")]');
        if ($faqNodes->length > 0) {
            $faqItems = [];
            $faqItemNodes = $xpath->query('.//div[contains(@class, "faq-item")]', $faqNodes->item(0));
            
            foreach ($faqItemNodes as $index => $faqItemNode) {
                $questionText = trim($faqItemNode->textContent);
                
                // Find corresponding answer
                $answerNodes = $xpath->query('following-sibling::div[contains(@class, "answer")][1]', $faqItemNode);
                $answerText = $answerNodes->length > 0 ? trim($answerNodes->item(0)->textContent) : '';
                
                if (!empty($questionText) && !empty($answerText)) {
                    $faqItems[] = [
                        'question' => $questionText,
                        'answer' => $answerText,
                    ];
                }
            }
            
            if (count($faqItems) > 0) {
                $sections[] = [
                    'type' => 'faq',
                    'content' => [
                        'items' => $faqItems,
                    ],
                ];
            }
        }
        
        // Identify video sections
        $videoNodes = $xpath->query('//video');
        foreach ($videoNodes as $videoNode) {
            $sourceNodes = $xpath->query('.//source', $videoNode);
            if ($sourceNodes->length > 0) {
                $videoSrc = $sourceNodes->item(0)->getAttribute('src');
                
                $sections[] = [
                    'type' => 'video',
                    'content' => [
                        'url' => $videoSrc,
                        'title' => '',
                        'description' => '',
                    ],
                ];
            }
        }
        
        // Identify text sections (paragraphs in shadow-lg boxes or main content)
        $textBoxNodes = $xpath->query('//div[contains(@class, "shadow-lg") and .//p]');
        foreach ($textBoxNodes as $textBoxNode) {
            $pNodes = $xpath->query('.//p', $textBoxNode);
            if ($pNodes->length > 0) {
                $textContent = '';
                foreach ($pNodes as $pNode) {
                    $textContent .= '<p>' . trim($pNode->textContent) . '</p>';
                }
                
                if (!empty(trim(strip_tags($textContent)))) {
                    $sections[] = [
                        'type' => 'text',
                        'content' => [
                            'content' => $textContent,
                        ],
                    ];
                }
            }
        }
        
        return $sections;
    }
    
    /**
     * Extract media files and copy to storage.
     */
    public function extractMediaFiles(string $filePath): array
    {
        $html = file_get_contents($filePath);
        
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        $xpath = new DOMXPath($dom);
        $mediaFiles = [];
        
        // Extract images
        $imgNodes = $xpath->query('//img');
        foreach ($imgNodes as $imgNode) {
            $src = $imgNode->getAttribute('src');
            $alt = $imgNode->getAttribute('alt');
            
            if (!empty($src) && !str_starts_with($src, 'http')) {
                $mediaFiles[] = [
                    'type' => 'image',
                    'src' => $src,
                    'alt' => $alt,
                ];
            }
        }
        
        // Extract videos
        $videoNodes = $xpath->query('//video//source');
        foreach ($videoNodes as $sourceNode) {
            $src = $sourceNode->getAttribute('src');
            
            if (!empty($src) && !str_starts_with($src, 'http')) {
                $mediaFiles[] = [
                    'type' => 'video',
                    'src' => $src,
                    'alt' => '',
                ];
            }
        }
        
        return $mediaFiles;
    }
    
    /**
     * Determine page category from filename or content.
     */
    public function determineCategory(string $filename): string
    {
        $filename = strtolower($filename);
        
        $categoryMap = [
            'admission' => 'admissions',
            'apply' => 'admissions',
            'accepted' => 'admissions',
            'dean' => 'faculties',
            'faculty' => 'faculties',
            'automotive' => 'faculties',
            'energy' => 'faculties',
            'mechatronics' => 'faculties',
            'event' => 'events',
            'competition' => 'events',
            'conference' => 'events',
            'exhibition' => 'events',
            'about' => 'about',
            'mission' => 'about',
            'vision' => 'about',
            'quality' => 'quality',
            'evaluation' => 'quality',
            'media' => 'media',
            'news' => 'media',
            'gallery' => 'media',
            'campus' => 'campus',
            'staff' => 'staff',
            'student' => 'student_services',
            'contact' => 'about',
        ];
        
        foreach ($categoryMap as $keyword => $category) {
            if (str_contains($filename, $keyword)) {
                return $category;
            }
        }
        
        return 'about';
    }
}
