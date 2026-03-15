<?php

namespace App\Jobs;

use App\Http\Controllers\PDFController;
use App\Mail\PatientResultsMail;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class SendTransactionResultsEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    public $transactionId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $transaction)
    {
        //
        $this->transactionId = $transaction;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $transaction = Transaction::with('tests', 'patient')->find($this->transactionId);

        if (!$transaction || !$transaction?->patient?->user?->email) {

            \Log::warning("Transaction {$transaction->id} has no patient or email.");
            return;
        }

        $attachments = [];
        $invoice = $transaction->billing;

        if($invoice){
            $filename = Str::slug($invoice->patient()->last_name) . '-invoice.pdf';
            $path = storage_path("app/public/results/{$filename}");
            Storage::disk('public')->makeDirectory('results');

            // Use the controller to build PDF and save
            app(PDFController::class)->buildInvoiceReport($invoice, $path);

            $attachments[] = $path;
        }

        foreach ($transaction->tests as $test) {
            $result = $test->testResult;
            if (!$result) continue;

            $filename = Str::slug($invoice->patient()->last_name.$result->test->service->name) . '-result.pdf';
            $path = storage_path("app/public/results/{$filename}");
            Storage::disk('public')->makeDirectory('results');

            // Use the controller to build PDF and save
            app(PDFController::class)->buildResultPdf($result, $path);

            $attachments[] = $path;
        }

        // Dispatch email
        Mail::to($transaction?->patient->user?->email)
            ->send(new PatientResultsMail($transaction, $attachments));

        // Optional: delete temporary PDFs
        foreach ($attachments as $file) {
            if (file_exists($file)) unlink($file);
        }
    }
}
