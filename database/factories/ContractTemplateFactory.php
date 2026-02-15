<?php

namespace Database\Factories;

use App\Models\ContractTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractTemplateFactory extends Factory
{
    protected $model = ContractTemplate::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'template' => '<p>'.fake()->paragraphs(3, true).'</p>',
        ];
    }
}
