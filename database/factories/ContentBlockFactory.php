<?php

namespace Database\Factories;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContentBlock>
 */
class ContentBlockFactory extends Factory
{
    protected $model = ContentBlock::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['hero', 'text', 'card_grid', 'video', 'faq', 'testimonial', 'gallery', 'contact_form'];
        $type = $this->faker->randomElement($types);

        return [
            'page_id' => Page::factory(),
            'type' => $type,
            'content' => $this->generateContentForType($type),
            'display_order' => $this->faker->numberBetween(0, 10),
            'is_reusable' => $this->faker->boolean(20), // 20% chance of being reusable
            'created_by' => User::factory(),
            'updated_by' => null,
        ];
    }

    /**
     * Generate appropriate content structure for the given block type.
     */
    private function generateContentForType(string $type): array
    {
        return match ($type) {
            'hero' => [
                'title' => $this->faker->sentence(),
                'description' => $this->faker->paragraph(),
                'image' => $this->faker->imageUrl(),
                'ctaText' => $this->faker->words(2, true),
                'ctaLink' => $this->faker->url(),
            ],
            'text' => [
                'content' => $this->faker->paragraphs(3, true),
            ],
            'card_grid' => [
                'columns' => $this->faker->numberBetween(2, 4),
                'cards' => array_map(fn() => [
                    'title' => $this->faker->sentence(),
                    'description' => $this->faker->paragraph(),
                    'image' => $this->faker->imageUrl(),
                    'link' => $this->faker->url(),
                ], range(1, $this->faker->numberBetween(3, 6))),
            ],
            'video' => [
                'url' => $this->faker->url(),
                'title' => $this->faker->sentence(),
                'description' => $this->faker->paragraph(),
            ],
            'faq' => [
                'items' => array_map(fn() => [
                    'question' => $this->faker->sentence() . '?',
                    'answer' => $this->faker->paragraph(),
                ], range(1, $this->faker->numberBetween(3, 8))),
            ],
            'testimonial' => [
                'items' => array_map(fn() => [
                    'name' => $this->faker->name(),
                    'role' => $this->faker->jobTitle(),
                    'content' => $this->faker->paragraph(),
                    'image' => $this->faker->imageUrl(),
                ], range(1, $this->faker->numberBetween(2, 5))),
            ],
            'gallery' => [
                'images' => array_map(fn() => [
                    'url' => $this->faker->imageUrl(),
                    'caption' => $this->faker->sentence(),
                ], range(1, $this->faker->numberBetween(4, 12))),
            ],
            'contact_form' => [
                'title' => $this->faker->sentence(),
                'fields' => ['name', 'email', 'phone', 'subject', 'message'],
            ],
            default => [],
        };
    }

    /**
     * Indicate that the content block is reusable.
     */
    public function reusable(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_reusable' => true,
        ]);
    }

    /**
     * Indicate that the content block is of a specific type.
     */
    public function ofType(string $type): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => $type,
            'content' => $this->generateContentForType($type),
        ]);
    }
}
