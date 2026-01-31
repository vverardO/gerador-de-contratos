<?php

namespace Database\Factories;

use App\Models\VehicleBrand;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'vehicle_brand_id' => VehicleBrand::factory(),
            'title' => fake()->name(),
        ];
    }
}
