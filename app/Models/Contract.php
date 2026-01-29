<?php

namespace App\Models;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NumberFormatter;

class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'type',
        'status',
        'driver_name',
        'driver_document',
        'driver_street',
        'driver_number',
        'driver_neighborhood',
        'driver_zip_code',
        'vehicle',
        'manufacturing_model',
        'license_plate',
        'chassis',
        'renavam',
        'owner_name',
        'owner_document',
        'value',
        'today_date',
        'quantity_days',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'type' => ContractType::class,
        'status' => ContractStatus::class,
        'value' => 'integer',
    ];

    protected function valueFormatted(): Attribute
    {
        return Attribute::get(function (): string {
            $cents = (int) ($this->attributes['value'] ?? 0);
            if ($cents === 0) {
                return '0,00';
            }

            return number_format($cents / 100, 2, ',', '.');
        });
    }

    protected function valueInWords(): Attribute
    {
        return Attribute::get(function (): string {
            $cents = (int) ($this->attributes['value'] ?? 0);
            if ($cents === 0) {
                return '';
            }

            $reais = (int) floor($cents / 100);
            $centavos = $cents % 100;

            $formatter = new NumberFormatter('pt_BR', NumberFormatter::SPELLOUT);

            $reaisExtenso = $formatter->format($reais);
            $centavosExtenso = $formatter->format($centavos);

            return sprintf('%s reais com %s centavos', trim($reaisExtenso), trim($centavosExtenso));
        });
    }
}
