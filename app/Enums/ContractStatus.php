<?php

namespace App\Enums;

enum ContractStatus: string
{
    case DRAFT = 'draft';
    case SENT = 'sent';
    case SIGNED = 'signed';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Rascunho',
            self::SENT => 'Enviado',
            self::SIGNED => 'Assinado',
        };
    }
}
