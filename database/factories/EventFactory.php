<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'date' => fake()->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
            'time' => fake()->time('H:i:s'),
            'location' => fake()->address(),
            'capacity' => fake()->numberBetween(10, 200),
            'organizer_id' => User::factory(),
        ];
    }
}