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
            bottom: 30px; /* slight padding from bottom of image */
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
        #frequencies .checked {
            height:11px; width:11px;
            border: 2px solid #000;
            display: inline-block;
            background-color:black;
        }
        #frequencies span {

            height:10px; width:10px;
            border: 2px solid #000;
            display: inline-block;
        }
        #procedures .checked {
            height:10px; width:10px;
            border: 1px solid #000;
            display: inline-block;
            background-color:black;
        }
        #procedures span {
            height:10px; width:10px;
            border: 1px solid #000;
            display: inline-block;
        }
        .display-text{
            height: 10px;
        }
    </style>
</head>



<div class="row">
    <div class="overlay">
        <img src="{{base_path('public/images/logo.png')}}" width="100%" height="auto" style="display: block;"/>
        {{-- <div class="test">
            <p style="font-weight: bold; text-transform:uppercase">Equipment maintenance monitoring form</p>
            <p style="margin:0px;padding:0px">FM-GSD-006-13/1</p>
        </div> --}}
    </div>
</div>
<body>
    <div class="container-fluid">
        <div class="page">
            <div class="content" style="text-align: justify;">
                <div class="row ">
                    <div style="padding-top:20px;" class="no_margin">
                        <div class="col-xs-8">

                        </div>
                        <div class="col-xs-4">
                            <div class="col-xs-3">
                                <strong>
                                    Date:
                                </strong>
                            </div>
                            <div class="col-xs-9 display">
                                <p class="display-text">{{$date}}</p>
                            </div>
                        </div>
                    </div><br><br>

                    <div class="col-xs-7 no_margin">
                        <div class="col-xs-3">
                            <strong>
                                Department:
                            </strong>
                        </div>
                        <div class="col-xs-9 display">
                            <p class="display-text">{{$department}}</p>
                        </div>
                        <div class="col-xs-4">
                            <strong>
                                Equipment Name:
                            </strong>
                        </div>
                        <div class="col-xs-8 display">
                             <p class="display-text">{{$eq_name}}</p>
                        </div>
                        <div class="col-xs-3">
                            <strong>
                                Manufacturer:
                            </strong>
                        </div>
                        <div class="col-xs-9 display">
                            <p class="display-text">{{$manufacturer}}</p>
                        </div>
                    </div>

                    <div class="col-xs-5 no_margin">
                        <div class="col-xs-12">
                            <div class="col-xs-4">
                                <strong>
                                    PMS No.:
                                </strong>
                            </div>
                            <div class="col-xs-8 display">
                                <p class="display-text">{{$pms_no}}</p>

                            </div>
                            <div class="col-xs-3">
                                <strong>
                                    Model:
                                </strong>
                            </div>
                            <div class="col-xs-9 display">
                                <p class="display-text">{{$model}}</p>
                            </div>
                            <div class="col-xs-4">
                                <strong>
                                    Serial No.:
                                </strong>
                            </div>
                            <div class="col-xs-8 display">
                                <p class="display-text">{{$serial_no}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div style="padding-top:20px;" class="col-xs-12" id="frequencies">
                        <p><strong>PM Frequency:</strong></p>
                            <div class="col-xs-2" style="text-transform:capitalize">
                                <span> TEst</span>
                            </div>
                        <div class="col-xs-4" style="text-transform:capitalize">
                            <span checked> Example Test</span>
                        </div>
                    </div>

                    <div style="padding-top:10px;" class="col-xs-12">
                        <p><strong><u>Procedure:</u></strong></p>

                        <div style="line-height: 0.9; padding-left:8%" id="procedures">


                            <p>
                                <span class="checked"></span>   {{--Sample Checked class --}}
                                Example Procedure
                                Example Procedure
                                Example Procedure
                            </p>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div style="padding-top:20px;" class="col-xs-12">
                        <div class="col-xs-7">
                            <div class="col-xs-5 no_margin">
                                <strong>
                                    Last PM Performed:
                                </strong>
                            </div>
                            <div class="col-xs-7 display">
                                <p class="display-text">{{$lastpm_perform}}</p>
                            </div>
                        </div>
                        <div class="col-xs-5">

                        </div>

                        <div style="padding-top:20px; padding-left:5%" class="col-xs-12">
                            <table style="width: 100%; border-collapse: collapse;" border="2">
                                <thead>
                                    <tr>
                                        <th style="width: 30%; text-align: center; padding: 3px;">Parts</th>
                                        <th style="width: 20%; text-align: center; padding: 3px;">In Good Condition</th>
                                        <th style="width: 20%; text-align: center; padding: 3px;">Need Replacement</th>
                                        <th style="width: 30%; text-align: center; padding: 3px;">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($parts as $part)
                                        <tr>
                                            <td style="padding: 2px;">{{$part['parts']}}</td>
                                            <td style="padding: 2px;">{{$part['in_good_condition'] ? 'Yes' : 'No'}}</td>
                                            <td style="padding: 2px;">{{$part['need_replacement'] ? 'Yes' : 'No'}}</td>
                                            <td style="padding: 2px;">{{$part['remarks']}}</td>
                                        </tr>
                                    @endforeach
                                    @if (count($parts) <= 3)
                                        <tr>
                                            <td style="padding: 2px; "> <span style="visibility:hidden">N/A</span></td>
                                            <td style="padding: 2px;"></td>
                                            <td style="padding: 2px;"></td>
                                            <td style="padding: 2px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 2px; "> <span style="visibility:hidden">N/A</span></td>
                                            <td style="padding: 2px;"></td>
                                            <td style="padding: 2px;"></td>
                                            <td style="padding: 2px;"></td>
                                        </tr>
                                    @endif

                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                        <div style="padding-top:20px; padding-left:5%" class="col-xs-12">
                            <table style="width: 100%; border-collapse: collapse;" border="2">
                                <thead>
                                    <tr>
                                        <th style="width: 50%; text-align: center; padding: 3px;">Parts Replaced</th>
                                        <th style="width: 50%; text-align: center; padding: 3px;">Missing Hardware</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($missingAndReplace as $item)
                                        <tr>
                                            <td style="padding: 2px;">{{$item['replaced']['name'] ?? null}}</td>
                                            <td style="padding: 2px;">{{$item['missing']['name'] ?? null}}</td>
                                        </tr>
                                    @endforeach

                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div style="padding-top:20px; padding-left:3%" class="col-xs-12">
                        <div class="col-xs-3" style="text-align: center">
                            <div class="col-xs-12 no_margin">
                                <strong>
                                    Conducted by:
                                </strong>
                            </div>
                            <div class="col-xs-12 display" style="padding-top:20px">
                                <p class="display-text">{{$technician}}</p>
                            </div>
                            <div>
                                Technician
                            </div>
                        </div>
                        <div class="col-xs-3" style="text-align: center">
                            <div class="col-xs-12 no_margin">
                                <strong>
                                    Received By:
                                </strong>
                            </div>
                            <div class="col-xs-12 display" style="padding-top:20px">
                                <p class="display-text">{{$client}}</p>
                            </div>
                            <div>
                                Client
                            </div>
                        </div>
                        <div class="col-xs-3" style="text-align: center">
                            <div class="col-xs-12 no_margin">
                                <strong>
                                    Checked & Received By:
                                </strong>
                            </div>
                            <div class="col-xs-12 display" style="padding-top:20px">
                                <p class="display-text">{{$super_visor}}</p>
                            </div>
                            <div>
                                Supervisor
                            </div>
                        </div>
                        <div class="col-xs-3" style="text-align: center">
                            <div class="col-xs-12 no_margin">
                                <strong>
                                    Noted by:
                                </strong>
                            </div>
                            <div class="col-xs-12 display" style="padding-top:20px">
                                <p class="display-text">{{$gsd}}</p>
                            </div>
                            <div>
                                General Service Director
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
