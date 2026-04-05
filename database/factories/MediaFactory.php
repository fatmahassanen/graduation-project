<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filename = fake()->uuid() . '.jpg';

        return [
            'filename' => $filename,
            'original_name' => fake()->word() . '.jpg',
            'mime_type' => 'image/jpeg',
            'size' => fake()->numberBetween(10000, 5000000),
            'path' => 'media/' . $filename,
            'uploaded_by' => User::factory(),
            'alt_text' => fake()->optional()->sentence(),
        ];
    }
}
