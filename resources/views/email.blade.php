<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Gi Project</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style>
        .app {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }

        .app-purple {
            background-color: #4039dc;
        }

        .bg-custom {
            background-color: #f3f3f4;
            border-radius: 20px;
            min-width: 30%;
        }

        .d-flex {
            display: flex;
            height: 100vh;
        }

        .m-auto {
            margin: auto;
        }

        .align-items-center {
            align-items: center;
        }

        .p-4 {
            padding: 2rem;
        }

        .text-purple {
            color: #4039dc;
        }
    </style>
</head>
    <body class="app app-purple">
    <div class="d-flex">
        <div class="bg-custom flex m-auto rounded align-items-center">
            <div class="p-4">
                <h2 class="text-purple">Olá, {{ $data->payeeName }}</h2>
                <p>Você recebeu uma transferência de R$ {{ number_format(($data->value ?? 0), 2, ',', '.') }} de {{ $data->payerName }}.</p>
            </div>
        </div>
    </div>
    </body>
</html>
