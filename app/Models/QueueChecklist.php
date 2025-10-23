<?php

namespace App\Models;

use Carbon\Carbon;
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
        'latest_status',
        'appointment_id',
        'updated_by',
        'sort_order',
        'is_default_step',
        'step_name',
        'is_current'
    ];

    public function queue(): BelongsTo
    {
        return $this->belongsTo(Queue::class,'queue_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(QueueStatus::class,'latest_status');
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class,'station_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'updated_by');
    }

    public function scopeCurrent($query)
    {
        return $query->where('is_current',true);
    }

    public function scopePending($query)
    {
        return $query->where('latest_status', 1);
    }

    public function scopeProcessing($query)
    {
        return $query->where('latest_status', 2);
    }

    public function scopeCompleted($query)
    {
        return $query->where('latest_status', 4);
    }

    public function scopeToday($query){
        return $query->whereHas('queue', function ($q) {
            $q->whereDate('queues.created_at', Carbon::today());
        });
    }



    public function scopeApplySorting($query)
    {
        return $query
            ->leftJoin('queues', 'queues.id', '=', 'queue_checklists.queue_id')
            ->orderBy('sort_order', 'asc')
            ->orderByRaw("
                CASE
                    WHEN queues.queue_type_id = 2 THEN 2  -- walk-ins last
                    ELSE 1                               -- appointment and priority first
                END
            ")
            ->orderBy('queues.created_at', 'asc')
            ->select('queue_checklists.*'); // prevent column conflicts
    }

}
