<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QueueStatus extends Model
{
    protected $table = 'queue_statuses';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function queues(): HasMany
    {
        return $this->hasMany(Queue::class,);
    }
    //
}
