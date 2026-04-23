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


    public function cielo($pedidoId, $valor){

        $pedido=Pedido::find($pedidoId);

        $cliente=Cliente::where('user_id',$pedido->user_id)->first();




$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://apisandbox.cieloecommerce.cielo.com.br/1/sales/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
   CURLOPT_POSTFIELDS => json_encode([
    'Customer' => [
        'Name' => $cliente->nome,
        'Identity' => '12345678909',
        'IdentityType' => 'cpf'
    ],
    'Payment' => [
        'Type' => 'pix',
        'Amount' => (int) round($pedido->total * 100)
    ],
    'MerchantOrderId' => $pedido->id
  ]),
  CURLOPT_HTTPHEADER => [
    "Content-Type: application/json",
    "MerchantId: a57bea08-8175-463d-81c8-33e731ceeba1",
    "MerchantKey: CoK6MYufghg7ORmfMVF6VOEqZIxTWcdDXxBhPXgr",
    "RequestId: get",
    "accept: application/json"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);



if ($err) {
  echo "cURL Error #:" . $err;
} else {
 # echo $response;
}

$data=json_decode($response, true);

return view('site.pagamentos.pix', compact('data','pedidoId','valor'));
}



}
