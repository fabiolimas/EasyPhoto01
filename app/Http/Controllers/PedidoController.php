<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Laboratorio;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\User;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $laboratorios=Laboratorio::all();
        if(auth()->user()->nivel == 'administrador'){
            $pedidos=Pedido::paginate(20);


        }else{
            $pedidos=Pedido::where('laboratorio_id',auth()->user()->laboratorio_id)->paginate(20);
        }
        return view('painel.pedido.pedidos',compact('pedidos','laboratorios'));
    }




    public function detalhePedido(Request $request)
    {
        $pedido=Pedido::find($request->id);
        $itensPedido=PedidoItem::where('pedido_id', $pedido->id)->get();
        $totalImagens=0;
        $totalPedido=0;

        $user=User::find($pedido->user_id);

        foreach($itensPedido as $item){
            $totalImagens+=$item->quantidade;

        }
        $laboratorio=Laboratorio::find($pedido->laboratorio_id);


        return view('painel.pedido.detalhes-pedido', compact('cliente','totalPedido','laboratorio','pedido','itensPedido','totalImagens'));
    }

    public function buscaPedidos(Request $request){

        $busca=$request->busca;
        $loja=$request->loja;

        if(auth()->user()->nivel=='Adminstrador'){
            if($busca == ''){
                $pedidos=Pedido::paginate(30);
            }else{

                $pedidos=Pedido::where('cliente', 'like','%'.$busca.'%')
                ->orWhere('id', 'like', '%'.$busca.'%')

                ->paginate(30);
            }

        }else{

            if($busca == ''){
                $pedidos=Pedido::where('laboratorio_id', auth()->user()->laboratorio_id)->paginate(30);
            }else{

                $pedidos=Pedido::where('cliente', 'like','%'.$busca.'%')
                ->orWhere('id', 'like', '%'.$busca.'%')
                ->where('laboratorio_id', auth()->user()->laboratorio_id)
                ->paginate(30);
            }

        }





        if($pedidos->count()>=1){
            return view('painel.buscas.busca_pedidos', compact('pedidos'));

        }else{
            return response()->json(['result'=>'Nenhum pedido encontrado!']);
        }

    }

    public function buscaPedidosLab(Request $request){


        $loja=$request->loja;

        if($loja == ''){
            $pedidos=Pedido::paginate(30);
        }else{

            $pedidos=Pedido::where('laboratorio_id', $loja)->paginate(30);
        }



        if($pedidos->count()>=1){
            return view('painel.buscas.busca_pedidos', compact('pedidos'));

        }else{
            return response()->json(['result'=>'Nenhum pedido encontrado!']);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function alteraStatus(Request $request)
    {
        $pedido=Pedido::find($request->id);
        $pedido->update(['status'=>'Finalizado']);
        return redirect()->back()->with('success','Status do pedido atualizado com sucesso!');
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
