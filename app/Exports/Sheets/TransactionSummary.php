<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;

class TransactionSummary implements FromView, WithTitle, ShouldAutoSize
{
    public $transactions;
    public $data;

    public function __construct($transaction)
    {
        $this->transactions = $transaction['transactions'];
        $this->data = $transaction;
    }
    public function view(): View
    {
        return view('exports.transactions', [
            'transactions' => $this->transactions,
            'type' => 'excel',
            'data' =>  $this->data
        ]);
    }

    public function title(): string
    {
        return 'Transaction Records';
    }
}
