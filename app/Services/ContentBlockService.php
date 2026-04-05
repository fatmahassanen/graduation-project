<?php

namespace App\Services;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class ContentBlockService
{
    public function __construct(
        protected ContentSanitizer $sanitizer
    ) {
    }

    /**
     * JSON schemas for each content block type.
     */
    protected array $schemas = [
        'hero' => [
            'required' => ['title', 'description', 'image'],
            'optional' => ['ctaText', 'ctaLink'],
            'rules' => [
                'title' => 'string|max:255',
                'description' => 'string|max:1000',
                'image' => 'string',
                'ctaText' => 'string|max:50',
                'ctaLink' => 'string',
            ],
        ],
        'card_grid' => [
            'required' => ['cards', 'columns'],
            'optional' => [],
            'rules' => [
                'columns' => 'integer|min:1|max:4',
                'cards' => 'array',
                'cards.*.title' => 'required|string|max:255',
                'cards.*.description' => 'string|max:500',
                'cards.*.image' => 'string',
                'cards.*.link' => 'string',
                'cards.*.icon' => 'string',
            ],
        ],
        'faq' => [
            'required' => ['items'],
            'optional' => [],
            'rules' => [
                'items' => 'array',
                'items.*.question' => 'required|string|max:500',
                'items.*.answer' => 'required|string|max:2000',
            ],
        ],
        'text' => [
            'required' => ['content'],
            'optional' => [],
            'rules' => [
                'content' => 'string',
            ],
        ],
        'video' => [
            'required' => ['url'],
            'optional' => ['title', 'description'],
            'rules' => [
                'url' => 'string',
                'title' => 'string|max:255',
                'description' => 'string|max:1000',
            ],
        ],
        'testimonial' => [
            'required' => ['items'],
            'optional' => [],
            'rules' => [
                'items' => 'array',
                'items.*.name' => 'required|string|max:255',
                'items.*.role' => 'string|max:255',
                'items.*.content' => 'required|string|max:1000',
                'items.*.image' => 'string',
            ],
        ],
        'gallery' => [
            'required' => ['images'],
            'optional' => ['title'],
            'rules' => [
                'images' => 'array',
                'images.*.url' => 'required|string',
                'images.*.alt' => 'string|max:255',
                'images.*.caption' => 'string|max:500',
                'title' => 'string|max:255',
            ],
        ],
        'contact_form' => [
            'required' => ['fields'],
            'optional' => ['title', 'submitText'],
            'rules' => [
                'fields' => 'array',
                'fields.*.name' => 'required|string|max:100',
                'fields.*.type' => 'required|string|in:text,email,tel,textarea,select',
                'fields.*.label' => 'required|string|max:255',
                'fields.*.required' => 'boolean',
                'fields.*.options' => 'array',
                'title' => 'string|max:255',
                'submitText' => 'string|max:50',
            ],
        ],
    ];

    /**
     * Create a new content block.
     */
    public function createBlock(array $data, User $user): ContentBlock
    {
        // Validate content against type schema
        if (isset($data['type']) && isset($data['content'])) {
            if (!$this->validateBlockContent($data['type'], $data['content'])) {
                throw ValidationException::withMessages([
                    'content' => ['The content does not match the required schema for type: ' . $data['type']],
                ]);
            }

            // Sanitize HTML content
            $data['content'] = $this->sanitizeContent($data['type'], $data['content']);
        }

        // Set creator
        $data['created_by'] = $user->id;

        // Create the block
        $block = ContentBlock::create($data);

        // Create revision for the creation
        $this->createRevision($block, [], $block->toArray(), $user, 'created');

        return $block;
    }

    /**
     * Update an existing content block.
     */
    public function updateBlock(ContentBlock $block, array $data, User $user): ContentBlock
    {
        // Capture old values for revision
        $oldValues = $block->toArray();

        // Validate content if type or content is being updated
        $type = $data['type'] ?? $block->type;
        $content = $data['content'] ?? $block->content;

        if (!$this->validateBlockContent($type, $content)) {
            throw ValidationException::withMessages([
                'content' => ['The content does not match the required schema for type: ' . $type],
            ]);
        }

        // Sanitize HTML content if content is being updated
        if (isset($data['content'])) {
            $data['content'] = $this->sanitizeContent($type, $data['content']);
        }

        // Set updater
        $data['updated_by'] = $user->id;

        // Update the block
        $block->update($data);
        $block->refresh();

        // Create revision for the update
        $this->createRevision($block, $oldValues, $block->toArray(), $user, 'updated');

        return $block;
    }

    /**
     * Delete a content block.
     */
    public function deleteBlock(ContentBlock $block, User $user): bool
    {
        // Capture values for revision
        $oldValues = $block->toArray();

        // Create revision for the deletion
        $this->createRevision($block, $oldValues, [], $user, 'deleted');

        // Delete the block
        return $block->delete();
    }

    /**
     * Reorder content blocks for a page.
     * 
     * @param Page $page
     * @param array $order Array of block IDs in desired order
     */
    public function reorderBlocks(Page $page, array $order): void
    {
        foreach ($order as $index => $blockId) {
            ContentBlock::where('id', $blockId)
                ->where('page_id', $page->id)
                ->update(['display_order' => $index]);
        }
    }

    /**
     * Validate content block JSON structure against type schema.
     */
    public function validateBlockContent(string $type, array $content): bool
    {
        // Check if type is supported
        if (!isset($this->schemas[$type])) {
            return false;
        }

        $schema = $this->schemas[$type];

        // Check required fields
        foreach ($schema['required'] as $field) {
            if (!isset($content[$field])) {
                return false;
            }
        }

        // Validate using Laravel validator
        $validator = validator($content, $schema['rules']);

        return !$validator->fails();
    }

    /**
     * Get all content blocks for a page, ordered by display_order.
     */
    public function getBlocksByPage(Page $page): Collection
    {
        return $page->contentBlocks()->orderBy('display_order')->get();
    }

    /**
     * Create a revision record for a content block.
     */
    protected function createRevision(ContentBlock $block, array $oldValues, array $newValues, User $user, string $action): void
    {
        $block->revisions()->create([
            'user_id' => $user->id,
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'created_at' => now(),
        ]);
    }

    /**
     * Sanitize HTML content in content blocks
     */
    protected function sanitizeContent(string $type, array $content): array
    {
        // Fields that may contain HTML and need sanitization
        $htmlFields = [
            'text' => ['content'],
            'hero' => ['description'],
            'card_grid' => ['cards.*.description'],
            'faq' => ['items.*.answer'],
            'testimonial' => ['items.*.content'],
            'video' => ['description'],
        ];

        if (!isset($htmlFields[$type])) {
            return $content;
        }

        foreach ($htmlFields[$type] as $field) {
            // Handle nested fields (e.g., cards.*.description)
            if (str_contains($field, '.*.')) {
                [$arrayField, $nestedField] = explode('.*.', $field);
                
                if (isset($content[$arrayField]) && is_array($content[$arrayField])) {
                    foreach ($content[$arrayField] as $index => $item) {
                        if (isset($item[$nestedField]) && is_string($item[$nestedField])) {
                            $content[$arrayField][$index][$nestedField] = $this->sanitizer->sanitize($item[$nestedField]);
                        }
                    }
                }
            } else {
                // Handle simple fields
                if (isset($content[$field]) && is_string($content[$field])) {
                    $content[$field] = $this->sanitizer->sanitize($content[$field]);
                }
            }
        }

        return $content;
    }
}
