<?php

namespace Database\Factories;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = fake()->numberBetween(2020, 2024);
        $modelYear = $year + 1;
        $value = fake()->randomFloat(2, 50, 500);

        $vehicles = [
            'Chevrolet Onix',
            'Volkswagen Gol',
            'Fiat Uno',
            'Ford Ka',
            'Renault Kwid',
            'Hyundai HB20',
            'Toyota Corolla',
            'Honda Civic',
            'Chevrolet Prisma',
            'Volkswagen Voyage',
        ];

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

        $months = [
            'janeiro',
            'fevereiro',
            'março',
            'abril',
            'maio',
            'junho',
            'julho',
            'agosto',
            'setembro',
            'outubro',
            'novembro',
            'dezembro',
        ];

        $day = fake()->numberBetween(1, 28);
        $month = fake()->randomElement($months);
        $currentYear = date('Y');

        return [
            'type' => fake()->randomElement([ContractType::OCCASIONAL_RENTAL, ContractType::APP_RENTAL]),
            'status' => fake()->randomElement([ContractStatus::DRAFT, ContractStatus::SENT, ContractStatus::SIGNED]),
            'driver_name' => fake()->name(),
            'driver_document' => fake()->numerify('###.###.###-##'),
            'driver_street' => fake()->randomElement($streets),
            'driver_number' => fake()->numberBetween(1, 9999),
            'driver_neighborhood' => fake()->randomElement($neighborhoods),
            'driver_zip_code' => fake()->numerify('#####-###'),
            'vehicle' => fake()->randomElement($vehicles),
            'manufacturing_model' => "{$year}/{$modelYear}",
            'license_plate' => fake()->regexify('[A-Z]{3}[0-9][A-Z][0-9]{2}'),
            'chassis' => fake()->regexify('[A-Z0-9]{17}'),
            'renavam' => fake()->numerify('###########'),
            'owner_name' => fake()->company(),
            'owner_document' => fake()->numerify('##.###.###/####-##'),
            'value' => number_format($value, 2, ',', '.'),
            'today_date' => "{$day} de {$month} de {$currentYear}",
            'quantity_days' => null,
            'start_date' => null,
            'end_date' => null,
        ];
    }

    public function occasionalRental(): static
    {
        $day = fake()->numberBetween(1, 28);
        $months = [
            'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho',
            'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro',
        ];
        $monthStart = fake()->randomElement($months);
        $currentYear = date('Y');
        $quantityDays = fake()->numberBetween(7, 30);
        $startDate = "{$day} de {$monthStart} de {$currentYear}";
        $endDate = fake()->dateTimeBetween('+1 week', '+1 month');
        $endDateFormatted = (int) $endDate->format('d').' de '.[
            'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho',
            'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro',
        ][(int) $endDate->format('n') - 1].' de '.$endDate->format('Y');

        return $this->state(fn () => [
            'type' => ContractType::OCCASIONAL_RENTAL,
            'quantity_days' => $quantityDays,
            'start_date' => $startDate,
            'end_date' => $endDateFormatted,
        ]);
    }
}
