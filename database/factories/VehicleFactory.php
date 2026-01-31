<?php

namespace Database\Factories;

use App\Models\VehicleModel;
use App\Models\VehicleOwner;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'vehicle_model_id' => VehicleModel::inRandomOrder()->first()->id,
            'vehicle_owner_id' => VehicleOwner::inRandomOrder()->first()->id,
            'manufacturing_model' => fake()->year().'/'.fake()->year(),
            'license_plate' => fake()->regexify('[A-Z]{3}[0-9][A-Z][0-9]{2}'),
            'chassis' => fake()->numerify('##################'),
            'renavam' => fake()->numerify('###########'),
        ];
    }
}
