@extends('exports.component.excel_layout')
@section('content')
    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <!-- First row: main group headers -->
            <tr>
                <th style="background-color: #a6a6a6; border: 1px solid black; padding: 8px; text-align: center;">Transaction Code</th>
                <th style="background-color: #a6a6a6; border: 1px solid black; padding: 8px; text-align: center;">Queue #</th>
                <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Patient ID</th>
                <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Patient Name</th>
                <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Billing ID</th>
                <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Tests</th>
                <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Date</th>
                <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Remarks</th>
                <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Transacted By:</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr style="background-color: white;">
                    <td style="border: 1px solid black; padding: 8px;">{{$transaction['code']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$transaction['queue_number']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$transaction['patient_id']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$transaction['patient_name']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$transaction['billing_id']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">
                        @foreach ($transaction['tests'] as $test )
                            <p>{{$test}}</p>
                        @endforeach
                    </td>
                    <td style="border: 1px solid black; padding: 8px;">{{$transaction['created_at']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$transaction['remarks']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$transaction['created_by']}}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
