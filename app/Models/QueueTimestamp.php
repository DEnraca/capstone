<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueueTimestamp extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'queue_timestamps';

    protected $fillable = [
        'queue_checklists',
        'queue_statuses',
        'first_called_at',
        'recalled_last_at',
        'completed_at',
    ];

    public function checklist(): BelongsTo
    {
        return $this->belongsTo(QueueChecklist::class,'queue_checklists');
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class,'station_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(QueueStatus::class,'queue_statuses');
    }


    public function latest()
    {
        return $this->orderBy('id','desc')->first();
    }


    //
}
