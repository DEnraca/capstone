<?php

namespace App\Exports\Sheets;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class AppointmentSummary implements  FromView, WithTitle, ShouldAutoSize
{
    public $appointments;
    public $data;
    public function __construct($appointments)
    {
        $this->appointments = $appointments['appointments'];
        $this->data = $appointments;
    }
    public function view(): View
    {
        return view('exports.appointments', [
            'appointments' => $this->appointments,
            'type' => 'excel',
            'data' =>  $this->data
        ]);
    }

    public function title(): string
    {
        return 'Appointment Records';
    }
}
