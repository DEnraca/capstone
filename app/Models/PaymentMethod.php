<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use SoftDeletes;
    protected $table = 'payment_methods';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'is_health_card',
    ];

}
