@extends('layouts.painel')



@section('content')
<section class="content">
        <div class="page-head">
            <div>
                <h1 class="page-title">Clientes</h1>
                <p class="page-sub">Gerencie e acompanhe clientes do portal</p>
            </div>
            <div class="page-actions">

                {{-- <a href="{{route('')}}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Novo cliente</a> --}}
            </div>
        </div>

<div class="card panel mt-3 mb-4">
            <div class="panel-head flex-wrap gap-2">

                <div class="d-flex gap-2">
                    <div class="input-icon">
                        <i class="bi bi-search"></i>
                        <input type="text" id="busca" name="busca" class="form-control form-control-sm"
                            placeholder="Buscar usuário...">
                    </div>
                    <button class="icon-btn"><i class="bi bi-funnel"></i></button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
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
        <td><a href="{{route('edit-cliente', $cliente->id)}}"title="Editar" class="btn btn-success"><i class="bi bi-pencil"></i></a> </td>
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
