<?php

namespace App\Http\Controllers;

use App\Models\Tamanho;
use Illuminate\Http\Request;

class TamanhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tamanhos=Tamanho::all();
        return view('painel.tamanho.tamanhos',compact('tamanhos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('painel.tamanho.tamanho');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tamanho= new Tamanho();

            $tamanho->fill($request->all());

            $tamanho->save();

        return redirect()->route('tamanhos')->with('success', 'Tamanho adicionado com sucesso');
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
    public function edit(Request $request)
    {
        $tamanho=Tamanho::find($request->id);

        return view('painel.tamanho.edit', compact('tamanho'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $tamanho = Tamanho::find($request->id);

        $tamanho->update($request->all());



        return redirect()->route('tamanhos')->with('success', 'Tamanho atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $tamanho= Tamanho::find($request->id);
        $tamanho->delete();

        return redirect()->back()->with("success", 'Tamanho excluido com sucesso');
    }
}
