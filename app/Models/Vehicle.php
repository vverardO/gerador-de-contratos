<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'manufacturing_model',
        'license_plate',
        'chassis',
        'renavam',
        'vehicle_model_id',
        'vehicle_owner_id',
    ];

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function vehicleOwner(): BelongsTo
    {
        return $this->belongsTo(VehicleOwner::class);
    }

    protected function displayName(): Attribute
    {
        return Attribute::get(fn () => $this->vehicleModel
            ? $this->vehicleModel->vehicleBrand->title.' - '.$this->vehicleModel->title
            : '');
    }
}
