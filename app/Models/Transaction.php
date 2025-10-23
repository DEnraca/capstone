<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'queue_id',
        'patient_id',
        'created_by',
        'billing_id',
        'code',
        'remarks',
    ];

    protected $table = 'transactions';


    public function payments()
    {
        return $this->belongsToMany('invoices_has_payment_method')
            ->withPivot('status', 'approved_by');
    }


    public function queue(): BelongsTo
    {
        return $this->belongsTo(Queue::class,'queue_id');
    }


    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientInformation::class,'patient_id');
    }

    public function billing(): BelongsTo
    {
        return $this->belongsTo(Invoice::class,'billing_id');
    }

    public function tests(): HasMany
    {
        return $this->hasMany(PatientTest::class,'transaction_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'created_by');
    }
    //
}
