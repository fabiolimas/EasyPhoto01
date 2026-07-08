<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Laboratorio;
use App\Models\Payment;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $laboratorios = Laboratorio::all();
      $hoje = Carbon::now();
        $totalPedidos = 0;

        $meses = $hoje->copy()->subMonths(6);

    // $query = Pedido::query();

    // if (auth()->user()->nivel != 'administrador') {
    //     $query->where('laboratorio_id', auth()->user()->laboratorio_id);
    // }

    // $pedidos = $query->orderBy('created_at', 'DESC')->paginate(20);


    // return view('painel.pedido.pedidos', compact('pedidos', 'laboratorios'));
    if (auth()->user()->nivel == 'laboratorio') {


            $totalCancelados = 0;
            $pedidos = Pedido::where('laboratorio_id', auth()->user()->laboratorio_id)
                // ->whereMonth('created_at', Carbon::now()->month)
                //->whereYear('created_at', Carbon::now()->year)
                 ->orderBY('id', 'Desc')
                ->paginate(25);
            foreach ($pedidos as $ped) {
                $totalPedidos += $ped->total;
            }




            $pedidosCancelados = Pedido::where('status', 'Cancelado')

                ->count();

            $pedidos_recentes = Pedido::join('laboratorios', 'laboratorios.id', 'pedidos.laboratorio_id')
                ->select('pedidos.*', 'laboratorios.nome as labNome')
                ->where('laboratorio_id', auth()->user()->laboratorio_id)
                ->orderBY('id', 'Desc')
                ->limit(5)->get();


            $pedidosPendentes = Pedido::where('status', 'Aguardando Impressão')
                //->whereMonth('created_at', Carbon::now()->month)
                //->whereYear('created_at', Carbon::now()->year)
                ->where('laboratorio_id', auth()->user()->laboratorio_id)
                ->count();

            $pedidosConcluidos = Pedido::where('status', 'Finalizado')
                //->whereMonth('created_at', Carbon::now()->month)
                //->whereYear('created_at', Carbon::now()->year)
                ->where('laboratorio_id', auth()->user()->laboratorio_id)
                ->count();

            $clientes = User::join('pedidos', 'pedidos.user_id', '=', 'users.id')
                ->select(
                    'users.name',
                    'pedidos.user_id as cliente',
                    DB::raw('COUNT(pedidos.id) as total_pedidos')
                )
                ->where('users.laboratorio_id', 0)
                ->where('pedidos.laboratorio_id', auth()->user()->laboratorio_id)
                // ->whereMonth('pedidos.created_at', Carbon::now()->month)
                // ->whereYear('pedidos.created_at', Carbon::now()->year)
                ->orderBy('users.name', 'asc')
                ->groupBy('pedidos.user_id', 'users.name')
                ->get();
            return view('painel.pedido.pedidos', compact('laboratorios','totalPedidos', 'pedidos_recentes', 'pedidosCancelados', 'pedidos', 'pedidosPendentes', 'pedidosConcluidos', 'clientes'));
        } else {

            $clientes = User::join('pedidos', 'pedidos.user_id', '=', 'users.id')
                ->select(
                    'users.name',
                    'pedidos.user_id as cliente',
                    DB::raw('COUNT(pedidos.id) as total_pedidos')
                )
                ->where('users.laboratorio_id', 0)
                ->whereMonth('pedidos.created_at', Carbon::now()->month)
                ->whereYear('pedidos.created_at', Carbon::now()->year)
                ->orderBy('users.name', 'asc')
                ->groupBy('pedidos.user_id', 'users.name')
                ->get();




            $pedidos = Pedido::
                orderBY('id', 'Desc')
             ->paginate(25);

            foreach ($pedidos as $pda) {
                $totalPedidos += $pda->total;
            }
            $pedidosPendentes = Pedido::where('status', 'Aguardando Impressão')


                ->count();
            $pedidosConcluidos = Pedido::where('status', 'Finalizado')

                ->count();

            $pedidosCancelados = Pedido::where('status', 'Cancelado')

                ->count();

            return view('painel.pedido.pedidos', compact('laboratorios','totalPedidos', 'pedidosCancelados',  'pedidos', 'pedidosPendentes', 'pedidosConcluidos', 'clientes'));
        }
}




    public function detalhePedido(Request $request)
    {
        $pedido=Pedido::find($request->id);
        $itensPedido=PedidoItem::where('pedido_id', $pedido->id)->get();
        $totalImagens=0;
        $totalPedido=0;

         $payment=Payment::where('pedido_id', $pedido->id)
        ->where('payment_id','<>', null)
        ->first();

        $user=User::find($pedido->user_id);
 $cliente=Cliente::where('user_id',$user->id)->first();

$pedidosPendentes = Pedido::where('status', 'Aguardando Impressão')
              ->where('created_at','>', Carbon::now()->subDays($request->dia))
                //->whereYear('created_at', Carbon::now()->year)
                ->where('laboratorio_id', auth()->user()->laboratorio_id)
                ->count();

        foreach($itensPedido as $item){
            $totalImagens+=$item->quantidade;

        }
        $laboratorio=Laboratorio::find($pedido->laboratorio_id);


        return view('painel.pedido.detalhes-pedido', compact('pedidosPendentes','payment','cliente','user','totalPedido','laboratorio','pedido','itensPedido','totalImagens'));
    }

    public function buscaPedidos(Request $request){

        $busca=$request->busca;
        $loja=$request->loja;
        $status=$request->status;

        if(auth()->user()->nivel=='Adminstrador'){
            if($busca == ''){
                $pedidos=Pedido::paginate(30);
            }else{

                $pedidos=Pedido::where('cliente', 'like','%'.$busca.'%')
                ->orWhere('id', 'like', '%'.$busca.'%')
                ->orWhere('status','like','%'.$status.'%')

                ->paginate(30);
            }

        }else{

            if($busca == ''){
                $pedidos=Pedido::where('laboratorio_id', auth()->user()->laboratorio_id)->paginate(30);
            }else{

                $pedidos=Pedido::where('cliente', 'like','%'.$busca.'%')
                ->orWhere('id', 'like', '%'.$busca.'%')
                ->orWhere('status','like','%'.$status.'%')
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
