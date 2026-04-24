<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function usuarios(){
        $usuarios= User::all();
        return view('painel.usuario.usuarios', compact('usuarios'));
    }

    public function usuario(){

        return view('painel.usuario.usuario');
    }

    public function store(Request $request){

            $usuario= new User();

            $usuario->fill($request->all());
            $usuario->password = bcrypt($request->password);
            $usuario->save();

        return redirect()->route('usuarios')->with('success', 'Usuario adicionado com sucesso');
    }

    public function edit(Request $request){

        $usuario=User::find($request->id);

        return view('painel.usuario.edit', compact('usuario'));
    }

    public function update(Request $request){
        $usuario = User::find($request->id);

        $usuario->update(['name'=>$request->name,'email'=>$request->email,'nivel'=>$request->nivel,'laboratorio_id'=>$request->laboratorio_id]);

        if ($request->has('password') && $request->password != '') :
            $usuario->password = bcrypt($request->password);
        endif;

        return redirect()->route('usuarios')->with('success', 'usuário atualizado com sucesso');

    }

    public function destroy(Request $request){

        $usuario= User::find($request->id);
        $usuario->delete();

        return redirect()->back()->with("success", 'Usuário excluido com sucesso');
    }

    public function editarCliente(Request $request){



        $cliente=Cliente::find($request->id);
        $usuario=User::find($cliente->user_id);
        $cliente->update([
            'nome'=>$request->nome,
            'cpf'=>$request->cpf,
            'telefone'=>$request->telefone,
            'endereco'=>$request->endereco,
            'bairro'    =>$request->bairro,
            'cidade'    =>$request->cidade,
            'cep'   =>$request->cep,
            'uf'    =>$request->uf,
            'email' =>$request->email
        ]);

            $usuario->update(['name'=>$request->nome,'email'=>$request->email]);

        if ($request->has('password') && $request->password != '') :
            $usuario->update(['password' => bcrypt($request->password)]);
        endif;



        return redirect()->back();




    }

    public function clientes(){

    $clientes=Cliente::paginate(30);

    return view('painel.clientes.index', compact('clientes'));
    }

    public function editCliente(Request $request){

            $cliente=Cliente::find($request->id);


    return view ('painel.clientes.edit', compact('cliente'));


    }

}
