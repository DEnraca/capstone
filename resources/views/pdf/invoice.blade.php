<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" href="{{base_path('public/css/bootstrap_trimmed.min.css')}}" />
    <style type="text/css">
        *{
            color: #000 !important;
        }
        html {
            height:100%;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin-left: 0.3in;
            margin-right: 0.3in;
        }
        h1 {
            font-size: 2em;
            font-weight: bold;
        }
        .vcenter {
            display: inline-block;
            vertical-align: middle;
            float: none;
        }
        .row {
            margin-bottom: 5px;
        }
        .page {
            page-break-after:always;
        }
        .overlay{
            position: relative;
        }
        .test{
            position: absolute;
            bottom: 1px; /* slight padding from bottom of image */
            left: 0;
            width: 100%;
            text-align: center;
        }
        .test p {
            line-height: 0.5;
        }
        .display{
            border-bottom: 1px solid black;
            text-align:center;
        }
        .no_margin{
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding: 0 !important;
        }
       .title{
            font-size: 1.8rem;
            font-weight: 800;
       }
        .display-text{
            height: 10px;
        }

    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="page">
            <div class="content" style="text-align: justify;">
                <div class="row" style="padding-top: 25px">
                    <div class="col-xs-7">
                        <p style="font-weight: 700; font-size:4.5rem"> INVOICE</p>
                        <p style="font-weight: 400; font-size:2rem"> #{{$invoice_number}}</p>
                        @if ($is_paid)
                            <p style="font-weight: 400; font-size:1.8rem; color: yellowgreen !important;">Paid</p>
                        @endif
                    </div>
                    <div class="col-xs-5 text-right">
                        <div class="col-xs-12">
                            <p class="title">Date Issued:</p>
                            <p>{{\Carbon\Carbon::parse($date_issued)->format('d M, Y')}} </p>
                        </div>
                        <div class="col-xs-12">
                            <p class="title">Issued to:</p>
                            <p>{{$patient_number}}</p>
                            <p>{{$patient_name}}</p>
                            <p>{{$address}}</p>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 20px">
                    <div style="padding-top:20px;" class="col-xs-12">
                        <table style="width: 100%; border-collapse: collapse;" border="1">
                            <thead style="background-color: #f29a11; text-transform::uppercase;">
                                <tr>
                                    <th style="width: 10%; text-align: center; padding: 10px;">No</th>
                                    <th style="width: 50%; text-align: center; padding: 10px;">Service</th>
                                    <th style="width: 10%; text-align: center; padding: 10px;">Qty</th>
                                    <th style="width: 15%; text-align: center; padding: 10px;">Price</th>
                                    <th style="width: 15%; text-align: center; padding: 10px;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $key => $service)
                                    <tr>
                                        <td style="padding: 8px;">{{$key + 1}}</td>
                                        <td style="padding: 8px;">{{$service->service->station->name}} - {{$service->service->name}}</td>
                                        <td style="padding: 8px;" class="text-right">1</td>
                                        <td style="padding: 8px;" class="text-right">₱ {{number_format($service->service->price)}}</td>
                                        <td style="padding: 8px;" class="text-right">₱ {{number_format($service->service->price)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-right" style="text-transform: uppercase; border:1px solid rgb(173, 167, 167); padding:8px">
                            <p><span style="margin-right: 10px">Subtotal</span>₱ {{number_format($sub_total)}}</p>
                            @if ($discount)
                                <p><span style="margin-right: 10px">Disc@ {{$discount}}</span>₱ {{number_format($discount_val,2)}}</p>

                            @endif
                            <p style="font-weight:bold"><span style="margin-right: 10px">Grand total</span>₱ {{number_format($grand_total,2)}}</p>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top: 30px">
                    <div style="padding-top:30px;" class="col-xs-12">
                        <div class="col-xs-5">
                            <div style="border-bottom: 1px solid"></div>
                            <p>Received By:</p>
                            <p>Name: <span style="font-weight: 800">{{$emp}}</span></p>
                            <p>Employee No.: <span style="font-weight: 800">{{$emp_id}}</span></p>
                        </div>
                        <div class="col-xs-7">

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</body>

</html>
