<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientInformation extends Model
{
    use SoftDeletes;

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

    public function civilStatus(): BelongsTo
    {
        return $this->belongsTo(CivilStatus::class,'civil_status');
    }

    public function patient_gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class,'gender');
    }

    public function getFullname()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

}
