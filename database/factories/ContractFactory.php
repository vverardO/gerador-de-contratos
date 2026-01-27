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

        $valueInWordsOptions = [
            'cinquenta reais',
            'setenta e cinco reais',
            'oitenta e nove reais e noventa centavos',
            'cem reais',
            'cento e cinquenta reais',
            'duzentos reais',
            'duzentos e cinquenta reais',
            'trezentos reais',
            'quatrocentos reais',
            'quinhentos reais',
        ];

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
            'status' => fake()->randomElement([ContractStatus::DRAFT, ContractStatus::SENT, ContractStatus::ASSIGNED]),
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
            'value_in_words' => fake()->randomElement($valueInWordsOptions),
            'today_date' => "{$day} de {$month} de {$currentYear}",
        ];
    }
}
