@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Novo Usuário</h1>
@stop

@section('content')
<div class="col-md-6">
    <form method="post" action="{{route('store-forma-entrega')}}">
        @csrf
        <label for="nome">Descrição</label>
        <input type="text" name="nome" class="form-control mb-3" placeholder="Nome" required>
        <label for="valor">Valor</label>
        <input type="text" name="valor" class="form-control mb-3" placeholder="R$ 0,00" required>
        <label for="local">Local Relacionado</label>
        <select class="form-control" name='local' id="local">
            <option value="">Selecione o local de entrega</option>
           @foreach($laboratorios as $laboratorio)
                <option value="{{$laboratorio->id}}">{{$laboratorio->nome}}</option>

           @endforeach
        </select>
        <label for="tipo_entrega">Tipo de entrega</label>
        <select name="tipo_entrega" class="form-select mb-3" id="tipo_entrega" >
            <option value="">Selecione a loja</option>
            <option value="Motoboy">Motoboy</option>
            <option value="Retirar na loja">Retirar na loja</option>
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
