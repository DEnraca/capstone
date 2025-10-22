<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $filePath;

    /**
     * Create a new message instance.
     */
    public function __construct($appointment_id, $filePath)
    {

        // $this->data = $data;
        $app = Appointment::find(3);
        $data = [];

        $data = [
            'name' => $app->patient->getFullname(),
        ];
        $this->data = $data;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Diagnostic Test Results')
            ->view('emails.test_result_mail')
            ->with('data', $this->data)
            ->attach($this->filePath, [
                'as' => 'TestResults.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
