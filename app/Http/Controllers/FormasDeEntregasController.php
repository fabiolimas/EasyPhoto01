<?php

namespace App\Http\Controllers;

use App\Models\FormasEntrega;
use App\Models\Laboratorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormasDeEntregasController extends Controller
{
   public function index(){

   $formas=FormasEntrega::all();


   return view('painel.formas_de_entrega.index', compact('formas'));
   }

   public function create(){

   $laboratorios=Laboratorio::all();

    return view('painel.formas_de_entrega.create', compact('laboratorios'));
   }

   public function edit($id){

    $forma=FormasEntrega::find($id);

    $laboratorios=Laboratorio::all();


   return view('painel.formas_de_entrega.edit', compact('forma','laboratorios'));
   }

   public function store(Request $request){

    $forma = new FormasEntrega();


    $forma->nome= $request->nome;
    $forma->valor=$request->valor;
    $forma->local_relacionado=$request->local;
    $forma->tipo_entrega=$request->tipo_entrega;
    $forma->save();

    if($forma->save()){
        return redirect()->route('formas-de-entrega')->with('success','Forma de entrega cadastrada com sucesso!');
    }else{

        return redirect()->route('formas-de-entrega')->with('error','Falha ao tentar cadastrar forma de entrega!');
    }

   }

   public function update(Request $request, $id){



    $forma=FormasEntrega::find($id);

    $valor=(float)$request->valor;

    $forma->update([
        'nome'=>$request->nome,
        'valor'=>$valor,
        'local_relacionado'=>$request->local_relacionado,
        'tipo_entrega'=>$request->tipo_entrega,
    ]);

    return redirect()->back()->with('success','Forma de entrega alterada com sucesso!');

   }

   public function destroy($id){

   $forma=FormasEntrega::find($id)->delete();

   return redirect()->back()->with('success','Forma de entrega excluida com sucesso!');
   }

   public function buscar($id)
{
    $entrega = DB::table('formas_entregas')->where('id', $id)->first();

    if (!$entrega) {
        return response()->json(['erro' => 'Não encontrada'], 404);
    }

    return response()->json([
        'valor' => $entrega->valor,
        'nome' =>$entrega->nome
    ]);
}
}
