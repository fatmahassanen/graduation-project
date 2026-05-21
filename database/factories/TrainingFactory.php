<?php

namespace Database\Factories;

use App\Models\Training;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Training>
 */
class TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(5),
            'description' => fake()->paragraph(3),
            'instructor' => fake()->name(),
            'start_date' => fake()->dateTimeBetween('now', '+6 months'),
            'end_date' => fake()->optional()->dateTimeBetween('+1 week', '+7 months'),
            'location' => fake()->randomElement(['NCTU Campus', 'Room 101', 'Lab A', 'Online', 'External Partner']),
            'duration' => fake()->optional()->numberBetween(8, 120),
            'capacity' => fake()->optional()->numberBetween(10, 100),
            'category' => fake()->randomElement(['Technical', 'Soft Skills', 'Leadership', 'Professional Development']),
            'is_active' => fake()->boolean(90),
        ];
    }
}
