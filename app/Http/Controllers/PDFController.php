<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Exports\PatientInformationExport;
use App\Exports\TransactionSummaryExport;
use App\Models\Appointment;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\InvoiceHasPayment;
use App\Models\PatientInformation;
use App\Models\PaymentMethod;
use App\Models\Queue;
use App\Models\Report;
use App\Models\TestResult;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Support\Str;

class PDFController extends Controller
{

    public function invoice($id){
        $invoice = Invoice::find($id);
        if ($invoice) {
            $patient = $invoice->patient();
            $add = $patient->address;
            $address =  getAddressDetails($add->region_id, $add->province_id, $add->city_id, $add->barangay_id);
            $data = [
                'invoice_number' => $invoice->invoice_number,
                'patient_number' => $patient->pat_id,
                'patient_name' => $patient->getFullname(),
                'is_paid' => $invoice->is_paid,
                'date_issued' => $invoice->created_at,
                'sub_total' =>number_format($invoice->total_amount,2),
                'discount_val' =>number_format($invoice->total_discount,2),
                'grand_total' =>number_format($invoice->grand_total,2),
                'discount' => $invoice->discount?->name ?? null,
                'date_issued' => $invoice->created_at,
                'emp' => $invoice->createdBy?->getFullname() ?? null,
                'emp_id' => $invoice->createdBy?->emp_id ?? null,
                'services' => $invoice->transaction->tests,
                'address' => "{$add->house_address} {$address['barangay']} {$address['city']} {$address['province']} {$address['region']} "
            ];
            // dd($data);

            $filename = $patient->getFullname().' Invoice.pdf';
            return PDF::loadView('pdf.invoice', $data)
                ->setOption('encoding', 'UTF-8')
                ->setOption('header-html', view('pdf.header')->render())
                ->setOption('footer-html', view('pdf.footer')->render())
                ->setOptions(['margin-left' => 5, 'margin-top' => 25, 'margin-right' => 10, 'margin-bottom' => 10])
                ->setOption('enable-local-file-access', true)
                ->setOption('images', true)
                ->stream($filename);
        }
        else
        {
            Notification::make()
                ->title('Invoice Generation Failed')
                ->body('File not found')
                ->danger()
                ->send();

            return redirect()->route('filament.resources.transactions.index');
        }
    }


    public function generateReport($id){
        $report = Report::find($id);

        $from = Carbon::parse($report->from)->startOfDay();
        $to = Carbon::parse($report->to)->endOfDay();
        $range_name = "{$from->format('F-d-Y')}-{$to->format('F-d-Y')}";

        $test = collect([
            'range' => "{$from->format('F d, Y')} to {$to->format('F d, Y')}",
            'created_by' => $report->generatedBy?->getFullname() ?? 'N/A',
            'created_at' => $report->created_at->format('F d, Y'),
        ]);

        if($report){

            if($report->report_kind_id == 1){ // patient info
                $pat_infos = PatientInformation::whereBetween('created_at',[$from, $to])->orderBy('created_at','asc')->get();
                $filename = "{$range_name} Patient Summary";
                $data = $this->patientInfomationreport($pat_infos);
                $data = $data->merge($test);

                if($report->type == 1){ // excel;
                    return Excel::download(new PatientInformationExport($data), "{$filename}.xlsx");
                }
                else{ //pdf
                    return $this->exportPDF('exports.pdf.patient_summary', $data, $filename);
                }
            }

            if($report->report_kind_id == 2){ // Transaction
                $transactions = Transaction::whereBetween('created_at',[$from, $to])->orderBy('created_at','asc')->get();
                $filename = "{$range_name} Transaction Summary";
                $data = $this->transactionReport($transactions);
                $data = $data->merge($test);

                if($report->type == 1){ // excel;
                    return Excel::download(new TransactionSummaryExport($data), "{$filename}.xlsx");
                }
                else{ //pdf
                    return $this->exportPDF('exports.pdf.transactions', $data, $filename);
                }
            }
            if($report->report_kind_id == 3){
                $invoices = Invoice::whereBetween('created_at',[$from, $to])->get();
                $filename = "{$range_name} Invoice Summary";
                $data = $this->invoicesReport($invoices);
                $data = $data->merge($test);

                if($report->type == 1){ // excel;
                    return Excel::download(new InvoiceExport($data), "{$filename}.xlsx");
                }
                else{ //pdf
                    return $this->exportPDF('exports.pdf.invoice_summary', $data, $filename);
                }
            }

            if($report->report_kind_id == 4){ //appointments
                $appointments = Appointment::whereBetween('appointment_date',[$from, $to])->get();
                $filename = "{$range_name} Appointment Summary";
                $data = $this->appointmentReport($appointments);
                $data = $data->merge($test);

                if($report->type == 1){ // excel;
                    return Excel::download(new InvoiceExport($data), "{$filename}.xlsx");
                }
                else{ //pdf
                    return $this->exportPDF('exports.pdf.appointments', $data, $filename);
                }
            }
        }
        else
        {
            Notification::make()
                ->title('Report Generation Failed')
                ->body('File not found')
                ->danger()
                ->send();

            return redirect()->route('filament.resources.reports.index');
        }
    }

