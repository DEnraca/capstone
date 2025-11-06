@extends('exports.component.excel_layout')
@section('content')
<table style="width: 100%; border-collapse: collapse; font-size: 14px;">
    <thead>
        <!-- First row: main group headers -->
        <tr>
            <th style="background-color: #a6a6a6; border: 1px solid black; padding: 8px; text-align: center;">Invoice Number</th>
            <th style="background-color: #a6a6a6; border: 1px solid black; padding: 8px; text-align: center;">Transaction ID</th>
            <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Date Time</th>
            <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Name</th>
            <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Amount Paid</th>
            <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Discounts</th>
            <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Grand Total</th>
            <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Status</th>
            <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Transacted By</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $invoice)
            <tr style="background-color: white;">
                <td style="border: 1px solid black; padding: 8px;">{{$invoice['invoice_number']}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice['transaction_id']}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice['date_time']}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice['name']}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice['amount_paid']}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice['discounts']}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice['grand_total']}}</td>
                <td style="border: 1px solid black; padding: 8px; color:green;">@if ($invoice['is_paid']) PAID @endif</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice['created_by']}}</td>
            </tr>
        @endforeach
        <tr style="font-weight: 800" class="text-center">
            <td  style="border: 2px solid black;">Totals</td>
            <td  style="border: 2px solid black;"></td>
            <td  style="border: 2px solid black;" class="text-right">Patient Count:</td>
            <td  style="border: 2px solid black;" class="text-left">{{count($invoices)}}</td>
            <td  style="border: 2px solid black">₱ {{number_format($total['amount_paid'],2)}}</td>
            <td  style="border: 2px solid black;">₱ {{number_format($total['discount'],2)}}</td>
            <td  style="border: 2px solid black">₱ {{number_format($total['grand_total'],2)}}</td>
            <td  style="border: 2px solid black;"></td>
            <td  style="border: 2px solid black;"></td>
        </tr>
    </tbody>
</table>
@endsection