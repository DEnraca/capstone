@extends('exports.pdf.layout')

@section('content')
    <div class="row" style="margin-top: 25px">
        @include('exports.transactions')
    </div>
@endsection

