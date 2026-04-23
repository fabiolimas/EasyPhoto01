@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Novo Usuário</h1>
@stop

@section('content')
<div class="col-md-6">
    <form method="post" action="{{route('store-lab')}}">
        @csrf
        <input type="text" name="nome" class="form-control mb-3" placeholder="Nome" required>
        <input type="text" name="endereco" class="form-control mb-3" placeholder="Endereço" required>
        <input type="hidden" name="status" value='ativo'>



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
