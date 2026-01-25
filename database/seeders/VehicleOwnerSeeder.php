<?php

namespace Database\Seeders;

use App\Models\VehicleOwner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleOwnerSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        VehicleOwner::factory(15)->create();
    }
}
