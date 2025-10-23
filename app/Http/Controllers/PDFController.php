<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
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


    public function sample(){

        if (true) {

            $data = [
                'department' => 'Test Equipment',
                'date' => now()->format('F d, Y'),
                'pms_no' => 'PM-2025-0001',
                'eq_name' => 'Ultrasound Machine',
                'manufacturer' => 'ABR Medtech Co.',
                'model' => 'X21233',
                'serial_no' => 'SN-1234122',

                'pm_freq' => '2025-02-21112',
                'procedures' => [],
                'lastpm_perform' =>  now()->format('F d, Y'),

                'parts' => [],
                'missingAndReplace' => [],

                'technician' => 'Jane Doe',
                'client' => 'Jane Doe',
                'super_visor' => 'Jane Doe',
                'gsd' => 'Jane Doe',

                'created_at' => now()->format('F d, Y'),
            ]; //sample data

            $filename = 'Invoice.pdf';

            return PDF::loadView('pdf.sample_pdf',$data) //path of the blade file
                ->setOption('encoding', 'UTF-8')
                ->setOptions(['margin-left' => 5, 'margin-top' => 5, 'margin-right' => 10, 'margin-bottom' => 5]) // page margin setup
                ->setOption('enable-local-file-access', true)
                ->setOption('images', true) // adding of rendering as image
                ->stream($filename); // for pdf streaming
                // ->download($filename); //for pdf downloading
        }
        else
        {
            Notification::make()
                ->title('Invoice Generation Failed')
                ->body('File not found')
                ->danger()
                ->send();

            return redirect()->route('filament.resources.equipment-monitorings.index');
        }
    }
    //
}
