<?php

// app/Http/Controllers/ImageUploadController.php
namespace App\Http\Controllers;

use App\Models\Pedido;

use App\Models\Tamanho;
use App\Models\PedidoItem;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;


class ImageUploadController extends Controller
{
    public function showUploadForm()
    {

        $tamanhos=Tamanho::all();
        if (!extension_loaded('imagick')){
            echo 'imagick not installed';
        }
        return view('site.welcome', compact('tamanhos'));
    }

    public function uploadImage(Request $request)
    {


        dd($request);
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048',
        ]);

        $images = $request->file('images');
        $tamanhos = json_decode($request->input('tamanhos'), true);
        $quantidades = json_decode($request->input('quantidades'), true);
        $imageUrls = [];

        $pedido = new Pedido();
        $pedido->user_id = 3;
        $pedido->cliente = 'João'; // Atualize conforme necessário
        $pedido->status = 'recebido';
        $pedido->laboratorio_id = 1;
        $pedido->observacao=$request->observacao;

        $pedido->save();

        foreach ($images as $index => $image) {

            if (!isset($tamanhos[$index]) || !isset($quantidades[$index])) {
                continue; // Pula a iteração se o índice não existir
            }


            $size = $tamanhos[$index];
            $quantity = $quantidades[$index];
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();



            // Cortar e salvar a imagem
            $manager = new ImageManager(new Driver());

            $img = $manager->read($image)->cover($size['height']*(100/2.54), $size['width']*(100/2.54),'center');


            $imageUrl = 'storage/uploads/' . $pedido->id . '/' . $size['height'] . 'x' . $size['width'] . '/' . $quantity . '/' . $imageName;
            $imageUrls[] = asset($imageUrl);
              // Definir o caminho da pasta
              $folderPath = 'public/uploads/' . $pedido->id . '/' . $size['height'] . 'x' . $size['width'] . '/' . $quantity . '/';
              $storagePath = storage_path('app/' . $folderPath);

              // Criar as pastas se não existirem
              if (!Storage::exists($folderPath)) {
                  Storage::makeDirectory($folderPath, 0755, true);
              }
              $img->save($storagePath . $imageName);

            // Salvar o caminho da imagem e outros dados na tabela pedido_items
            PedidoItem::create([
                'pedido_id' => $pedido->id,
                'nome' => $imageUrl,
                'tamanho' => $size['height'] . 'x' . $size['width'],
                'quantidade' => $quantity,
            ]);
        }

            return response()->json(['images' => $imageUrls]);



    }
}








