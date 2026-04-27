@extends('adminlte::page')

@section('title', 'Formas de Entrega')

@section('content_header')
    <h1>Formas de Entrega</h1>
@stop

@section('content')
 @include('components.alerts')
<a href="{{route('forma-de-entrega')}}" class="btn btn-success">Adicionar</a>

<hr>

<div class="row table-responsive">
<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>


        <th scope="col">Ações</th>
      </tr>
    </thead>
    <tbody>
        @foreach($formas as $forma)
      <tr>
        <th scope="row">{{$forma->id}}</th>
        <td>{{$forma->nome}}</td>

        <td><a href="{{route('edit-forma-de-entrega', $forma->id)}}"title="Editar" class="btn btn-success"><i class="fas fa-edit"></i></a>| <a href="{{route("delete-forma-de-entrega", $forma->id)}}" title="Excluir" class="btn btn-danger"><i class="fas fa-trash"></i></a> </td>
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
