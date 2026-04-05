<?php

namespace App\Services;

class ContentSanitizer
{
    /**
     * Allowed HTML tags for content
     */
    protected array $allowedTags = [
        'p', 'br', 'strong', 'em', 'u', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'ul', 'ol', 'li', 'a', 'img', 'blockquote', 'code', 'pre',
        'table', 'thead', 'tbody', 'tr', 'th', 'td',
        'div', 'span', 'section', 'article',
    ];

    /**
     * Allowed attributes for specific tags
     */
    protected array $allowedAttributes = [
        'a' => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title', 'width', 'height', 'loading'],
        'div' => ['class', 'id'],
        'span' => ['class', 'id'],
        'section' => ['class', 'id'],
        'article' => ['class', 'id'],
        'table' => ['class'],
        'th' => ['class', 'colspan', 'rowspan'],
        'td' => ['class', 'colspan', 'rowspan'],
    ];

    /**
     * Dangerous patterns to remove
     */
    protected array $dangerousPatterns = [
        '/javascript:/i',
        '/on\w+\s*=/i', // Event handlers like onclick, onload, etc.
        '/<script\b[^>]*>.*?<\/script>/is',
        '/<iframe\b[^>]*>.*?<\/iframe>/is',
        '/<object\b[^>]*>.*?<\/object>/is',
        '/<embed\b[^>]*>/i',
        '/<applet\b[^>]*>.*?<\/applet>/is',
        '/vbscript:/i',
        '/data:text\/html/i',
    ];

    /**
     * Sanitize HTML content
     */
    public function sanitize(string $html): string
    {
        if (empty($html)) {
            return '';
        }

        // Remove dangerous patterns first
        $html = $this->removeDangerousPatterns($html);

        // Parse HTML with DOMDocument
        $dom = new \DOMDocument('1.0', 'UTF-8');
        
        // Suppress warnings for malformed HTML
        libxml_use_internal_errors(true);
        
        // Wrap content in a div to preserve structure
        $wrappedHtml = '<div>' . $html . '</div>';
        
        // Load HTML with UTF-8 encoding
        $dom->loadHTML('<?xml encoding="UTF-8">' . $wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        // Clear errors
        libxml_clear_errors();

        // Sanitize the DOM tree (start from body or first child)
        $body = $dom->getElementsByTagName('div')->item(0);
        if ($body) {
            $this->sanitizeNode($body);
            
            // Get the sanitized HTML from inside the wrapper div
            $sanitized = '';
            foreach ($body->childNodes as $child) {
                $sanitized .= $dom->saveHTML($child);
            }
        } else {
            $sanitized = $dom->saveHTML();
        }

        // Remove the XML encoding declaration we added
        $sanitized = preg_replace('/^<\?xml[^>]+>\s*/i', '', $sanitized);

        return $sanitized;
    }

    /**
     * Remove dangerous patterns from HTML
     */
    protected function removeDangerousPatterns(string $html): string
    {
        foreach ($this->dangerousPatterns as $pattern) {
            $html = preg_replace($pattern, '', $html);
        }

        return $html;
    }

    /**
     * Recursively sanitize DOM nodes
     */
    protected function sanitizeNode(\DOMNode $node): void
    {
        // Process child nodes first (bottom-up)
        if ($node->hasChildNodes()) {
            $children = [];
            foreach ($node->childNodes as $child) {
                $children[] = $child;
            }

            foreach ($children as $child) {
                $this->sanitizeNode($child);
            }
        }

        // Only process element nodes
        if ($node->nodeType !== XML_ELEMENT_NODE) {
            return;
        }

        $tagName = strtolower($node->nodeName);

        // Remove disallowed tags but preserve their text content
        if (!in_array($tagName, $this->allowedTags)) {
            if ($node->parentNode) {
                // Extract all child nodes (including text nodes)
                $fragment = $node->ownerDocument->createDocumentFragment();
                while ($node->firstChild) {
                    $fragment->appendChild($node->firstChild);
                }
                // Replace the disallowed tag with its children
                $node->parentNode->replaceChild($fragment, $node);
            }
            return;
        }

        // Sanitize attributes
        if ($node->hasAttributes()) {
            $attributesToRemove = [];

            foreach ($node->attributes as $attribute) {
                $attrName = strtolower($attribute->name);
                $attrValue = $attribute->value;

                // Check if attribute is allowed for this tag
                $allowedForTag = $this->allowedAttributes[$tagName] ?? [];

                if (!in_array($attrName, $allowedForTag)) {
                    $attributesToRemove[] = $attrName;
                    continue;
                }

                // Check for dangerous values in allowed attributes
                if ($this->isDangerousAttributeValue($attrValue)) {
                    $attributesToRemove[] = $attrName;
                }
            }

            // Remove dangerous attributes
            foreach ($attributesToRemove as $attrName) {
                $node->removeAttribute($attrName);
            }
        }
    }

    /**
     * Check if an attribute value is dangerous
     */
    protected function isDangerousAttributeValue(string $value): bool
    {
        $dangerousValuePatterns = [
            '/javascript:/i',
            '/vbscript:/i',
            '/data:text\/html/i',
            '/on\w+\s*=/i',
            '/alert\s*\(/i',  // Detect alert() calls
            '/eval\s*\(/i',   // Detect eval() calls
        ];

        foreach ($dangerousValuePatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Sanitize plain text (strip all HTML)
     */
    public function sanitizePlainText(string $text): string
    {
        return strip_tags($text);
    }

    /**
     * Sanitize and preserve basic formatting
     */
    public function sanitizeBasicFormatting(string $html): string
    {
        // Only allow basic formatting tags
        $basicTags = ['p', 'br', 'strong', 'em', 'u', 'a'];
        $originalAllowedTags = $this->allowedTags;
        
        $this->allowedTags = $basicTags;
        $sanitized = $this->sanitize($html);
        
        $this->allowedTags = $originalAllowedTags;
        
        return $sanitized;
    }
}
