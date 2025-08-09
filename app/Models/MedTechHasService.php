<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedTechHasService extends Model
{
    use HasFactory;

    protected $table = 'med_tech_has_services';

    protected $fillable = [
        'med_tech_id',
        'service_id',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'med_tech_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class,'service_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class,'med_tech_id');
    }
}
