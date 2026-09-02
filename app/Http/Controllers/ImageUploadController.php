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
use Log;


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

    public function criarPedido(Request $request)
{
    $user = User::findOrFail($request->user_id);

    $pedido = new Pedido();

    $pedido->user_id = $user->id;
    $pedido->cliente = $user->name;
    $pedido->status = 'Aguardando Impressão';
    $pedido->status_pagamento = 'pendente';
    $pedido->laboratorio_id = $request->laboratorio_id;
    $pedido->observacao = $request->observacao;
    $pedido->total = number_format(
        $request->total,
        2,
        '.',
        ','
    );
    $pedido->payment_method = null;
    $pedido->forma_de_entrega = $request->forma_entrega;
    $pedido->val_entrega = number_format(
        $request->val_entrega,
        2,
        '.',
        ','
    );

    $pedido->save();


    /*
     * Cria a pasta do pedido imediatamente.
     */
    $pedidoPath = storage_path(
        'app/public/uploads/pedido_' . $pedido->id
    );

    if (!file_exists($pedidoPath)) {
        mkdir($pedidoPath, 0755, true);
    }


    /*
     * Salva observação.
     */
    if (!empty(trim($pedido->observacao))) {

        file_put_contents(
            $pedidoPath . '/observacao.txt',
            $pedido->observacao
        );

    }


    return response()->json([
        'success' => true,
        'pedido' => $pedido->id
    ]);
}

   public function uploadImage(Request $request)
{
    /*
     * O pedido já deve existir.
     */
    $pedido = Pedido::findOrFail(
        $request->pedido_id
    );


    /*
     * Arquivos enviados nesta requisição.
     *
     * Agora esperamos normalmente apenas
     * UMA imagem por requisição.
     */
    $images = $request->file('images');


    if (!$images) {

        return response()->json([
            'error' => true,
            'message' => 'Nenhuma imagem foi enviada.'
        ], 422);

    }


    /*
     * Normaliza para array.
     *
     * Isso mantém compatibilidade caso eventualmente
     * sejam enviados vários arquivos.
     */
    if (!is_array($images)) {
        $images = [$images];
    }


    $tamanhos = json_decode(
        $request->input('tamanhos'),
        true
    );

    $quantidades = json_decode(
        $request->input('quantidades'),
        true
    );

    $precos = json_decode(
        $request->input('precos'),
        true
    );


    $imageUrls = [];


    foreach ($images as $index => $image) {


        /*
         * Verifica se os dados da imagem existem.
         */
        if (
            !isset($tamanhos[$index]) ||
            !isset($quantidades[$index]) ||
            !isset($precos[$index])
        ) {

            continue;

        }


        /*
         * Verifica erro do upload.
         */
        if (!$image->isValid()) {

            return response()->json([
                'error' => true,
                'message' =>
                    'Erro no upload da imagem.',

                'arquivo' =>
                    $image->getClientOriginalName(),

                'upload_error' =>
                    $image->getError(),

                'upload_error_message' =>
                    $image->getErrorMessage(),

            ], 422);

        }


        $size =
            $tamanhos[$index];

        $quantity =
            $quantidades[$index];

        $price =
            $precos[$index];


        /*
         * Nome original.
         */
        $imageName =
            $image->getClientOriginalName();


        /*
         * Caminho da imagem.
         */
        $imagePath =
            'uploads/pedido_' .
            $pedido->id .
            '/Foto_' .
            $size['height'] .
            'x' .
            $size['width'] .
            '/' .
            $quantity;


        $fullImagePath =
            storage_path(
                'app/public/' .
                $imagePath
            );


        /*
         * Cria diretórios.
         */
        if (!file_exists($fullImagePath)) {

            mkdir(
                $fullImagePath,
                0755,
                true
            );

        }


        /*
         * Salva o arquivo ORIGINAL.
         *
         * Não passa pelo Intervention Image.
         */
        $image->move(
            $fullImagePath,
            $imageName
        );


        /*
         * Caminho relativo.
         */
        $imageUrl =
            $imagePath .
            '/' .
            $imageName;


        $imageUrls[] =
            asset(
                'storage/' .
                $imageUrl
            );


        /*
         * Registra no banco.
         */
        PedidoItem::create([

            'pedido_id' =>
                $pedido->id,

            'nome' =>
                $imageName,

            'caminho' =>
                $imageUrl,

            'tamanho' =>
                $size['height'] .
                'x' .
                $size['width'],

            'quantidade' =>
                $quantity,

            'preco' =>
                $price,

        ]);

    }


    return response()->json([

        'success' => true,

        'images' =>
            $imageUrls,

        'pedido' =>
            $pedido->id

    ]);
}


public function downloadFiles(Request $request)
{
    set_time_limit(3600);

    $pedido = Pedido::findOrFail($request->id);

    $pedidoItems = PedidoItem::where(
        'pedido_id',
        $pedido->id
    )->get();

    $zipFileName = $pedido->cliente . '.zip';

    $zipFilePath = storage_path(
        'app/public/uploads/' . $zipFileName
    );

    $zip = new \ZipArchive();

    if ($zip->open(
        $zipFilePath,
        \ZipArchive::CREATE | \ZipArchive::OVERWRITE
    ) !== TRUE) {

        return response()->json([
            'error' => 'Falha ao criar o arquivo ZIP.'
        ], 500);
    }

    // Adicionar imagens
    foreach ($pedidoItems as $item) {

        $sourcePath = storage_path(
            'app/public/' . $item->caminho
        );

        if (is_file($sourcePath)) {

            $zip->addFile(
                $sourcePath,
                $item->caminho
            );
        }
    }

    // Adicionar observacao.txt
    $observacaoPath = storage_path(
        'app/public/uploads/pedido_' .
        $pedido->id .
        '/observacao.txt'
    );

    if (is_file($observacaoPath)) {

        $zip->addFile(
            $observacaoPath,
            'observacao.txt'
        );
    }

    $zip->close();

    clearstatcache(true, $zipFilePath);

    if (!is_file($zipFilePath)) {

        return response()->json([
            'error' => 'O arquivo ZIP não foi criado.'
        ], 500);
    }

    // Tamanho do arquivo criado
    \Log::info('ZIP criado', [
        'pedido' => $pedido->id,
        'arquivo' => $zipFileName,
        'tamanho' => filesize($zipFilePath),
        'tamanho_mb' => round(filesize($zipFilePath) / 1024 / 1024, 2)
    ]);

    // IMPORTANTE:
    // Deixa o servidor web entregar o arquivo diretamente.
    $url = asset(
        'storage/uploads/' . rawurlencode($zipFileName)
    );

    return redirect($url);
}
}








