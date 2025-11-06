@extends('exports.component.excel_layout')
@section('content')
    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <!-- First row: main group headers -->
            <tr>
                <th style="background-color: #a6a6a6; border: 1px solid black; padding: 8px; text-align: center;">Patient ID</th>
                <th style="background-color: #a6a6a6; border: 1px solid black; padding: 8px; text-align: center;">Last Name</th>
                <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">First Name</th>
                <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Middle Name</th>
                <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Email</th>
                <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Mobile</th>
                <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Address</th>
                <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Gender</th>
                <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Birthday</th>
                <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Civil Status</th>
                <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Age</th>
                <th style="background-color: #ffc000; border: 1px solid black; padding: 8px; text-align: center;">Date Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr style="background-color: white;">
                    <td style="border: 1px solid black; padding: 8px;">{{$patient['pat_id']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$patient['last_name']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$patient['first_name']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$patient['middle_name']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$patient['email']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$patient['mobile']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$patient['address']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$patient['gender']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$patient['dob']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$patient['civil_status']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$patient['age']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$patient['date_joined']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection