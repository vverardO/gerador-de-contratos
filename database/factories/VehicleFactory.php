<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Chevrolet Onix', 'Fiat Uno', 'Volkswagen Gol', 'Ford Ka', 'Renault Kwid', 'Hyundai HB20', 'Toyota Corolla', 'Honda Civic']),
            'manufacturing_model' => fake()->year().'/'.fake()->year(),
            'license_plate' => fake()->regexify('[A-Z]{3}[0-9][A-Z][0-9]{2}'),
            'chassis' => fake()->numerify('##################'),
            'renavam' => fake()->numerify('###########'),
        ];
    }
}
