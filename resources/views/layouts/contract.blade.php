<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
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
        .download-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #7c3aed;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background 0.2s;
        }
        .download-btn:hover {
            background: #6d28d9;
        }
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .document-wrapper {
                box-shadow: none;
            }
            .download-btn {
                display: none;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <a href="{{ route('contracts.downloadPdf', $contractId) }}" download class="download-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
        </svg>
        Baixar PDF
    </a>
    <div class="document-wrapper">
        @yield('content')
    </div>
</body>
</html>
