@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Laboratório</h1>
@stop

@section('content')
<div class="col-md-6">
    <form method="post" action="{{route('update-lab', $laboratorio->id)}}">
        @csrf
        <input type="text" name="nome" class="form-control mb-3" placeholder="Nome" value="{{$laboratorio->nome}}">
        <input type="text" name="endereco" class="form-control mb-3" placeholder="Endereço" value="{{$laboratorio->endereco}}">



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
