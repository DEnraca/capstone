@extends('exports.component.excel_layout')
@section('content')

    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <!-- First row: main group headers -->
            <tr>
                <th style="background-color: #a6a6a6; border: 1px solid black; padding: 8px; text-align: center;">Name</th>
                <th style="background-color: #a6a6a6; border: 1px solid black; padding: 8px; text-align: center;">Count</th>
                <th style="background-color: #92d050; border: 1px solid black; padding: 8px; text-align: center;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($discounts as $discount)
                <tr style="background-color: white;">
                    <td style="border: 1px solid black; padding: 8px;">{{$discount['name']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$discount['count']}}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{$discount['total']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection


