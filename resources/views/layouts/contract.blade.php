<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Locacao de Veiculo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            height: 100%;
        }
        body {
            background: #f5f5f5;
            padding: 20px;
        }
        .document-wrapper {
            max-width: 8.5in;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            min-height: 11in;
            padding-top: 40px;
            padding-bottom: 40px;
            padding-left: 80px;
            padding-right: 80px;
        }
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .document-wrapper {
                box-shadow: none;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="document-wrapper">
        @yield('content')
    </div>
</body>
</html>
