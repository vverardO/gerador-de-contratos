<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'document',
        'driver_license',
        'driver_license_expiration',
    ];

    protected $casts = [
        'driver_license_expiration' => 'date',
    ];

    protected function documentFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->document),
        );
    }

    public function address()
    {
        return $this->hasOne(DriverAddress::class);
    }
}
