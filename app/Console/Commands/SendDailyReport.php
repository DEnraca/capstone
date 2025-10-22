<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReportMail;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;

class SendDailyReport extends Command
{
    protected $signature = 'email:daily-report';
    protected $description = 'Send daily report email';

    public function handle()
    {
        $data = [
            'message' => 'Here is your daily summary report.',
        ];
        try {
            $appointment = Appointment::whereDate('appointment_date', now())->get();
            foreach ($appointment as $app) {
                Mail::to('example@example.com')->send(new AppointmentReminder($app->id));
            }
            $this->info('Daily report email sent successfully!');
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to send email. Please try again later.']);
        }


        // $appointment = Appointment::whereDate('appointment_date', now()->addDays(3))->get(); // date today
        // foreach ($appointment as $app) {
        //     Mail::to('example@example.com')->send(new AppointmentReminder($app->id));
        // }

        // $appointment = Appointment::whereDate('appointment_date', now()->addDays(5))->get(); // date today
        // foreach ($appointment as $app) {
        //     Mail::to('example@example.com')->send(new AppointmentReminder($app->id));
        // }

    }
}
