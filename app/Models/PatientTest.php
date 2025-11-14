<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PatientTest extends Model
{
    protected $table = 'patient_tests';

    public $timestamps = false;

    protected $fillable = [
        'transaction_id',
        'service_id',
        'status_id',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(QueueStatus::class, 'status_id');
    }


    public function testResult(): HasOne
    {
        return $this->hasOne(TestResult::class, 'result_id');
    }








}
