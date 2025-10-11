<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QueueChecklist extends Model
{

    use HasFactory;

    public $timestamps = false;

    protected $table = 'queue_checklists';

    protected $fillable = [
        ' ',
        'station_id',
        'service_id',
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

    public function timestamps(): HasMany
    {
        return $this->hasMany(QueueTimestamp::class,'queue_checklists');
    }

    public function currentTS()
    {
        return $this->timestamps()->latest();
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'updated_by');
    }

    public function latestTimestamp()
    {
        return $this->hasOne(QueueTimestamp::class, 'queue_checklists')->latestOfMany();
    }

}
