<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{

    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'appointment_date',
        'appointment_time',
        'status',
        'patient_id',
        'message',
        'confimed_by'
    ];


    public function services()
    {
        return $this->belongsToMany(Service::class, 'booked_services')
            ->withPivot('status', 'approved_by');
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(AppointmentReminder::class,);
    }


    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'confimed_by');
    }


    // public function department(): BelongsTo
    // {
    //     return $this->belongsTo(Department::class,);
    // }

    // public function station(): BelongsTo
    // {
    //     return $this->belongsTo(Station::class,);
    // }

}
