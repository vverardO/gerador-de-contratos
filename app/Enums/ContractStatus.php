<?php

namespace App\Enums;

enum ContractStatus: string
{
    case DRAFT = 'draft';
    case FINISHED = 'finished';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Rascunho',
            self::FINISHED => 'Finalizado',
        };
    }
}
