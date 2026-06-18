<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use App\Models\Pedido;
use App\Models\Cliente;

class PaymentController extends Controller
{
    public function form($pedidoId, $valor)
    {
        return view('site.pagamentos.index', compact('pedidoId', 'valor'));
    }

    public function escolhaPagamento($pedidoId)
    {

        $pedido = Pedido::find($pedidoId);

        $cliente = Cliente::where('user_id', $pedido->user_id)->first();
        return view('site.pagamentos.escolha', compact('cliente', 'pedido'));
    }


    public function cardview($pedidoId)
    {

        $pedido = Pedido::find($pedidoId);

        return view('site.pagamentos.cartao', compact('pedido'));
    }


    public function processarPagamento(Request $request, $pedidoId)
    {


        if ($request->forma_pagamento == 'pix') {
            return redirect()->route('pagamento.pix', $pedidoId);
        }

        if ($request->forma_pagamento == 'checkout') {

            return redirect()->route('pagamento.checkout', $pedidoId);
        }

        if ($request->forma_pagamento == 'retirada') {

            $pedido = Pedido::find($pedidoId);

            $pedido->update(['payment_method' => 'pagamento na retirada']);


            return redirect()->route('pedidos-cliente');
        }



        if ($request->forma_pagamento == 'cartao') {
            return redirect()->route('pagamento.cardView', $pedidoId);
        }

        return back()->with('error', 'Selecione uma forma de pagamento');
    }

    public function cieloPix($pedidoId)
    {
        $pedido = Pedido::findOrFail($pedidoId);
        $cliente = Cliente::where('user_id', $pedido->user_id)->first();

        $apikeysandbox = "https://apisandbox.cieloecommerce.cielo.com.br/1/sales/";
        $apikeyproducao = "https://api.cieloecommerce.cielo.com.br/1/sales";

        $amount = (int) round($pedido->total * 100);

        // 👉 cria registro ANTES de enviar
        $payment = Payment::create([
            'pedido_id' => $pedido->id,
            'amount' => $amount,
            'status' => 'pendente',
            'type' => 'pix'
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apikeyproducao,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'Customer' => [
                    'Name' => $cliente->nome,
                    'Identity' => $cliente->cpf,
                    'IdentityType' => 'cpf'
                ],
                'Payment' => [
                    'Type' => 'pix',
                    'Amount' => $amount
                ],
                'MerchantOrderId' => $pedido->id
            ]),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "MerchantId: " . env('MERCHANT_ID'),
                "MerchantKey: " . env('MERCHANT_KEY'),
                "RequestId: " . uniqid(),
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);


        if ($err) {
            return back()->with('error', $err);
        }

        $data = json_decode($response, true);




        // 👉 salva retorno da Cielo

        if (isset($data['Payment']['PaymentId'])) {
            $payment->update([
                'payment_id' => $data['Payment']['PaymentId'],
                'payload' => json_encode($data)
            ]);
        }


