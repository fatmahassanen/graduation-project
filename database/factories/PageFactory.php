<?php

namespace Database\Factories;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        $categories = ['admissions', 'faculties', 'events', 'about', 'quality', 'media', 'campus', 'staff', 'student_services'];
        $statuses = ['draft', 'published', 'archived'];

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'category' => $this->faker->randomElement($categories),
            'status' => $this->faker->randomElement($statuses),
            'language' => $this->faker->randomElement(['en', 'ar']),
            'meta_title' => $this->faker->sentence(),
            'meta_description' => $this->faker->paragraph(),
            'meta_keywords' => implode(', ', $this->faker->words(5)),
            'og_image' => $this->faker->imageUrl(),
            'created_by' => User::factory(),
            'updated_by' => null,
            'published_at' => null,
        ];
    }

    /**
     * Indicate that the page is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    /**
     * Indicate that the page is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the page is archived.
     */
    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'archived',
        ]);
    }

    /**
     * Indicate that the page is in a specific language.
     */
    public function inLanguage(string $language): static
    {
        return $this->state(fn (array $attributes) => [
            'language' => $language,
        ]);
    }

    /**
     * Indicate that the page is in a specific category.
     */
    public function inCategory(string $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => $category,
        ]);
    }
}
