<?php

namespace App\Console\Commands;

use App\Mail\AppointmentConfirmation; // or whatever mail you use
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReportMail;

class SendDailyConfirmation extends Command
{
    protected $signature = 'email:appointment-confirmation';
    protected $description = 'Send daily report email';

    public function handle()
    {
        $data = [
            'message' => 'Here is your daily summary report.',
        ];

        Mail::to('example@example.com')->send(new AppointmentConfirmation($data));

        $this->info('Daily report email sent successfully!');
    }
}
