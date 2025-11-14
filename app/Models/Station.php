<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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

    public function scopeActive($query){

        return $query->where('active',1);

    }

    public function patientTests(): HasManyThrough
    {
        return $this->hasManyThrough(
            PatientTest::class,  // final model
            Service::class,      // intermediate model
            'station_id',        // Foreign key on services table
            'service_id',        // Foreign key on patient_tests table
            'id',                // Local key on stations table
            'id'                 // Local key on services table
        );
    }

}
