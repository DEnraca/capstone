<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceHasPayment extends Model
{

    use HasFactory;
    protected $table = 'invoices_has_payment_method';

    public $timestamps = false;

    protected $fillable = [
        'payment_method_id',
        'reference_number',
        'amount_paid',
        'invoice_id',
    ];

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method_id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    //
}
