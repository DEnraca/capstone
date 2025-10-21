<?php

namespace App\Mail;

use App\Models\Appointment;
use App\Models\PatientInformation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($appointment_Id) //1
    {
        $app = Appointment::find($appointment_Id); //
        // name
        // appointment date 
        // appointment time

        $data = [];
        $data = [
            'date' => $app->appointment_date,
            'time' => $app->appointment_time,
            'name' => $app->patient->getFullname(),
            'pat_id' => $app->patient->pat_id,
        ];

        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Daily Report')
            ->view('emails.appointment_reminder', $this->data);
    }
}
