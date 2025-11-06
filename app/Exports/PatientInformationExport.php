<?php

namespace App\Exports;

use App\Exports\Sheets\PatientInformation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PatientInformationExport implements WithMultipleSheets, ShouldAutoSize
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new PatientInformation($this->data);
        return $sheets;
    }
}
