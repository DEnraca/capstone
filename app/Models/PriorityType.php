<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PriorityType extends Model
{
    protected $table = 'priority_type';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function queues(): HasMany
    {
        return $this->hasMany(Queue::class,);
    }
}
