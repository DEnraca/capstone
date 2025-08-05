<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentReminder extends Model
{
    protected $timestamp = false;

    use HasFactory;

    protected $table = 'appointment_reminders';

    protected $fillable = [
        'appointment_id',
        'reminder_sent_at',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class,);
    }
}
