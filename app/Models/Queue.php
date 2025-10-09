<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Queue extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'queues';

    protected $fillable = [
        'queue_number',
        'priority_type_id',
        'queue_type_id',
        'patient_id',
        'appointment_id',
        'status_id',
        'queue_start',
        'queue_end',
        'created_by',
    ];

    protected static function booted()
    {
        static::creating(function (PatientInformation $model) {
            // Your logic to be executed before a new model is created
            // For example, setting a default value or performing validation
            $model->pat_id = generatePatID();
        });
    }

    public function priorityType(): BelongsTo
    {
        return $this->belongsTo(PriorityType::class,'priority_type_id');
    }

    public function queueType(): BelongsTo
    {
        return $this->belongsTo(QueueType::class,'queue_type_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientInformation::class,'patient_id');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class,'appointment_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(QueueStatus::class,'status_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'confimed_by');
    }
}
