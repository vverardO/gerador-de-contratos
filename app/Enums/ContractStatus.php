<?php

namespace App\Enums;

enum ContractStatus: string
{
    case DRAFT = 'draft';
    case ON_GOING = 'on_going';
    case DONE = 'done';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Rascunho',
            self::ON_GOING => 'Em andamento',
            self::DONE => 'Encerrado',
            self::CANCELLED => 'Cancelado',
        };
    }
}
