@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Laboratórios</h1>
@stop

@section('content')
<a href="{{route('laboratorio')}}" class="btn btn-success">Adicionar</a>
<hr>
<div class="row">

<input type="text" name="busca" id="busca" class="form-control" placeholder="Buscar...">
</div>
<div class="row table-responsive mt-2">
<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>
        <th scope="col">Endereço</th>
         <th scope="col">Ações</th>
      </tr>
    </thead>
    <tbody>
        @foreach($laboratorios as $laboratorio)
      <tr>
        <th scope="row">{{$laboratorio->id}}</th>
        <td>{{$laboratorio->nome}}</td>
        <td>{{$laboratorio->endereco}}</td>

        <td><a href="{{route('edit-lab', $laboratorio->id)}}" title="Editar" class="btn btn-success"><i class="fas fa-edit"></i></a> | <a href="{{route("destroy-lab", $laboratorio->id)}}" title="Excluir" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
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
