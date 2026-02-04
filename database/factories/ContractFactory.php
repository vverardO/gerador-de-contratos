<?php

namespace Database\Factories;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    public function definition(): array
    {
        $year = fake()->numberBetween(2020, 2024);
        $modelYear = $year + 1;
        $valueCents = fake()->numberBetween(5000, 500000);

        $streets = [
            'Rua das Flores',
            'Avenida Principal',
            'Rua Central',
            'Avenida Liberdade',
            'Rua do Comércio',
            'Avenida Brasil',
            'Rua São Paulo',
            'Avenida dos Estados',
        ];

        $neighborhoods = [
            'Centro',
            'Passo da Areia',
            'Nossa Senhora de Fátima',
            'São João',
            'Vila Nova',
            'Jardim América',
            'Bela Vista',
            'Vila Esperança',
        ];

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

        return [
            'type' => $type,
            'status' => fake()->randomElement(ContractStatus::cases()),
            'driver_name' => fake()->name(),
            'driver_document' => fake()->numerify('###.###.###-##'),
            'driver_street' => fake()->randomElement($streets),
            'driver_number' => fake()->numberBetween(1, 9999),
            'driver_neighborhood' => fake()->randomElement($neighborhoods),
            'driver_zip_code' => fake()->numerify('#####-###'),
            'vehicle' => Vehicle::inRandomOrder()->first()->display_name,
            'manufacturing_model' => "{$year}/{$modelYear}",
            'license_plate' => fake()->regexify('[A-Z]{3}[0-9][A-Z][0-9]{2}'),
            'chassis' => fake()->regexify('[A-Z0-9]{17}'),
            'renavam' => fake()->numerify('###########'),
            'owner_name' => fake()->company(),
            'owner_document' => fake()->numerify('##.###.###/####-##'),
            'value' => $valueCents,
            'today_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'quantity_days' => $quantityDays,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
