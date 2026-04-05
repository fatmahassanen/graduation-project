<?php

namespace Tests\Unit;

use App\Services\MigrationService;
use PHPUnit\Framework\TestCase;

class MigrationServiceTest extends TestCase
{
    protected MigrationService $service;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new MigrationService();
    }
    
    public function test_determine_category_from_filename(): void
    {
        $this->assertEquals('admissions', $this->service->determineCategory('Admissions.html'));
        $this->assertEquals('admissions', $this->service->determineCategory('accepted.html'));
        $this->assertEquals('faculties', $this->service->determineCategory('Dean1.html'));
        $this->assertEquals('faculties', $this->service->determineCategory('automotive.html'));
        $this->assertEquals('events', $this->service->determineCategory('Events.html'));
        $this->assertEquals('events', $this->service->determineCategory('Competitions.html'));
        $this->assertEquals('about', $this->service->determineCategory('about.html'));
        $this->assertEquals('quality', $this->service->determineCategory('quality.html'));
        $this->assertEquals('media', $this->service->determineCategory('media.html'));
        $this->assertEquals('campus', $this->service->determineCategory('campus.html'));
        $this->assertEquals('staff', $this->service->determineCategory('staff.html'));
        $this->assertEquals('student_services', $this->service->determineCategory('student.html'));
        $this->assertEquals('about', $this->service->determineCategory('unknown.html'));
    }
    
    public function test_parse_html_file_extracts_metadata(): void
    {
        $testHtml = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Test Page Title</title>
    <meta name="description" content="Test description">
    <meta name="keywords" content="test, keywords">
</head>
<body>
    <div class="page-header">
        <h1>Page Header Title</h1>
    </div>
</body>
</html>
HTML;
        
        $tempFile = tempnam(sys_get_temp_dir(), 'test_html_');
        file_put_contents($tempFile, $testHtml);
        
        $metadata = $this->service->parseHtmlFile($tempFile);
        
        $this->assertEquals('Page Header Title', $metadata['title']);
        $this->assertEquals('Test Page Title', $metadata['meta_title']);
        $this->assertEquals('Test description', $metadata['meta_description']);
        $this->assertEquals('test, keywords', $metadata['meta_keywords']);
        
        unlink($tempFile);
    }
    
    public function test_identify_content_sections_finds_hero(): void
    {
        $testHtml = <<<HTML
<!DOCTYPE html>
<html>
<body>
    <div class="page-header">
        <h1>Hero Title</h1>
    </div>
</body>
</html>
HTML;
        
        $tempFile = tempnam(sys_get_temp_dir(), 'test_html_');
        file_put_contents($tempFile, $testHtml);
        
        $sections = $this->service->identifyContentSections($tempFile);
        
        $this->assertCount(1, $sections);
        $this->assertEquals('hero', $sections[0]['type']);
        $this->assertEquals('Hero Title', $sections[0]['content']['title']);
        
        unlink($tempFile);
    }
    
    public function test_identify_content_sections_finds_card_grid(): void
    {
        $testHtml = <<<HTML
<!DOCTYPE html>
<html>
<body>
    <div class="row">
        <div class="service-item">
            <h5>Card 1</h5>
            <p>Description 1</p>
        </div>
        <div class="service-item">
            <h5>Card 2</h5>
            <p>Description 2</p>
        </div>
    </div>
</body>
</html>
HTML;
        
        $tempFile = tempnam(sys_get_temp_dir(), 'test_html_');
        file_put_contents($tempFile, $testHtml);
        
        $sections = $this->service->identifyContentSections($tempFile);
        
        $this->assertGreaterThan(0, count($sections));
        
        $cardGridSection = null;
        foreach ($sections as $section) {
            if ($section['type'] === 'card_grid') {
                $cardGridSection = $section;
                break;
            }
        }
        
        $this->assertNotNull($cardGridSection);
        $this->assertCount(2, $cardGridSection['content']['cards']);
        $this->assertEquals('Card 1', $cardGridSection['content']['cards'][0]['title']);
        $this->assertEquals('Description 1', $cardGridSection['content']['cards'][0]['description']);
        
        unlink($tempFile);
    }
    
    public function test_extract_media_files_finds_images(): void
    {
        $testHtml = <<<HTML
<!DOCTYPE html>
<html>
<body>
    <img src="img/logo.png" alt="Logo">
    <img src="img/banner.jpg" alt="Banner">
</body>
</html>
HTML;
        
        $tempFile = tempnam(sys_get_temp_dir(), 'test_html_');
        file_put_contents($tempFile, $testHtml);
        
        $mediaFiles = $this->service->extractMediaFiles($tempFile);
        
        $this->assertCount(2, $mediaFiles);
        $this->assertEquals('image', $mediaFiles[0]['type']);
        $this->assertEquals('img/logo.png', $mediaFiles[0]['src']);
        $this->assertEquals('Logo', $mediaFiles[0]['alt']);
        
        unlink($tempFile);
    }
}
