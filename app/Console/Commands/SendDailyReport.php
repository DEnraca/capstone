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
        try {
            $appointment = Appointment::whereDate('appointment_date', now())->get();
            if(count($appointment) <= 0){
                $this->info('No appointments for today.');
                return;
            }
            else{
                foreach ($appointment as $app) {
                    Mail::to($app->patient->user->email)->queue(new AppointmentReminder($app->id));

                    $this->info('Reminder has been sent on appointments! Scheduled for today.');
                }
            }

            $appointment = Appointment::whereDate('appointment_date', now()->addDays(3))->get(); // date today

            foreach ($appointment as $app) {
                Mail::to($app->patient->user->email)->send(new AppointmentReminder($app->id));
                $this->info('Reminder has been sent on appointments! Scheduled on 3rd day from now.');
            }

            $appointment = Appointment::whereDate('appointment_date', now()->addDays(5))->get(); // date today

            foreach ($appointment as $app) {
                Mail::to($app->patient->user->email)->send(new AppointmentReminder($app->id));
                $this->info('Reminder has been sent on appointments! Scheduled on 5th day from now.');
            }


        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to send email. Please try again later.']);
        }


    }
}
