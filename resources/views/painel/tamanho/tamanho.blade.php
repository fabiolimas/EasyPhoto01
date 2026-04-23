@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Novo Tamanho</h1>
@stop

@section('content')
<div class="col-md-6">
    <form method="post" action="{{route('store-tamanho')}}">
        @csrf
        <input type="text" name="nome" class="form-control mb-3" placeholder="Nome" required>
        <input type="text" name="altura" class="form-control mb-3" placeholder="Altura" required>
        <input type="text" name="largura" class="form-control mb-3" placeholder="Largura" required>
        <input type="text" name="preco" class="form-control mb-3" placeholder="Preço" required>




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
