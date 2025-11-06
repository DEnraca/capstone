<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        .footer-wrapper {
            width: 100%;
            font-size: 11px;
            color: #555;
            padding-left: 10px;
            padding-right: 10px;
        }

        .footer-left {
            float: left;
        }

        .footer-right {
            float: right;
        }

        .footer-line {
            border-top: 1px solid #999;
            margin-bottom: 3px;
            width: 100%;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>

<div class="footer-wrapper">
    <div class="footer-line"></div>

    <div class="clearfix">
        <span class="footer-left">
            Print Date: {{ \Carbon\Carbon::now()->format('M d, Y g:i:s A') }} — {{auth()->user()?->employee?->getFullname() ?? null}}
        </span>

        {{-- Uncomment if you want page numbers --}}
        {{-- <span class="footer-right">Page [page] of [toPage]</span> --}}
    </div>
</div>

</body>
</html>
