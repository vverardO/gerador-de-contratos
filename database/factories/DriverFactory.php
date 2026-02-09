<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'document' => fake()->numerify('###########'),
            'driver_license' => fake()->optional(0.8)->numerify('########'),
        ];
    }
}
