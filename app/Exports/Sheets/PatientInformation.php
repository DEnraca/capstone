<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PatientInformation implements FromView, WithTitle, ShouldAutoSize
{

    public $patients;
    public $data;

    public function __construct($patient_info)
    {
        $this->patients = $patient_info['patients'];
        $this->data = $patient_info;
    }
    public function view(): View
    {
        return view('exports.patients', [
            'patients' => $this->patients,
            'type' => 'excel',
            'data' =>  $this->data
        ]);
    }

    public function title(): string
    {
        return 'Patient Records';
    }

}