        return view('site.pagamentos.pix', compact('data', 'pedidoId'));
    }



    public function consultarPix(Request $request, $paymentId)
    {

    $payment = Payment::where('payment_id', $paymentId)->first();



        $curl = curl_init();
        $apikeysandbox = "https://apisandbox.cieloecommerce.cielo.com.br/1/sales/{$paymentId}";
        $apikeyproducao = "https://apiquery.cieloecommerce.cielo.com.br/1/sales/{$paymentId}";
        curl_setopt_array($curl, [
            CURLOPT_URL => $apikeyproducao,
           CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
           CURLOPT_HTTPHEADER => [
    "Content-Type: application/json",
    "MerchantId: " . env('MERCHANT_ID'),
    "MerchantKey: " . env('MERCHANT_KEY'),
],
        ]);

        $response = curl_exec($curl);


        $data = json_decode($response, true);

      $pedido = Pedido::where('id', $payment->pedido_id)->first();

        if ($pedido && $data['Payment']['Status'] == 2 || $data['Payment']['Status'] == 1) {
            $pedido->status_pagamento = 'pago';
            $pedido->payment_method = $payment->type;
            $pedido->save();

            $payment->update([
                'status' => 'pago',

            ]);
        }

        return redirect()->route('detalhes-pedidos-admin',$pedido->id)->with('success', 'Verificação de pagamento concluida');
    }



    public function simularPagamento($paymentId)
    {
        $payment = Payment::where('payment_id', $paymentId)->first();

        if (!$payment) {
            return "Pagamento não encontrado";
        }

        // Simula como pago
        $payment->update([
            'status' => 'pago',

        ]);

        // Atualiza pedido também
        $pedido = $payment->pedido;
        $pedido->update([
            'status_pagamento' => 'pago',
            'payment_method' => 'Pix'
        ]);

        return "Pagamento simulado com sucesso!";
    }

    public function detectarBandeira($numero)
{
    $numero = preg_replace('/\D/', '', $numero);

    $bandeiras = [
        'Visa' => '/^4/',
        'Master' => '/^(5[1-5]|2[2-7])/',
        'Amex' => '/^(34|37)/',
        'Elo' => '/^(4011|4312|4389|4514|4576|5041|5066|5067|5090|6277|6362|6363)/',
        'Diners' => '/^(300|301|302|303|304|305|36|38)/',
        'Discover' => '/^(6011|65|64[4-9])/',
        'JCB' => '/^(35)/',
        'Aura' => '/^(50)/',
        'Hipercard' => '/^(606282|3841)/',
    ];

    foreach ($bandeiras as $nome => $regex) {
        if (preg_match($regex, $numero)) {
            return $nome;
        }
    }

    return null;
}


    public function cieloCard(Request $request, $pedido_id)
    {
        $pedido = Pedido::findOrFail($pedido_id);
        $cliente = Cliente::where('user_id', $pedido->user_id)->first();

        $apikeysandbox = "https://apisandbox.cieloecommerce.cielo.com.br/1/sales/";
        $apikeyproducao = "https://api.cieloecommerce.cielo.com.br/1/sales/";

        $numero = str_replace(' ', '', $request->numero);
        [$mes, $ano] = explode('/', $request->validade);



$bandeira = $this->detectarBandeira($numero);

if (!$bandeira) {
    return back()->with('error', 'Bandeira do cartão não identificada.');
}

        $amount = (int) round($pedido->total * 100);

        // 👉 cria registro ANTES de enviar
        $payment = Payment::create([
            'pedido_id' => $pedido->id,
            'amount' => $amount,
            'status' => 'pendente',
            'type' => 'CreditCard'
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apikeyproducao,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'Customer' => [
                    'Name' => $cliente->nome,
                    'Identity' => $cliente->cpf,
                    'IdentityType' => 'CPF',
                    'Email' => $cliente->email,

                ],
                'Payment' => [
                    'IsCryptocurrencyNegociation' => false,
                    'CreditCard' => [
                        'CardOnFile' => [
                            'Reason' => 'Unscheduled',
                            'Usage' => 'Used'
                        ],
                        'CardNumber' => $numero,
                        'Holder' => $cliente->nome,
                        'ExpirationDate' => $mes . "/20" . $ano,
                        'SecurityCode' => $request->cvv,
                        'Brand' => $bandeira
                    ],
                    'Type' => 'CreditCard',
                    'Amount' => $amount,
                    'Installments' => (int) $request->parcelas,
                    'Capture' => true,
                ],
                'MerchantOrderId' => (string)$pedido->id
            ]),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "MerchantId: " . env('MERCHANT_ID'),
                "MerchantKey: " . env('MERCHANT_KEY')
            ],
        ]);

        $response = curl_exec($curl);

// dd($response);

        $err = curl_error($curl);

        $data = json_decode($response, true);

        if ($err) {
            return back()->with('error', $err);
        }

        $data = json_decode($response, true);

        if (isset($data['Payment']['PaymentId'])) {
            $payment->update([
                'payment_id' => $data['Payment']['PaymentId'],
                'payload' => json_encode($data)
            ]);
        }


        // 👉 salva retorno da Cielo

        if (isset($data['Payment']['Status']) && $data['Payment']['Status'] == 2) {

            $payment->update([
                'status' => 'pago',

            ]);
            $pedido->update(['status_pagamento' => 'pago',  'payment_method' => 'Cartão de Crédito']);
        }

        return redirect()->route('pedidos-cliente')->with('success', 'Pagamento' . $pedido->id . 'processado!');
    }

    public function checkoutCielo(Request $request, $pedido_id)
    {

        $pedido = Pedido::findOrFail($pedido_id);
        $cliente = Cliente::where('user_id', $pedido->user_id)->first();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://cieloecommerce.cielo.com.br/api/public/v1/orders/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'Cart' => [
                    'Items' => [
                        [
                            'Cart.Items.Name' => 'fotos',
                            'Cart.Items.UnitPrice' => 10,
                            'Cart.Items.Quantity' => 2,
                            'Cart.Items.Type' => 'foto'
                        ]
                    ]
                ],
                'Customer' => [
                    'Identity' => '84261300206',
                    'FullName' => 'Test de Test'
                ],
                'Shipping' => [
                    'Package' => 'box',
                    'Length' => 1
                ],
                'OrderNumber' => 'Pedido01',
                'SoftDescriptor' => 'Nomefantasia'
            ]),
            CURLOPT_HTTPHEADER => [
                "Content-type: application/json",
                "MerchantId: 121",
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}
