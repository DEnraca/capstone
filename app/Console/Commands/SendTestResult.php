<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestResultMail;

class SendTestResult extends Command
{
    protected $signature = 'email:test-result';
    protected $description = 'Send test result email to patient';

    public function handle()
    {

        $data = [
            'message' => 'Your test results are ready.',
        ];

        $filePath = public_path('images/frontend_asset/Group3.pdf');

        if (!file_exists($filePath)) {
            dd('File not found at: ' . $filePath);
        }
        Mail::to('patient@example.com')->send(new TestResultMail($data, $filePath));

        return "Email with attachment sent successfully!";
    }
}
