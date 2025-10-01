<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(2, true);
        
        return [
            'name' => ucwords($name),
            'slug' => str()->slug($name),
            'color' => fake()->hexColor(),
            'icon' => fake()->randomElement(['📚', '⚽', '💻', '🎵', '🎨', '🍕']),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}