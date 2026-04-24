@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Tamanho</h1>
@stop

@section('content')
<div class="col-md-6">
    <form method="post" action="{{route('update-tamanho', $tamanho->id)}}">
        @csrf
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control mb-3" placeholder="Nome" value="{{$tamanho->nome}}">
        <label for="altura">Altura</label>
        <input type="text" name="altura" id="altura" class="form-control mb-3" placeholder="Altura" value="{{$tamanho->altura}}">

        <label for="largura">Largura</label>
        <input type="text" name="largura" id="largura" class="form-control mb-3" placeholder="Largura" value="{{$tamanho->largura}}">

        <label for="preco">Preço</label>
        <input type="text" name="preco" id="preco" class="form-control mb-3" placeholder="Preço" value="{{$tamanho->preco}}">

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
@stop
