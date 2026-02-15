<?php

namespace App\Enums;

enum ContractType: string
{
    case OCCASIONAL_RENTAL = 'occasional_rental';
    case APP_RENTAL = 'app_rental';
    case PERSONALIZADO = 'personalizado';

    public function label(): string
    {
        return match ($this) {
            self::OCCASIONAL_RENTAL => 'Eventual',
            self::APP_RENTAL => 'Aplicativo',
            self::PERSONALIZADO => 'Personalizado',
        };
    }
}
