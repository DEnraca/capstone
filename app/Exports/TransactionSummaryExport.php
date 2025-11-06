<?php

namespace App\Exports;

use App\Exports\Sheets\TransactionSummary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TransactionSummaryExport implements WithMultipleSheets, ShouldAutoSize
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new TransactionSummary($this->data);
        return $sheets;
    }
}
