@extends('exports.pdf.layout')

@section('content')
    <div class="row" style="margin-top: 25px">
        @include('exports.invoices')
    </div>
    <div class="row" style="margin-top: 25px">
        @include('exports.discounts')
    </div>
@endsection

