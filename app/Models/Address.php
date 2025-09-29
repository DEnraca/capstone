<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $table = 'addresses';
    public $timestamps = false;

    protected $fillable = [
        'region_id',
        'province_id',
        'city_id',
        'barangay_id',
        'house_address',
    ];
}
