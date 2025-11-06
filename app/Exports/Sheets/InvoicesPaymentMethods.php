<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InvoicesPaymentMethods implements FromView, WithTitle, ShouldAutoSize
{
    public $paymentMethods;
    public $data;

    public function __construct($payment_method)
    {
        $this->paymentMethods = $payment_method['payment_methods'];
        $this->data = $payment_method;


    }
    public function view(): View
    {
        return view('exports.paymentMethod', [
            'paymentMethods' => $this->paymentMethods,
            'type' => 'excel',
            'data' =>  $this->data

        ]);
    }


    public function title(): string
    {
        return 'Payment Methods';
    }
}
