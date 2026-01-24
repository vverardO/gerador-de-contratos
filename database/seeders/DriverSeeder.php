<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Driver::factory(15)->create();
    }
}
