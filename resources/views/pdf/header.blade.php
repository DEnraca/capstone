<!DOCTYPE html>
<html>
<head>
    <style>
        * {
            color: #000 !important;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0; /* remove margin because wkhtmltopdf already applies spacing */
            padding: 0;
        }

        .header-wrapper {
            width: 100%;
            text-align: center;
            position: relative;
        }

        .header-logo {
            display: block;
            margin: 0 auto;
            width: 100%;
            max-width: 80%;
            height: auto;
        }

        .header-info {
            margin-top: -10px;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header-wrapper">
    <img src="{{ public_path('images/logo.png') }}" class="header-logo" />

    <div class="header-info">
        <p style="text-transform: uppercase; margin: 0;">
            Tel Nos.: 049-557-2679 / 0935-0575-1649
        </p>
        <p style="margin: 0;">
            Email: abrclinic2010@gmail.com
        </p>
    </div>
</div>

</body>
</html>
