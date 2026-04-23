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
    public function index()
    {

        if(auth()->user()->nivel == 'cliente'){

            return redirect('/lab');
        }else if(auth()->user()->nivel == 'laboratorio'){
            $pedidos= Pedido::where('laboratorio_id', auth()->user()->laboratorio_id)
           // ->whereMonth('created_at', Carbon::now()->month)
            //->whereYear('created_at', Carbon::now()->year)
            ->get();

            $pedidosPendentes=Pedido::where('status', 'Aguardando Impressão')
            //->whereMonth('created_at', Carbon::now()->month)
            //->whereYear('created_at', Carbon::now()->year)
            ->where('laboratorio_id', auth()->user()->laboratorio_id)
            ->count();

            $pedidosConcluidos=Pedido::where('status', 'Finalizado')
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
            return view('painel.home', compact('pedidos','pedidosPendentes', 'pedidosConcluidos','clientes'));


        }else{

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





    $pedidos = Pedido::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->get();
            $pedidosPendentes=Pedido::where('status', 'Aguardando Impressão')
            ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
            ->count();
            $pedidosConcluidos=Pedido::where('status', 'Finalizado')
           ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)->count();

            return view('painel.home', compact('pedidos','pedidosPendentes', 'pedidosConcluidos','clientes'));
        }

    }


}
