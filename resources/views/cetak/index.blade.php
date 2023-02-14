<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="css/bootstrap3.min.css" rel="stylesheet">
    <style>
        .report-header-title {
            font-size: 16px;
            font-weight: bolder;
        }
        .report-header-sub-title {
            font-size: 12px;
        }
        .report-title {
            font-size: 14px;
            font-weight: bolder;
        }
        .f-bold {
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 0cm;
            right: 0cm;
            height: 2cm;
        }
        .w-50 {
            width: 50%;
        }
        .font-weight-bold {
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .d-flex {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .text-body {
            font-size: 12px;
        }
        .text-body-small {
            font-size: 10px;
        }

        .text-body-very-small {
            font-size: 8px;
        }
    </style>
</head>
<body>
<div style="position: relative">
    <img src="{{ public_path('assets/icon/logo.png') }}" height="50" style="position: absolute; top: 0; left: 0">
    <div>
        <div class="text-center report-header-title">SMK MUHAMMADIYAH 2 WURYANTORO</div>
        <div class="text-center report-header-sub-title">
            <span>Jl. Melati 5, Ngebel, Wuryantoro, Kec. Wuryantoro, Kabupaten Wonogiri, Jawa Tengah 57661</span>
        </div>
    </div>
</div>
<hr style="border-top: 1px solid black">
@yield('content')
</body>
</html>
