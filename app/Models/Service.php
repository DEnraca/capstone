<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'station_id',
        'department_id',
        'code',
        'name',
        'active',
        'description',
        'price',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class,);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class,);
    }

    public function appointments(): BelongsToMany
    {
        return $this->belongsToMany(Appointment::class, 'booked_services');
    }
    
    public function medTechs(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'med_tech_has_services', 'service_id', 'med_tech_id');
    }

}
