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


    public function cielo($pedidoId, $valor)
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

    return view('site.pagamentos.pix', compact('data','pedidoId','valor'));
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
        'status' => 'pago'
    ]);

    return "Pagamento simulado com sucesso!";
}


}
