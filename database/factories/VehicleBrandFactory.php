<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleBrandFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
        ];
    }
}
