<?php

namespace App\Exports;

use App\Exports\Sheets\Invoices;
use App\Exports\Sheets\InvoicesDiscounts;
use App\Exports\Sheets\InvoicesPaymentMethods;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InvoiceExport implements WithMultipleSheets, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new Invoices($this->data);
        $sheets[] = new InvoicesPaymentMethods($this->data);
        $sheets[] = new InvoicesDiscounts($this->data);
        return $sheets;
    }

}
