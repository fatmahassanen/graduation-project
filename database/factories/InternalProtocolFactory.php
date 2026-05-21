<?php

namespace Database\Factories;

use App\Models\InternalProtocol;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InternalProtocol>
 */
class InternalProtocolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'organization_name' => fake()->company(),
            'image' => null,
            'year' => fake()->numberBetween(2020, 2030),
            'is_active' => true,
            'order' => fake()->numberBetween(0, 10),
        ];
    }
}
