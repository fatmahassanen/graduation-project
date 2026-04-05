<?php

namespace Tests\Unit;

use App\Services\ContentSanitizer;
use Tests\TestCase;

class HtmlSanitizationPropertyTest extends TestCase
{
    protected ContentSanitizer $sanitizer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sanitizer = new ContentSanitizer();
    }

    /**
     * Property 25: HTML Sanitization Security
     * 
     * For any HTML content input containing potential XSS vectors (script tags,
     * event handlers, javascript: URLs), sanitization SHALL remove or neutralize
     * the dangerous elements.
     * 
     * Validates: Requirements 10.4
     */
    public function test_property_25_html_sanitization_security(): void
    {
        // Test 1: Remove script tags
        $maliciousHtml = '<p>Hello</p><script>alert("XSS")</script><p>World</p>';
        $sanitized = $this->sanitizer->sanitize($maliciousHtml);
        
        $this->assertStringNotContainsString('<script>', $sanitized);
        $this->assertStringNotContainsString('alert', $sanitized);
        $this->assertStringContainsString('Hello', $sanitized);
        $this->assertStringContainsString('World', $sanitized);

        // Test 2: Remove event handlers
        $maliciousHtml = '<p onclick="alert(\'XSS\')">Click me</p>';
        $sanitized = $this->sanitizer->sanitize($maliciousHtml);
        
        $this->assertStringNotContainsString('onclick', $sanitized);
        $this->assertStringContainsString('Click me', $sanitized);

        // Test 3: Remove javascript: URLs
        $maliciousHtml = '<a href="javascript:alert(\'XSS\')">Link</a>';
        $sanitized = $this->sanitizer->sanitize($maliciousHtml);
        
        $this->assertStringNotContainsString('javascript:', $sanitized);
        $this->assertStringContainsString('Link', $sanitized);

        // Test 4: Remove iframe tags
        $maliciousHtml = '<p>Content</p><iframe src="evil.com"></iframe>';
        $sanitized = $this->sanitizer->sanitize($maliciousHtml);
        
        $this->assertStringNotContainsString('<iframe', $sanitized);
        $this->assertStringNotContainsString('evil.com', $sanitized);
        $this->assertStringContainsString('Content', $sanitized);

        // Test 5: Remove object and embed tags
        $maliciousHtml = '<object data="evil.swf"></object><embed src="evil.swf">';
        $sanitized = $this->sanitizer->sanitize($maliciousHtml);
        
        $this->assertStringNotContainsString('<object', $sanitized);
        $this->assertStringNotContainsString('<embed', $sanitized);

        // Test 6: Remove vbscript: URLs
        $maliciousHtml = '<a href="vbscript:msgbox(\'XSS\')">Link</a>';
        $sanitized = $this->sanitizer->sanitize($maliciousHtml);
        
        $this->assertStringNotContainsString('vbscript:', $sanitized);

        // Test 7: Remove data:text/html URLs
        $maliciousHtml = '<a href="data:text/html,<script>alert(\'XSS\')</script>">Link</a>';
        $sanitized = $this->sanitizer->sanitize($maliciousHtml);
        
        $this->assertStringNotContainsString('data:text/html', $sanitized);
    }

    /**
     * Property 26: HTML Formatting Preservation
     * 
     * For any valid HTML content with allowed tags and attributes, sanitization
     * SHALL preserve the formatting and structure.
     * 
     * Validates: Requirements 10.6
     */
    public function test_property_26_html_formatting_preservation(): void
    {
        // Test 1: Preserve basic formatting tags
        $validHtml = '<p>This is <strong>bold</strong> and <em>italic</em> text.</p>';
        $sanitized = $this->sanitizer->sanitize($validHtml);
        
        $this->assertStringContainsString('<strong>bold</strong>', $sanitized);
        $this->assertStringContainsString('<em>italic</em>', $sanitized);
        $this->assertStringContainsString('<p>', $sanitized);

        // Test 2: Preserve headings
        $validHtml = '<h1>Heading 1</h1><h2>Heading 2</h2><h3>Heading 3</h3>';
        $sanitized = $this->sanitizer->sanitize($validHtml);
        
        $this->assertStringContainsString('<h1>Heading 1</h1>', $sanitized);
        $this->assertStringContainsString('<h2>Heading 2</h2>', $sanitized);
        $this->assertStringContainsString('<h3>Heading 3</h3>', $sanitized);

        // Test 3: Preserve lists
        $validHtml = '<ul><li>Item 1</li><li>Item 2</li></ul>';
        $sanitized = $this->sanitizer->sanitize($validHtml);
        
        $this->assertStringContainsString('<ul>', $sanitized);
        $this->assertStringContainsString('<li>Item 1</li>', $sanitized);
        $this->assertStringContainsString('<li>Item 2</li>', $sanitized);

        // Test 4: Preserve links with allowed attributes
        $validHtml = '<a href="https://example.com" title="Example">Link</a>';
        $sanitized = $this->sanitizer->sanitize($validHtml);
        
        $this->assertStringContainsString('href="https://example.com"', $sanitized);
        $this->assertStringContainsString('title="Example"', $sanitized);
        $this->assertStringContainsString('>Link</a>', $sanitized);

        // Test 5: Preserve images with allowed attributes
        $validHtml = '<img src="/image.jpg" alt="Test Image" loading="lazy">';
        $sanitized = $this->sanitizer->sanitize($validHtml);
        
        $this->assertStringContainsString('src="/image.jpg"', $sanitized);
        $this->assertStringContainsString('alt="Test Image"', $sanitized);
        $this->assertStringContainsString('loading="lazy"', $sanitized);

        // Test 6: Preserve tables
        $validHtml = '<table><tr><th>Header</th></tr><tr><td>Data</td></tr></table>';
        $sanitized = $this->sanitizer->sanitize($validHtml);
        
        $this->assertStringContainsString('<table>', $sanitized);
        $this->assertStringContainsString('<th>Header</th>', $sanitized);
        $this->assertStringContainsString('<td>Data</td>', $sanitized);
    }

    /**
     * Property 25 Extended: Remove disallowed tags but preserve content
     */
    public function test_property_25_remove_disallowed_tags_preserve_content(): void
    {
        // Disallowed tags should be removed but their text content preserved
        $html = '<p>Hello</p><marquee>Moving text</marquee><p>World</p>';
        $sanitized = $this->sanitizer->sanitize($html);
        
        $this->assertStringNotContainsString('<marquee>', $sanitized);
        $this->assertStringContainsString('Moving text', $sanitized);
        $this->assertStringContainsString('Hello', $sanitized);
        $this->assertStringContainsString('World', $sanitized);
    }

    /**
     * Property 25 Extended: Remove disallowed attributes
     */
    public function test_property_25_remove_disallowed_attributes(): void
    {
        // Disallowed attributes should be removed
        $html = '<p style="color: red;" data-custom="value">Text</p>';
        $sanitized = $this->sanitizer->sanitize($html);
        
        $this->assertStringNotContainsString('style=', $sanitized);
        $this->assertStringNotContainsString('data-custom=', $sanitized);
        $this->assertStringContainsString('Text', $sanitized);
    }

    /**
     * Property 26 Extended: Preserve nested structures
     */
    public function test_property_26_preserve_nested_structures(): void
    {
        $validHtml = '<div class="container"><p>Paragraph in <strong>div</strong></p></div>';
        $sanitized = $this->sanitizer->sanitize($validHtml);
        
        $this->assertStringContainsString('<div', $sanitized);
        $this->assertStringContainsString('class="container"', $sanitized);
        $this->assertStringContainsString('<p>', $sanitized);
        $this->assertStringContainsString('<strong>div</strong>', $sanitized);
    }

    /**
     * Property 26 Extended: Handle empty input
     */
    public function test_property_26_handle_empty_input(): void
    {
        $sanitized = $this->sanitizer->sanitize('');
        $this->assertEquals('', $sanitized);
    }

    /**
     * Property 26 Extended: Handle plain text
     */
    public function test_property_26_handle_plain_text(): void
    {
        $plainText = 'This is plain text without HTML';
        $sanitized = $this->sanitizer->sanitize($plainText);
        
        $this->assertStringContainsString('This is plain text without HTML', $sanitized);
    }

    /**
     * Property 25 Extended: Multiple XSS vectors in one input
     */
    public function test_property_25_multiple_xss_vectors(): void
    {
        $maliciousHtml = '<p onclick="alert(1)">Text</p><script>alert(2)</script><a href="javascript:alert(3)">Link</a>';
        $sanitized = $this->sanitizer->sanitize($maliciousHtml);
        
        $this->assertStringNotContainsString('onclick', $sanitized);
        $this->assertStringNotContainsString('<script>', $sanitized);
        $this->assertStringNotContainsString('javascript:', $sanitized);
        $this->assertStringNotContainsString('alert', $sanitized);
        $this->assertStringContainsString('Text', $sanitized);
        $this->assertStringContainsString('Link', $sanitized);
    }
}
