<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\DriverAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverAddressFactory extends Factory
{
    protected $model = DriverAddress::class;

    public function definition(): array
    {
        return [
            'driver_id' => Driver::factory(),
            'postal_code' => fake()->postcode(),
            'street' => fake()->streetName(),
            'number' => fake()->buildingNumber(),
            'complement' => fake()->optional()->secondaryAddress(),
            'neighborhood' => fake()->citySuffix(),
            'city' => fake()->city(),
            'state' => fake()->stateAbbr(),
        ];
    }
}
