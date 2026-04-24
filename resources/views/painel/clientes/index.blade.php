@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')

<hr>
<input type="text" name="busca" id="busca" class="form-control" placeholder="Buscar...">
<div class="row table-responsive">
<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>
        <th scope="col">Email</th>
         <th scope="col">Telefone</th>
         <th scope="col">Cidade</th>

        <th scope="col">Ações</th>
      </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente)
      <tr>
        <th scope="row">{{$cliente->id}}</th>
        <td>{{$cliente->nome}}</td>
        <td>{{$cliente->email}}</td>
        <td>{{$cliente->telefone}}</td>
        <td>{{$cliente->cidade}}</td>
        <td><a href="{{route('edit-cliente', $cliente->id)}}"title="Editar" class="btn btn-success"><i class="fas fa-edit"></i></a> </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
