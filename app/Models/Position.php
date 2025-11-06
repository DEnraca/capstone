<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{

    use HasFactory;
    use SoftDeletes;


    protected $table = 'positions';

    protected $fillable = [
        'name',
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class,'position_id');
    }

}
