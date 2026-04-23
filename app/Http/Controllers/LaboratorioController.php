<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use Illuminate\Http\Request;

class LaboratorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $laboratorios=Laboratorio::all();
     return view('painel.laboratorio.laboratorios',compact('laboratorios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


    return view('painel.laboratorio.laboratorio');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $laboratorio= new Laboratorio();

            $laboratorio->fill($request->all());

            $laboratorio->save();

        return redirect()->route('laboratorios')->with('success', 'Laboratório adicionado com sucesso');
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
        $laboratorio=Laboratorio::find($request->id);

        return view('painel.laboratorio.edit', compact('laboratorio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $laboratorio = Laboratorio::find($request->id);

        $laboratorio->update($request->all());



        return redirect()->route('laboratorios')->with('success', 'Laboratório atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $Laboratorio= Laboratorio::find($request->id);
        $Laboratorio->delete();

        return redirect()->back()->with("success", 'Laboratório excluido com sucesso');
    }
}
