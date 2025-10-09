<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueueChecklist extends Model
{

    use HasFactory;

    public $timestamps = false;

    protected $table = 'queue_checklists';

    protected $fillable = [
        'queue_id',
        'station_id',
        'service_id',
        'queue_statuses',
        'appointment_id',
        'updated_by',
        'sort_order',
        'is_default_step',
        'step_name',
    ];

    public function queue(): BelongsTo
    {
        return $this->belongsTo(Queue::class,'queue_id');
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class,'station_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(QueueStatus::class,'queue_statuses');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'updated_by');
    }

}
