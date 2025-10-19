<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueueCall extends Model
{
    protected $table = 'queue_calls';

    public $timestamps = false;

    protected $fillable = [
        'queue_checklist',
        'is_called',
        'should_remove',
    ];

    public function checklist(): BelongsTo
    {
        return $this->belongsTo(QueueChecklist::class,'queue_checklist');
    }

}
