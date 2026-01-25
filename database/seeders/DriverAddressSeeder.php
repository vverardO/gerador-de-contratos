<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\DriverAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverAddressSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $drivers = Driver::all();

        foreach ($drivers as $driver) {
            DriverAddress::factory()->create([
                'driver_id' => $driver->id,
            ]);
        }
    }
}
