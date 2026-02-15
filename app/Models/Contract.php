<?php

namespace App\Models;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Models\ContractTemplate;
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
        'contract_template_id',
        'status',
        'driver_name',
        'driver_document',
        'driver_license',
        'driver_license_expiration',
        'driver_street',
        'driver_number',
        'driver_neighborhood',
        'driver_zip_code',
        'driver_city',
        'vehicle',
        'manufacturing_model',
        'license_plate',
        'chassis',
        'renavam',
        'owner_name',
        'owner_document',
        'value',
        'deposit',
        'today_date',
        'quantity_days',
        'start_date',
        'end_date',
    ];

    public function contractTemplate()
    {
        return $this->belongsTo(ContractTemplate::class);
    }

    protected $casts = [
        'type' => ContractType::class,
        'contract_template_id' => 'integer',
        'status' => ContractStatus::class,
        'value' => 'integer',
        'deposit' => 'integer',
        'driver_license_expiration' => 'date',
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

            $response = sprintf('%s reais', trim($reaisExtenso));

            if ($centavos > 0) {
                $response .= sprintf(' e %s centavos', trim($centavosExtenso));
            }

            return $response;
        });
    }

    protected function depositFormatted(): Attribute
    {
        return Attribute::get(function (): string {
            $cents = (int) ($this->attributes['deposit'] ?? 0);
            if ($cents === 0) {
                return '0,00';
            }

            return number_format($cents / 100, 2, ',', '.');
        });
    }

    protected function depositInWords(): Attribute
    {
        return Attribute::get(function (): string {
            $cents = (int) ($this->attributes['deposit'] ?? 0);
            if ($cents === 0) {
                return '';
            }

            $reais = (int) floor($cents / 100);
            $centavos = $cents % 100;

            $formatter = new NumberFormatter('pt_BR', NumberFormatter::SPELLOUT);

            $reaisExtenso = $formatter->format($reais);
            $centavosExtenso = $formatter->format($centavos);

            $response = sprintf('%s reais', trim($reaisExtenso));

            if ($centavos > 0) {
                $response .= sprintf(' e %s centavos', trim($centavosExtenso));
            }

            return $response;
        });
    }

    protected function isOnGoing(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->type === ContractType::OCCASIONAL_RENTAL) {
                    return $this->start_date <= now()->format('Y-m-d H:i:s') && $this->end_date >= now()->format('Y-m-d H:i:s');
                }

                return $this->status === ContractStatus::ON_GOING;
            },
        );
    }

    protected function isDone(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === ContractStatus::DONE,
        );
    }

    protected function isCancelled(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === ContractStatus::CANCELLED,
        );
    }

    protected function isDraft(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === ContractStatus::DRAFT,
        );
    }
}
