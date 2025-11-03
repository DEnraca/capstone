<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Invoice;
use App\Models\InvoiceHasPayment;
use App\Models\PaymentMethod;
use App\Models\Report;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use PDF;

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
                ->setOptions(['margin-left' => 5, 'margin-top' => 5, 'margin-right' => 10, 'margin-bottom' => 5])
                ->setOption('enable-local-file-access', true)
                ->setOption('images', true)
                ->download($filename);
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

        if($report){
            if($report->report_kind_id == 3){
                $invoices = Invoice::whereBetween('created_at',[$from, $to])->get();
                $this->invoicesReport($invoices);
                //invoices
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
            'discount' => $discount,
        ];

        return collect($data);

    }





    //
}
