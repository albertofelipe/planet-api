<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlanetFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'climate' => $this->faker->randomElement(['desert', 'frozen', 'temperate']),
            'terrain' => $this->faker->randomElement(['arid', 'snowy', 'temperate'])
        ];
    }
}
