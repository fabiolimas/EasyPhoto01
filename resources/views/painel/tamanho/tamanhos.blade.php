@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Tamanhos de Fotos</h1>
@stop

@section('content')
<a href="{{route('tamanho')}}" class="btn btn-success">Adicionar</a>
<hr>
<input type="text" name="busca" id="busca" class="form-control" placeholder="Buscar...">

<table class="table mt-2">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>
        <th scope="col">Preço</th>
         <th scope="col">Ações</th>
      </tr>
    </thead>
    <tbody>
        @foreach($tamanhos as $tamanho)
      <tr>
        <th scope="row">{{$tamanho->id}}</th>
        <td>{{$tamanho->nome}}</td>
        <td>R$ {{number_format($tamanho->preco,2,',','.')}}</td>

        <td><a href="{{route('edit-tamanho', $tamanho->id)}}" class="btn btn-success" title="Editar"><i class="fas fa-edit"></i></a> | <a href="{{route("destroy-tamanho", $tamanho->id)}}" class="btn btn-danger" title="Excluir"><i class="fas fa-trash"></i> </a></td>
      </tr>
      @endforeach
    </tbody>
  </table>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
