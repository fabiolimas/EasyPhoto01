<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\PedidoItem;
use App\Models\Laboratorio;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pedidoCliente()
    {
       $pedidos=Pedido::where('user_id',auth()->id())->paginate(30);



       return view('site.pedidos.index',compact('pedidos'));
    }

    public function meusDados(Request $request){



        $cli = Cliente::where('user_id', $request->id)->get();

        foreach($cli as $client){
            $cliente=Cliente::find($client->id);
        }


        return view('site.pedidos.meus-dados',compact('cliente'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function detalhePedido(Request $request)
    {
        $pedido=Pedido::find($request->id);
        $itensPedido=PedidoItem::where('pedido_id', $pedido->id)->get();
        $totalImagens=0;
        $totalPedido=0;
        $usuario=User::find($pedido->user_id);
        $cliente=Cliente::where('user_id',$usuario->id)->first();

        foreach($itensPedido as $item){
            $totalImagens+=$item->quantidade;

        }
        $laboratorio=Laboratorio::find($pedido->laboratorio_id);


        return view('site.pedidos.detalhes-pedido', compact('cliente','totalPedido','laboratorio','pedido','itensPedido','totalImagens'));
    }

    public function buscaPedidos(Request $request){

        $busca=$request->busca;

            if($busca == ''){
                $pedidos=Pedido::where('user_id', auth()->user()->id)->paginate(30);
            }else{

                $pedidos=Pedido::where('id', 'like', '%'.$busca.'%')
                ->where('user_id', auth()->user()->id)
                ->paginate(30);
            }

        if($pedidos->count()>=1){
            return view('site.pedidos.buscas.busca_pedidos', compact('pedidos'));

        }else{
            return response()->json(['result'=>'Nenhum pedido encontrado!']);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
