<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PatientResultsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $attachmentsData;

    /**
     * Create a new message instance.
     */
    public function __construct($transaction, $attachments)
    {
        $this->transaction = $transaction;
        $this->attachmentsData = $attachments;
    }


    public function build()
    {
        $mail = $this->subject('Your Laboratory Test Results')
            ->view('emails.patient-results')
            ->with([
                'transaction' => $this->transaction
            ]);

        // Attach stored PDFs
        foreach ($this->attachmentsData as $file) {
            $mail->attach($file);
        }

        return $mail;
    }
}
