@extends('adminlte::page')

@section('title', 'Editar Forma de Entrega')

@section('content_header')
    <h1>Editar Forma de Entrega</h1>
@stop

@section('content')
  @include('components.alerts')
<div class="col-md-6">
    <form id="registerForm" method ="post" action="{{route('update-forma-de-entrega', $forma->id)}}">
        @csrf
        @method('put')

        <div class="row">
        <label for="nome">Descrição</label>
        <input type="text" name="nome" class="form-control mb-3" value="{{$forma->nome}}">
        <label for="valor">Valor R$</label>
        <input type="text" name="valor" class="form-control mb-3" value="{{number_format($forma->valor,2,',','.')}}">
        <label for="local">Local Relacionado</label>
        <select class="form-select mb-3" name='local_relacionado' id="local">
            <option value="{{$laboratorio->id}}">{{$laboratorio->nome}}</option>
            @foreach($laboratorios as $lab)
                    <option value="{{$lab->id}}">{{$lab->nome}}</option>
            @endforeach

        </select>
        <label for="tipo_entrega">Tipo de entrega</label>
        <select name="tipo_entrega" class="form-select mb-3" id="tipo_entrega" >
            <option value="{{$forma->tipo_entrega}}">{{$forma->tipo_entrega}}</option>
            <option value="Motoboy">Motoboy</option>
            <option value="Retirar na loja">Retirar na loja</option>
        </select>
        <div class="form-group">
            <button type="submit" id="salvar" class="btn btn-dark">Salvar</button>
        </div>
    </div>
    </form>
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

    <script>
        $('document').ready(function(){

            if($("#nivel_acesso") == 'laboratorio'){
                $("$laboratorio_id").css('display','none');
            }else{
                $("#laboratorio_id").css('display','flex');
            }

            $("#nivel_acesso").change(function(){

                if($("#nivel_acesso").val() == 'laboratorio'){
                    $("#laboratorio_id").css('display','flex');
                }

            });
        });
    </script>
@stop
