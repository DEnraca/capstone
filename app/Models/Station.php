<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Station extends Model
{

    use HasFactory;

    protected $table = 'stations';

    protected $fillable = [
        'name',
        'active',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class,'station_id');
    }
}
