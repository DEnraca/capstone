<?php

namespace App\Mail;

use App\Models\Appointment;
use App\Models\BookedServices;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($appointment_Id)
    {
        $app = Appointment::find($appointment_Id);

        $service = [];

        // Use the correct relationship name (plural)
        $booked_services = $app->services ?? collect();

        foreach ($booked_services as $book_service) {
            $status = 'Not Available';

            if ($book_service->pivot->status == 2) {
                $status = 'Approve';
            } elseif ($book_service->pivot->status == 4) {
                $status = 'Declined';
            }

            $service[] = [
                'name' => $book_service->name, // service name from Service model
                'status' => $status,
            ];
        }


        $data = [
            'date' => $app->appointment_date,
            'time' => $app->appointment_time,
            'name' => $app->patient->getFullname(),
            'pat_id' => $app->patient->pat_id,
            'gender' => $app->patient->patient_gender->id,
            'booked_service' => $service,
        ];

        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Appointment Confirmation')
            ->view('emails.appointment_confirmation')
            ->with('data', $this->data);
    }
}
