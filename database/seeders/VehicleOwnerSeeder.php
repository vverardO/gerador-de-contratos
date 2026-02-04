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
        VehicleOwner::factory()
            ->create([
                'name' => 'Izicar Locacao de Veiculos',
                'document' => '54379584000187',
            ]);

        VehicleOwner::factory()
            ->create([
                'name' => 'Valentim Verardo',
                'document' => '02111245089',
            ]);

        VehicleOwner::factory()
            ->create([
                'name' => 'Sempreju Servicos de Tecnologia LTDA',
                'document' => '62894552000148',
            ]);
    }
}