    public function exportPDF($path, $data, $filename){

        return PDF::loadView($path, $data)
                    ->setOption('encoding', 'UTF-8')
                    ->setOption('header-html', view('pdf.header')->render())
                    ->setOption('footer-html', view('pdf.footer')->render())
                    ->setOptions(['margin-left' => 5, 'margin-top' => 25, 'margin-right' => 10, 'margin-bottom' => 10])
                    ->setOption('enable-local-file-access', true)
                    ->setOption('images', true)
                    ->stream($filename.'.pdf');

    }

    public function invoicesReport($record){
        $data = [];
        $invoices = [];
        $health_card = PaymentMethod::where('is_health_card', 1)->get()->pluck('id');
        foreach($record as $invoice){
            $invoices[] = [
                'invoice_number' => $invoice->invoice_number,
                'transaction_id' => $invoice->transaction->code,
                'name' => $invoice->transaction?->patient->getFullname() ?? null,
                'amount_paid' => number_format($invoice->amount_paid,2),
                'grand_total' => number_format($invoice->grand_total,2),
                'discounts' => number_format($invoice?->total_discount,2),

                'health_card' => number_format($invoice?->payments->whereIn('payment_method_id', $health_card)->sum('amount_paid'),2),
                'cash' => number_format($invoice?->payments->where('payment_method_id', 1)->sum('amount_paid'),2),
                'other' => number_format($invoice?->payments->where('payment_method_id', '!=', 1)->whereNotIn('payment_method_id', $health_card)->sum('amount_paid'),2),

                'is_paid' => $invoice->is_paid,
                'created_by' => $invoice->createdBy?->getFullname() ?? null,
                'date_time' => $invoice->created_at->format('F d Y H:i A'),
            ];
        }


        $invoices = collect($invoices);

        $payment_methods = PaymentMethod::orderBy('id','asc')->get();
        $method = [];
        foreach($payment_methods as $paymed){
            $totals = InvoiceHasPayment::where('payment_method_id', $paymed->id)->whereIn('invoice_id',$record->pluck('id'));
            $method[] = [
                'name' => $paymed->name,
                'total' => number_format($totals->sum('amount_paid'),2),
                'count' => $totals->count(),
            ];
        }


        $discount_record = Discount::orderBy('id','asc')->get();
        $discount = [];
        foreach($discount_record as $disc){
            $hehe = $record->where('discount_id',$disc->id);
            $discount[] = [
                'name' => $disc->name,
                'total' => number_format($hehe->sum('total_discount'),2),
                'count' => $hehe->count(),
            ];
        }

        $total = [
            'discount' => $invoices->sum('discounts'),
            'amount_paid' => $invoices->sum('amount_paid'),
            'grand_total' => $invoices->sum('grand_total'),
            'cash' => $invoices->sum('cash'),
            'health_card' => $invoices->sum('health_card'),
        ];

        $data = [
            'count' => $invoices->count($invoices),
            'invoices' => $invoices,
            'total' => $total,
            'payment_methods' => collect($method),
            'discounts' => $discount,
        ];

        return collect($data);

    }


    public function patientInfomationreport($record){
        $data = [];
        $patients = [];
        foreach($record as $patient){
            $add = $patient->address;
            $address =  getAddressDetails($add->region_id, $add->province_id, $add->city_id, $add->barangay_id);

            $patients[] = [
                'pat_id' => $patient->pat_id,
                'last_name' => $patient->last_name,
                'first_name' => $patient->first_name,
                'middle_name' => $patient->middle_name,

                'email' => $patient->user->email,
                'mobile' => "+63 ".$patient->mobile,
                'address' => Str::limit( "{$add->house_address} {$address['barangay']} {$address['city']} {$address['province']} {$address['region']} ", 30),

                'gender' => $patient->patient_gender->name,
                'dob' => Carbon::parse($patient->dob)->format('F d, Y'),
                'civil_status' => $patient->civilStatus->name,

                'age' => Carbon::parse($patient->dob)->age.' yr/s old.',
                'date_joined' => $patient->created_at->format('F d, Y'),
            ];
        }

        $patients = collect($patients);
        $data = [
            'patients' => $patients
        ];

        return collect($data);

    }


