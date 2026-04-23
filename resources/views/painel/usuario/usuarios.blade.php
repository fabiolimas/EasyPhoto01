@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Usuários</h1>
@stop

@section('content')
<a href="{{route('usuario')}}" class="btn btn-success">Adicionar</a>
<hr>
<input type="text" name="busca" id="busca" class="form-control" placeholder="Buscar...">
<div class="row table-responsive">
<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>
        <th scope="col">Email</th>
        <th scope="col">Permissão</th>
        <th scope="col">Ações</th>
      </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $usuario)
      <tr>
        <th scope="row">{{$usuario->id}}</th>
        <td>{{$usuario->name}}</td>
        <td>{{$usuario->email}}</td>
        <td>{{$usuario->nivel}}</td>
        <td><a href="{{route('edit-user', $usuario->id)}}"title="Editar" class="btn btn-success"><i class="fas fa-edit"></i></a> | <a href="{{route("destroy-user", $usuario->id)}}"title="Excluir" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
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
