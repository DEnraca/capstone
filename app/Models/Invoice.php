<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{

    use SoftDeletes;

    protected $table = 'invoices';

    protected $fillable = [
        'invoice_number',
        'transaction_id',
        'total_amount',
        'total_discount',
        'discount_id',
        'created_by',
        'is_paid',
        'amount_paid',
        'grand_total',
        'change'
    ];

    public function payments()
    {
        return $this->hasMany(InvoiceHasPayment::class, 'invoice_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }


    public function createdBy()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }


    public function patient()
    {
        return $this->transaction->patient;
    }


}
