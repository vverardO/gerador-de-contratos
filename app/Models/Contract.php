<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
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
        'value_in_words',
        'today_date',
    ];
}
