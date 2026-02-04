<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Contract::factory(20)->create();
    }
}
