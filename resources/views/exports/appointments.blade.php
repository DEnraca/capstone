@extends('exports.component.excel_layout')
@section('content')
    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <!-- First row: main group headers -->
            <tr>
                <th style="background-color: #a6a6a6; border: 1px solid black; padding: 8px; text-align: center;">Date</th>
                <th style="background-color: #a6a6a6; border: 1px solid black; padding: 8px; text-align: center;">Time</th>
                <th style="background-color: #a6a6a6; border: 1px solid black; padding: 8px; text-align: center;">Status</th>

                <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Patient ID</th>
                <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Patient Name</th>
                <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Booked Services</th>
                <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Approved By</th>
                <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Queued?</th>
                <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Date Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr style="background-color: white;">
                    <td style="border: 1px solid black; padding: 8px;">{{$appointment['date']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$appointment['time']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$appointment['status']}}</td>

                    <td style="border: 1px solid black; padding: 8px;">{{$appointment['patient_id']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$appointment['patient']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">
                        @foreach ($appointment['booked_services'] as $test )
                            <p>{{$test}}</p>
                        @endforeach
                    </td>
                    <td style="border: 1px solid black; padding: 8px;">{{$appointment['approve_by']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$appointment['is_queued']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$appointment['created_at']}}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