    public function transactionReport($record){
        $data = [];
        $transactions = [];
        foreach($record as $transaction){
            $tests = $transaction->tests->map( function ($q) {
                return  "{$q->service->code} - {$q->service->name}";
            });
            $transactions[] = [
                'code' => $transaction->code,
                'queue_number' => $transaction->queue->queue_number,
                'patient_id' => $transaction->patient->pat_id,
                'patient_name' => $transaction->patient->getFullname(),
                'created_at' => Carbon::parse($transaction->dob)->format('F d, Y'),
                'created_by' =>  $transaction->createdBy->getFullname(),
                'remarks' => $transaction->remarks,
                'billing_id' => $transaction?->billing?->invoice_number ?? null,
                'tests' => $tests,
            ];
        }

        $transactions = collect($transactions);
        $data = [
            'transactions' => $transactions
        ];

        return collect($data);

    }


    public function appointmentReport($record){
        $data = [];
        $appointments = [];
        foreach($record as $appointment){
            // dd($appointment->confirmedBy);

            $tests = $appointment->services->map( function ($q) {
                return  "{$q->code} - {$q->name}";
            });
            $formattedTime = 'N/A';
            if($appointment->appointment_time){
                $formattedTime = Carbon::createFromFormat('H:i:s', $appointment->appointment_time)->format('g:i A');
            }

            $is_queud = 'No';

            if(Queue::where('appointment_id',$appointment->id)->first()){
                $is_queud = 'Yes';
            }

            $appointments[] = [
                'date' => Carbon::parse($appointment->appointment_date)->format('F d, Y'),
                'time' => $formattedTime,
                'status' => $appointment->status_name(),
                'patient_id' => $appointment->patient->pat_id,
                'patient' => $appointment->patient->getFullname(),
                'booked_services' => $tests,
                'approve_by' =>  $appointment->confirmedBy?->employee?->getFullname() ?? null,
                'is_queued' => $is_queud,
                'created_at' => Carbon::parse($appointment->created_at)->format('F d, Y')
            ];
        }

        $appointments = collect($appointments);
        $data = [
            'appointments' => $appointments
        ];

        return collect($data);

    }

    public function test_result(TestResult $result){
        if(!$result){
            Notification::make()
                ->title('Test Result Generation Failed')
                ->body('No record found')
                ->danger()
                ->send();
            return redirect()->route('filament.admin.pages.dashboard');
        }

        $service = $result->test->service;
        $patient = $result->test->transaction->patient;
        $transaction = $result->test->transaction;


        $add = $patient->address;
        $address =  getAddressDetails($add->region_id, $add->province_id, $add->city_id, $add->barangay_id);



        $attachments = $result->getMedia('result_attachments')->map(function ($media) {
            return $media->getFullUrl();
        })->toArray();


        $signatories = $result->signatories->map(function ($signature) {
            return [
                'signature' => $signature->getMedia('e_signatures')?->first()?->getFullUrl() ?? null,
                'name' => $signature->getFullname(),
                'position' => $signature->position->name ?? null,
            ];
        })->toArray();
        $result = [
            'address' => Str::limit( "{$add->house_address} {$address['barangay']} {$address['city']} {$address['province']} ", 150),
            'service_name' => $service->name,
            'service_code' => $service->code,
            'date' => Carbon::parse($result->created_at)->format('F d, Y'),
            'patient_name' => $patient->getFullname(),
            'code' => $transaction->code,
            'age' => Carbon::parse($patient->dob)->age,
            'pat_id' => $patient->pat_id,
            'gender' => $patient->patient_gender->name,
            'result' => ucwords($result->result->name),
            'impressions' => nl2br($result->impressions),
            'attachments' => $attachments,
            'signatories' => $signatories,

        ];


        return PDF::loadView('pdf.result', $result)
            ->setOption('encoding', 'UTF-8')
            ->setOption('header-html', view('pdf.header')->render())
            ->setOption('footer-html', view('pdf.footer')->render())
            ->setOptions(['margin-left' => 5, 'margin-top' => 25, 'margin-right' => 10, 'margin-bottom' => 10])
            ->setOption('enable-local-file-access', true)
            ->setOption('images', true)
            ->stream($patient->getFullname().$service->name.'test-result.pdf');

    }

}
