
@extends('layouts.envio')

@section('title', 'Pagamento')

@section('content_header')


@section('content')


<style>
        body {
            background: #f5f6fa;
        }
        .card-pix {
            max-width: 500px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .qr-code {
            max-width: 250px;
            margin: 0 auto;
        }
        .copy-box {
            background: #f1f2f6;
            border-radius: 8px;
            padding: 10px;
            font-size: 13px;
            word-break: break-all;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card card-pix p-4">

        <h4 class="text-center mb-3">Pagamento via PIX</h4>

        @if(isset($data['Payment']['PaymentId']))

        <!-- Valor -->
        <h2 class="text-center text-success mb-4">
            R$ {{ number_format($data['Payment']['Amount'] / 100, 2, ',', '.') }}
        </h2>

        <!-- QR Code -->
        <div class="text-center mb-4">
            <img class="qr-code img-fluid"
                 src="data:image/png;base64,{{ $data['Payment']['QrCodeBase64Image'] }}">
        </div>

        <!-- Instruções -->
        <p class="text-center text-muted">
            Escaneie o QR Code ou copie o código abaixo para pagar
        </p>

        <!-- Código copia e cola -->
        <div class="copy-box mb-3" id="pixCode">
            {{ $data['Payment']['QrCodeString'] }}
        </div>

        <!-- Botão copiar -->
        <button class="btn btn-dark w-100 mb-3" onclick="copiarPix()">
            📋 Copiar código PIX
        </button>

        <!-- Status -->
        <div class="text-center">
            <span class="badge bg-warning">
                Aguardando pagamento
            </span>
        </div>

        <!-- Info extra -->
        <div class="mt-4 text-center text-muted small">
            Pedido: {{ $data['MerchantOrderId'] }} <br>
            Data: {{ $data['Payment']['ReceivedDate'] }}
        </div>

    </div>
       <!-- Botão copiar -->
        <a href="{{route('pedidos-cliente')}}" class="btn btn-success w-100 mb-3">
            <i class="bi bi-check-lg"></i> Feito
        </a>
    @else

     <p class="text-center text-muted text-danger">
            Ocorreu um erro ao tentar gerar o seu QRCode de pagamento, tente novamente em instantes!
        </p>

        <a href="{{route('pedidos-cliente')}}" class="btn btn-warning w-100 mb-3">
            <i class="bi bi-check-lg"></i> Voltar
        </a>

    @endif


</div>

<script>
function copiarPix() {
    let text = document.getElementById("pixCode").innerText;

    navigator.clipboard.writeText(text).then(() => {
        alert("Código PIX copiado!");
    });
}
</script>




@stop
@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
@stop



