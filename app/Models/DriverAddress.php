<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'postal_code',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
