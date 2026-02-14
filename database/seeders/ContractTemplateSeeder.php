<?php

namespace Database\Seeders;

use App\Models\ContractTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractTemplateSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        ContractTemplate::factory(5)->create();
    }
}
