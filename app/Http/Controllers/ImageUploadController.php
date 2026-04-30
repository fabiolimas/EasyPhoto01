<?php

// app/Http/Controllers/ImageUploadController.php
namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\FormasEntrega;
use App\Models\Laboratorio;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Tamanho;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;


class ImageUploadController extends Controller
{
    public function showUploadForm(Request $request)
    {

        $tamanhos=Tamanho::all();
        if (!extension_loaded('imagick')){
            echo 'imagick not installed';
        }
        $usuario=Auth::user();
        $cliente=Cliente::where('user_id',$usuario->id)->first();

        $desconto=0;

        if($cliente->desconto >1){

            $desconto=$cliente->desconto/100;

        }

        $laboratorio=Laboratorio::find($request->id);
        $entregas=FormasEntrega::where('local_relacionado', $request->id)->get();

        return view('site.welcome', compact('entregas','desconto','cliente','tamanhos', 'laboratorio'));
    }

    public function lab(Request $request){


        $laboratorios=Laboratorio::all();

        return view('site.lab', compact('laboratorios'));
    }

    public function uploadImage(Request $request)
    {

 // $request->validate([
    //     'images' => 'required|array',
    //     'images.*' => 'required|image|mimes:jpeg,png,jpg,gif',
    // ]);

    $user = User::find($request->user_id);


    $images = $request->file('images');
    $tamanhos = json_decode($request->input('tamanhos'), true);
    $quantidades = json_decode($request->input('quantidades'), true);
    // $cropData = json_decode($request->input('cropData'), true);
    $precos = json_decode($request->input('precos'), true); // Receber preços do frontend
    $imageUrls = [];

    $pedido = new Pedido();
    $pedido->user_id = $user->id;
    $pedido->cliente = $user->name; // Atualize conforme necessário
    $pedido->status = 'Aguardando Impressão';
    $pedido->status_pagamento = 'pendente';
    $pedido->laboratorio_id = $request->laboratorio_id;
    $pedido->observacao = $request->observacao;
    $pedido->total=number_format($request->total, 2, '.', ',');
    $pedido->payment_method=null;
    $pedido->forma_de_entrega=$request->forma_entrega;
    $pedido->val_entrega=number_format($request->val_entrega, 2, '.', ',');

    $pedido->save();

    foreach ($images as $index => $image) {
        if (!isset($tamanhos[$index]) || !isset($quantidades[$index]) || !isset($precos[$index])) {
            continue; // Pula a iteração se o índice não existir
        }

       // $crop = $cropData[$index];
        $size = $tamanhos[$index];
        $quantity = $quantidades[$index];
        $price = $precos[$index]; // Capturar o preço correspondente
        $imageName = $image->getClientOriginalName();

        // Ler a imagem
        $manager = new ImageManager(new Driver());
        $img = $manager->read($image->getRealPath());

        // Aplicar rotação (se necessário)
        // if (isset($crop['rotate']) && $crop['rotate'] != 0) {
        //     $img->rotate(-$crop['rotate']); // A rotação é negativa para corrigir a orientação
        // }

        // Cortar a imagem
       // $img->crop($crop['width'], $crop['height'], $crop['x'], $crop['y']);

        // Definir o caminho da imagem
        $imagePath = 'uploads/' . $pedido->id . '/' . $size['width'] . 'x' . $size['height'] . '/' . $quantity;
        $fullImagePath = storage_path('app/public/' . $imagePath);

        // Criar a estrutura de pastas se não existir
        if (!file_exists($fullImagePath)) {
            mkdir($fullImagePath, 0755, true);
        }

        // Salvar a imagem
        $img->save($fullImagePath . '/' . $imageName);

        $imageUrl = $imagePath . '/' . $imageName;
        $imageUrls[] = asset('storage/' . $imageUrl);

        // Salvar a observação, se houver
        if($request->observacao != null){
            $observacao = $request->observacao;
            $fp = fopen($fullImagePath . "/observacao.txt", "wb");
            fwrite($fp, $observacao);
            fclose($fp);
        }

        // Salvar o caminho da imagem e outros dados na tabela pedido_items
        PedidoItem::create([
            'pedido_id' => $pedido->id,
            'nome' => $imageName,
            'caminho' => $imageUrl,
            'tamanho' => $size['width'] . 'x' . $size['height'],
            'quantidade' => $quantity,
            'preco' => $price, // Salvar o preço
        ]);
    }

    return response()->json(['images' => $imageUrls, 'pedido'=>$pedido->id]);
}


public function downloadFiles(Request $request)
{
    // Recuperar o pedido e os itens do pedido
    $pedido = Pedido::findOrFail($request->id);
    $pedidoItems = PedidoItem::where('pedido_id', $pedido->id)->get();

    // Nome do arquivo .zip
    $zipFileName = 'pedido_' . $pedido->id . '.zip';
    $zipFilePath = storage_path('app/public/uploads/' . $zipFileName);

    // Criar um novo arquivo zip e adicionar os arquivos
    $zip = new \ZipArchive();
    if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
        foreach ($pedidoItems as $item) {
            $sourcePath = storage_path('app/public/' . $item->caminho);
            if (file_exists($sourcePath)) {
                // Adicionar o arquivo ao zip com o caminho relativo
                $zip->addFile($sourcePath, $item->caminho);
            }
        }
        $zip->close();

        // Retornar o arquivo zip para download
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    } else {
        return response()->json(['error' => 'Failed to create the ZIP file.'], 500);
    }
}
}








