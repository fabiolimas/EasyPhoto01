@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Usuário</h1>
@stop

@section('content')
<div class="col-md-6">
    <form method="post" action="{{route('update-user',$usuario->id)}}">

        @csrf
        <input type="text" name="name" class="form-control mb-3" placeholder="Nome" value="{{$usuario->name}}">
        <input type="text" name="email" class="form-control mb-3" placeholder="E-mail" value="{{$usuario->email}}">
        <input type="password" name="password" class="form-control " placeholder="Senha" value="">
        <span class="text-warning ">caso não queira editar a senha deixe em branco</span>
        <select name="nivel" class="form-select mb-3 mt-3" required id="nivel_acesso">
            <option value="{{$usuario->nivel}}">{{$usuario->nivel}}</option>
            <option value="administrador">Administrador</option>
            <option value="laboratorio">Laboratório</option>
            <option value="cliente">Cliente</option>
        </select>
        <select name="laboratorio_id" class="form-select mb-3" id="laboratorio_id" style="display:none">
            @switch($usuario->laboratorio_id)
                @case(1)
                <option value="1" selected>Jacobina</option>
                <option value="2">Petrolina</option>
                    @break
                @case(2)

            <option value="1">Jacobina</option>
                <option value="2" selected>Petrolina</option>
                    @break
                @default

            @endswitch

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
