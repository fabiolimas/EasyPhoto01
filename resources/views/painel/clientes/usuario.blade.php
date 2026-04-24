@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Novo Usuário</h1>
@stop

@section('content')
<div class="col-md-6">
    <form method="post" action="{{route('store-user')}}">
        @csrf
        <input type="text" name="name" class="form-control mb-3" placeholder="Nome" required>
        <input type="text" name="email" class="form-control mb-3" placeholder="E-mail" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Senha" required>
        <select name="nivel" class="form-select mb-3" required id="nivel_acesso">
            <option value="">Nivel de Acesso</option>
            <option value="administrador">Administrador</option>
            <option value="laboratorio">Laboratório</option>
            <option value="cliente">Cliente</option>
        </select>
        <select name="laboratorio_id" class="form-select mb-3" id="laboratorio_id" style="display:none">
            <option value="">Selecione a loja</option>
            <option value="1">Jacobina</option>
            <option value="2">Petrolina</option>
        </select>

            <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    <script>
        $('document').ready(function(){

            $("#nivel_acesso").change(function(){

                if($("#nivel_acesso").val() == 'laboratorio'){
                    $("#laboratorio_id").css('display','flex');
                }

            });
        });
    </script>
@stop
