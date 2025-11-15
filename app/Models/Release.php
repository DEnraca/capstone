<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Release extends Model
{

    use SoftDeletes;

    protected $table = 'releases';

    protected $fillable = [
        'transaction_id',
        'released_by',
        'created_at'
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function releasedBy()
    {
        return $this->belongsTo(Employee::class, 'released_by');
    }
}
