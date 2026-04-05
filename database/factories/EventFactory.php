<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'start_date' => fake()->dateTimeBetween('now', '+1 month'),
            'end_date' => fake()->dateTimeBetween('+1 month', '+2 months'),
            'location' => fake()->address(),
            'category' => fake()->randomElement(['competition', 'conference', 'exhibition', 'workshop', 'seminar']),
            'image_id' => null,
            'is_recurring' => false,
            'recurrence_rule' => null,
            'language' => 'en',
            'status' => 'published',
            'created_by' => User::factory(),
        ];
    }
}
