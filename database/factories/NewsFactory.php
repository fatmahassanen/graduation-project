<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(),
            'body' => fake()->paragraphs(3, true),
            'featured_image_id' => null,
            'author_id' => User::factory(),
            'category' => fake()->randomElement(['announcement', 'achievement', 'research', 'partnership']),
            'is_featured' => fake()->boolean(20),
            'language' => 'en',
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
