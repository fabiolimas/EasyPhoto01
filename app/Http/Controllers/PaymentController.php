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

    public function escolhaPagamento($pedidoId){

    $pedido=Pedido::find($pedidoId);
    return view('site.pagamentos.escolha', compact('pedido'));
    }

    public function cardview($pedidoId){

    $pedido=Pedido::find($pedidoId);

    return view('site.pagamentos.cartao',compact('pedido'));

    }


    public function processarPagamento(Request $request, $pedidoId)
    {


    if ($request->forma_pagamento == 'pix') {
        return redirect()->route('pagamento.pix', $pedidoId);
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
        CURLOPT_URL => "https://apisandbox.cieloecommerce.cielo.com.br/1/sales/",
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
    curl_close($curl);

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

    return view('site.pagamentos.pix', compact('data','pedidoId'));
}



public function consultarPix($paymentId)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://apisandbox.cieloecommerce.cielo.com.br/1/sales/{$paymentId}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "MerchantId: env('MERCHANT_ID)",
            "MerchantKey: env('MERCHANT_KEY)",
        ],
    ]);

    $response = curl_exec($curl);


    $data = json_decode($response, true);

    return $data;
}

public function webhook(Request $request)
{
    $paymentId = $request->input('PaymentId');

    if (!$paymentId) {
        return response()->json(['error' => 'PaymentId não informado'], 400);
    }

    $data = $this->consultarPix($paymentId);

    $pedido = Pedido::where('payment_id', $paymentId)->first();

    if ($pedido && $data['Payment']['Status'] == 2) {
        $pedido->status = 'pago';
        $pedido->save();
    }

    return response()->json(['success' => true]);
}

public function simularPagamento($paymentId)
{
    $payment = Payment::where('payment_id', $paymentId)->first();

    if (!$payment) {
        return "Pagamento não encontrado";
    }

    // Simula como pago
    $payment->update([
        'status' => 'pago'
    ]);

    // Atualiza pedido também
    $pedido = $payment->pedido;
    $pedido->update([
        'status_pagamento' => 'pago'
    ]);

    return "Pagamento simulado com sucesso!";
}

// public function cieloCard($pedidoId){

// $pedido = Pedido::findOrFail($pedidoId);
//     $cliente = Cliente::where('user_id', $pedido->user_id)->first();

//     $amount = (int) round($pedido->total * 100);

//     // 👉 cria registro ANTES de enviar
//     $payment = Payment::create([
//         'pedido_id' => $pedido->id,
//         'amount' => $amount,
//         'status' => 'pendente',
//         'type' => 'CreditCard'
//     ]);
//     $curl = curl_init();

// curl_setopt_array($curl, [
//   CURLOPT_URL => "https://apisandbox.cieloecommerce.cielo.com.br/1/sales/",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 30,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "POST",
//   CURLOPT_POSTFIELDS => json_encode([
//     'Customer' => [
//             'Name' => $cliente->nome,
//         'Identity' => $cliente->cpf,

//     ],
//     'Payment' => [
//         'Type' => 'CreditCard',
//         'IsCryptocurrencyNegociation' => false,
//        'CreditCard' => [
//                 'CardNumber' => '5371542802050634',
//                 'Holder' => $cliente->nome,
//                 'ExpirationDate' => '07/2027',
//                 'SecurityCode' => '574',
//                 'Brand' => 'Master'
//         ],
//         'Amount' => 10000,
//         'Currency' => 'BRL',
//         'Country' => 'BRA',
//         'Installments' => 1
//     ],
//     'MerchantOrderId' => '12'
//   ]),
//   CURLOPT_HTTPHEADER => [
//     "Content-Type: application/json",
//     "MerchantId: a57bea08-8175-463d-81c8-33e731ceeba1",
//     "MerchantKey: CoK6MYufghg7ORmfMVF6VOEqZIxTWcdDXxBhPXgr",
//     "accept: application/json"
//   ],
// ]);

// $response = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);

// if ($err) {
//         return back()->with('error', $err);
//     }

//     $data = json_decode($response, true);

//     // 👉 salva retorno da Cielo
//     if (isset($data['Payment']['PaymentId'])) {
//         $payment->update([
//             'payment_id' => $data['Payment']['PaymentId'],
//             'payload' => json_encode($data)
//         ]);
//     }
// }

public function cieloCard(Request $request, $pedido_id)
{
    $pedido = Pedido::findOrFail($pedido_id);
     $cliente = Cliente::where('user_id', $pedido->user_id)->first();

    $numero = str_replace(' ', '', $request->numero);
    [$mes, $ano] = explode('/', $request->validade);

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
        CURLOPT_URL => "https://apisandbox.cieloecommerce.cielo.com.br/1/sales/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'Customer' => [
            'Name' => $cliente->nome,
        'Identity' => $cliente->cpf,

    ],
            "MerchantOrderId" => $pedido->id,
            "Payment" => [
                "Type" => "CreditCard",
                "Amount" => $amount,
                "Installments" => (int) $request->parcelas,
                "SoftDescriptor" => "Lojas Imagem",
                "CreditCard" => [
                    "CardNumber" => $numero,
                    "Holder" => $request->nome,
                    "ExpirationDate" => $mes . "/20" . $ano,
                    "SecurityCode" => $request->cvv,
                    "Brand" => "Visa" // depois dá pra detectar automático
                ]
            ]
        ]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "MerchantId: " . env('MERCHANT_ID'),
            "MerchantKey: " . env('MERCHANT_KEY')
        ],
    ]);



    $response = curl_exec($curl);

    dd($response);

    $err = curl_error($curl);

    $data = json_decode($response, true);

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

    if(isset($data['Payment']['Status']) && $data['Payment']['Status'] == 2){
        $pedido->update(['status' => 'pago']);
    }

    return redirect()->route('pedidos-cliente')->with('success', 'Pagamento'.$pedido->id. 'processado!');
}


}
