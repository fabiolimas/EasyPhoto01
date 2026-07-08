<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $hoje = Carbon::now();
        $totalPedidos = 0;



        $meses = $hoje->copy()->subMonths(6);

        if (auth()->user()->nivel == 'cliente') {

            return redirect('/lab');
        } else if (auth()->user()->nivel == 'laboratorio') {
        $totalCancelados = 0;

        if($request != null){

            $pedidos = Pedido::where('laboratorio_id', auth()->user()->laboratorio_id)
                ->where('created_at','>', Carbon::now()->subDays($request->dia))
                //->whereYear('created_at', Carbon::now()->year)
                ->get();
            foreach ($pedidos as $ped) {
                $totalPedidos += $ped->total;
            }


             $pedidosCancelados = Pedido::where('status', 'Cancelado')
                ->where('created_at','>', Carbon::now()->subDays($request->dia))
                ->count();

            $pedidos_recentes = Pedido::join('laboratorios', 'laboratorios.id', 'pedidos.laboratorio_id')
                ->select('pedidos.*', 'laboratorios.nome as labNome')
                ->where('laboratorio_id', auth()->user()->laboratorio_id)
                 ->where('pedidos.created_at','>', Carbon::now()->subDays($request->dia))
                ->orderBY('id', 'Desc')
                ->limit(5)->get();


            $pedidosPendentes = Pedido::where('status', 'Aguardando Impressão')
              ->where('created_at','>', Carbon::now()->subDays($request->dia))
                //->whereYear('created_at', Carbon::now()->year)
                ->where('laboratorio_id', auth()->user()->laboratorio_id)
                ->count();

            $pedidosConcluidos = Pedido::where('status', 'Finalizado')
                  ->where('created_at','>', Carbon::now()->subDays($request->dia))
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
                ->where('pedidos.created_at','>', Carbon::now()->subDays($request->dia))
                // ->whereYear('pedidos.created_at', Carbon::now()->year)
                ->orderBy('users.name', 'asc')
                ->groupBy('pedidos.user_id', 'users.name')
                ->get();


        }else{

        $pedidos = Pedido::where('laboratorio_id', auth()->user()->laboratorio_id)
                ->whereMonth('created_at', Carbon::now()->month)
                //->whereYear('created_at', Carbon::now()->year)
                ->get();
            foreach ($pedidos as $ped) {
                $totalPedidos += $ped->total;
            }
            $pedidosCancelados = Pedido::where('status', 'Cancelado')
                ->whereBetween('created_at', [$meses, $hoje])
                ->count();

            $pedidos_recentes = Pedido::join('laboratorios', 'laboratorios.id', 'pedidos.laboratorio_id')
                ->select('pedidos.*', 'laboratorios.nome as labNome')
                ->where('laboratorio_id', auth()->user()->laboratorio_id)
                ->orderBY('id', 'Desc')
                ->limit(5)->get();


            $pedidosPendentes = Pedido::where('status', 'Aguardando Impressão')
               ->whereMonth('created_at', Carbon::now()->month)
                //->whereYear('created_at', Carbon::now()->year)
                ->where('laboratorio_id', auth()->user()->laboratorio_id)
                ->count();

            $pedidosConcluidos = Pedido::where('status', 'Finalizado')
                ->whereMonth('created_at', Carbon::now()->month)
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
        }
            return view('painel.home', compact('totalPedidos', 'pedidos_recentes', 'pedidosCancelados', 'pedidos', 'pedidosPendentes', 'pedidosConcluidos', 'clientes'));
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






                if($request->dia != null){
                      $pedidos_recentes = Pedido::join('laboratorios', 'laboratorios.id', 'pedidos.laboratorio_id')
                ->select('pedidos.*', 'laboratorios.nome as labNome')
                 ->where('pedidos.created_at','>', Carbon::now()->subDays($request->dia))
                ->orderBY('id', 'Desc')
                ->limit(5)->get();

                    $pedidos = Pedido::where('created_at','>', Carbon::now()->subDays($request->dia))

                ->get();

            foreach ($pedidos as $pda) {
                $totalPedidos += $pda->total;
            }
            $pedidosPendentes = Pedido::where('status', 'Aguardando Impressão')
            ->where('created_at','>', Carbon::now()->subDays($request->dia))

                ->count();
            $pedidosConcluidos = Pedido::where('status', 'Finalizado')
              ->where('created_at','>', Carbon::now()->subDays($request->dia))
                ->count();

            $pedidosCancelados = Pedido::where('status', 'Cancelado')
             ->where('created_at','>', Carbon::now()->subDays($request->dia))
                ->count();

                }else{

                   $pedidos_recentes = Pedido::join('laboratorios', 'laboratorios.id', 'pedidos.laboratorio_id')
                ->select('pedidos.*', 'laboratorios.nome as labNome')
                ->orderBY('id', 'Desc')
                ->limit(5)->get();

            $pedidos = Pedido::whereBetween('created_at', [$meses, $hoje])

                ->get();

            foreach ($pedidos as $pda) {
                $totalPedidos += $pda->total;
            }
            $pedidosPendentes = Pedido::where('status', 'Aguardando Impressão')
                ->whereBetween('created_at', [$meses, $hoje])

                ->count();
            $pedidosConcluidos = Pedido::where('status', 'Finalizado')
                ->whereBetween('created_at', [$meses, $hoje])
                ->count();

            $pedidosCancelados = Pedido::where('status', 'Cancelado')
                ->whereBetween('created_at', [$meses, $hoje])
                ->count();
                }
            return view('painel.home', compact('totalPedidos', 'pedidosCancelados', 'pedidos_recentes', 'pedidos', 'pedidosPendentes', 'pedidosConcluidos', 'clientes'));
        }
    }
}
