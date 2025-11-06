<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class Invoices implements FromView, WithTitle, ShouldAutoSize
{

    public $invoices;
    public $totals;
    public $data;
    public function __construct($invoices)
    {
        $this->invoices = $invoices['invoices'];
        $this->totals = $invoices['total'];
        $this->data = $invoices;

    }
    public function view(): View
    {
        return view('exports.invoices', [
            'invoices' => $this->invoices,
            'total' => $this->totals,
            'data' =>  $this->data,
            'type' => 'excel'
        ]);
    }


    public function title(): string
    {
        return 'Transactions';
    }

}
