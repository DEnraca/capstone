@extends('exports.component.excel_layout')
@section('content')
    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <caption style="border: 1px solid black; width: 100%; padding: 1em 0; background-color: white; color: black;">
            <b>Invoices for dates: January 2, to January 25, 2026</b>
        </caption>
        <thead>
            <!-- First row: main group headers -->
            <tr>
                <th style="background-color: #a6a6a6; border: 1px solid black; padding: 8px; text-align: center;">Name</th>
                <th style="background-color: #a6a6a6; border: 1px solid black; padding: 8px; text-align: center;">Count</th>
                <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($paymentMethods as $pm)
            <tr style="background-color: white;">
                <td style="border: 1px solid black; padding: 8px;">{{$pm['name']}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$pm['count']}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$pm['total']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
