<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PatientInformation extends Model
{

    use HasFactory;

    protected $table = 'patient_information';

    protected $fillable = [
        'pat_id',
        'last_name',
        'first_name',
        'middle_name',
        'mobile',
        'dob',
        'user_id',
        'address_id',
        'gender',
        'civil_status',
    ];

    protected static function booted()
    {
        static::creating(function (PatientInformation $model) {
            // Your logic to be executed before a new model is created
            // For example, setting a default value or performing validation
            $model->pat_id = generatePatID();
        });
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class,'address_id');
    }

    public function civilStatus(): HasMany
    {
        return $this->hasMany(CivilStatus::class,'civil_status');
    }

    public function Gender(): HasMany
    {
        return $this->hasMany(Gender::class,'gender');
    }
    
    public function getFullname()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

}
