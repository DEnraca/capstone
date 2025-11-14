<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" href="{{base_path('public/css/bootstrap_trimmed.min.css')}}" />
    <style type="text/css">
        *{
            color: #000;
            font-size: 15px;
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

        .primary {
            color:  #f29a11;
        }
        td{
            padding: 8px;
        }


    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="page">
            <div class="content" style="text-align: justify;">
                <div class="row" style="padding-top: 50px; text-align:center">
                    <div class="col-xs-12">
                        <p style="font-weight: 700; font-size:3rem" class="primary"> {{$service_name}} - {{$service_code}} </p>
                        <p style="font-weight: 400; font-size:2rem"> MEDICAL REPORT</p>
                    </div>
                </div>

                <div class="row" style="padding-top: 30px;">
                    <table style="width: 100%; border-collapse: collapse; font-weight:bold" border="1">
                        <tbody>
                            <tr>
                                <td colspan="3"><span class="primary">Name:</span>  {{$pat_id}} {{$patient_name}}</td>
                            </tr>
                            <tr>
                                <td style="width: 35%">
                                    <span class="primary">Age:</span> {{$age}}
                                </td>
                                <td style="width: 35%">
                                    <span class="primary">Gender:</span> {{$gender}}
                                </td>
                                <td style="width: 30%">
                                    <span class="primary">Date:</span> {{$date}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 70%" colspan="2"><span class="primary">Address:</span> {{$address}}</td>
                                <td style="width: 30%" colspan="1"><span class="primary">Transaction No.:</span>: {{$code}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row" style="padding-top: 30px;">
                    <div class="col-xs-12">
                        <span style="font-weight:700" class="primary">Impressions / Findings: </span>
                        <p style="margin-top:10px; text-align: justify;">{!! nl2br(($impressions)) !!}</p>
                    </div>
                </div>
                <div class="row" style="padding-top: 30px;">
                    <div class="col-xs-12">
                        <span style="font-weight:700"  class="primary">Remarks: <span style="font-size: 2rem; font-weight:bolder; margin-left:15px">{{$result}}</span></span>
                    </div>
                </div>
                <div class="row" style="padding-top: 30px;">
                    <div class="col-xs-12">
                        <span style="font-weight:700"  class="primary">Approved By:</span>
                    </div>

                    @foreach ($signatories as $signatory)
                        <div class="col-xs-4" style="padding-top: 15px; text-align: center;">
                            <div style="
                                width: 100%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                margin-bottom: 4px;
                                line-height: 0;
                            ">
                                @if (!empty($signatory['signature']))
                                    <img src="{{ $signatory['signature'] }}"
                                        alt="Signature"
                                        style="max-width: 200px; max-height: 70px; height: 50px; object-fit: contain; display: block;">
                                @else
                                    <!-- Invisible placeholder keeps space consistent -->
                                    <div style="width: 200px; height: 50px;"></div>
                                @endif
                            </div>

                            <p style="border-top: 1px solid black; margin: 0; padding-top: 4px; font-weight: 600;">
                                {{ $signatory['name'] ?? '' }}
                            </p>
                            <p style="margin: 0; font-size: 13px;">
                                {{ $signatory['position'] ?? '' }}
                            </p>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
        <div class="page">
            <div class="content" style="text-align: justify;">
                @if (count($attachments) > 0)
                    <div class="row" style="padding-top: 40px;">
                        <div class="col-xs-12">
                            <h3 style="font-weight:700; text-align:center; margin-bottom: 20px;" class="primary">Test Images</h3>
                        </div>
                    </div>
                    @foreach ($attachments as $index => $attachment)
                        <div class="row attachment-block" style="page-break-inside: avoid; margin-bottom: 30px; text-align: center;">
                            <div class="col-xs-12" style="display: inline-block;">
                                <div class="image-wrapper" style="
                                    border: 1px solid #ccc;
                                    border-radius: 6px;
                                    padding: 10px;
                                    background: #fafafa;
                                    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                                    display: inline-block;
                                    width: 100%;
                                    max-width: 650px;
                                ">
                                    <img src="{{ $attachment }}"
                                        alt="Attachment {{ $index + 1 }}"
                                        style="
                                            display: block;
                                            margin: 0 auto;
                                            width: 100%;
                                            max-width: 600px;
                                            height: auto;
                                            object-fit: contain;
                                        " />
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</body>
</html>
