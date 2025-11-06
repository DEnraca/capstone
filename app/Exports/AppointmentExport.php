<?php

namespace App\Exports;

use App\Exports\Sheets\AppointmentSummary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AppointmentExport implements WithMultipleSheets, ShouldAutoSize
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new AppointmentSummary($this->data);
        return $sheets;
    }
}
