<?php

namespace Database\Factories;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VehicleOwner;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    public function definition(): array
    {
        $year = fake()->numberBetween(2020, 2024);
        $modelYear = $year + 1;
        $valueCents = fake()->numberBetween(5000, 500000);

        $type = fake()->randomElement([ContractType::OCCASIONAL_RENTAL, ContractType::APP_RENTAL]);

        if ($type === ContractType::OCCASIONAL_RENTAL) {
            $quantityDays = fake()->numberBetween(7, 30);
            $startDate = fake()->dateTimeBetween('-1 year', 'now');
            $endDate = fake()->dateTimeBetween('+1 week', '+1 month');
        } else {
            $quantityDays = null;
            $startDate = null;
            $endDate = null;
        }

        $owner = VehicleOwner::inRandomOrder()->first();
        $vehicle = Vehicle::inRandomOrder()->first();
        $driver = Driver::inRandomOrder()->first();

        return [
            'type' => $type,
            'status' => ContractStatus::DRAFT->value,
            'driver_name' => $driver->name,
            'driver_document' => $driver->document,
            'driver_license' => $driver->driver_license,
            'driver_license_expiration' => $driver->driver_license_expiration,
            'driver_street' => $driver->address->street,
            'driver_city' => $driver->address->city,
            'driver_number' => $driver->address->number,
            'driver_neighborhood' => $driver->address->neighborhood,
            'driver_zip_code' => $driver->address->postal_code,
            'vehicle' => $vehicle->display_name,
            'manufacturing_model' => "{$year}/{$modelYear}",
            'license_plate' => $vehicle->license_plate,
            'chassis' => $vehicle->chassis,
            'renavam' => $vehicle->renavam,
            'owner_name' => $owner->name,
            'owner_document' => $owner->document,
            'value' => $valueCents,
            'today_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'quantity_days' => $quantityDays,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
