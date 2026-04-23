@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Pedidos</h1>
@stop

@section('content')
<div class="filtros mb-3">
    <input type="text" name="busca" id="busca" class="form-control" placeholder="Buscar...">
    <div class="row mt-3 mt-3">
        @can('is_admin')
        <div class="col-md-3">
            <label for="loja">Laboratorio:</label>
            <select name="laboratorio" class="form-select" id="loja">
            <option value="">Todos</option>
            @foreach($laboratorios as $laboratorio)
            <option value="{{$laboratorio->id}}">{{$laboratorio->nome}}</option>
            @endforeach
        </select></div>
        @endcan
    </div>

</div>

<div class="row table-responsive">
<table class="table table-striped table-hover result" >
    <thead>
      <tr>
        <th scope="col">Pedido</th>
        <th scope="col">Cliente</th>
        <th scope="col">Data</th>
        <th scope="col">Obs.</th>
        <th scope="col">Status Pedido</th>
        <th scope="col">Status Pagamento</th>
         <th scope="col">Opções</th>
      </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $pedido)
      <tr>
        <th scope="row"><a href="{{route('detalhes-pedidos-admin', $pedido->id)}}">{{$pedido->id}}</th>
        <td>{{$pedido->cliente}}</td>
        <td>{{date('d/m/Y H:i', strtotime($pedido->created_at))}}</td>
        <td>{{$pedido->observacao}}</td>
        <td class="@if($pedido->status=='Aguardando Impressão') text-danger @else text-success @endif">{{$pedido->status}}</td>
        <td class="@if($pedido->status_pagamento == 'Aguardando Pagamento') text-danger @else text-success @endif">{{$pedido->status_pagamento}}</td>

        <td><a href="{{route('download-files',$pedido->id)}}"><i class="fa fa-user-pen"></i> <i class="fas fa-download"></i></a> | <a href="{{route('altera-status', $pedido->id)}}"><i class="fas fa-check-circle"></i></a></td>
      </tr>
      @endforeach
    </tbody>

  </table>
</div>
  {{ $pedidos->links() }}

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>

    <script>
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).ready(function() {




var busca=$("#busca");
var result=$(".result");



busca.keyup(function() {



    $.ajax({
        url: "{{ route('busca-pedidos-admin') }}", // Arquivo PHP que processará a busca
        type: "get",
        data: {
           busca:busca.val(),


        }, // Dados a serem enviados para o servidor
        success: function(response) {

            result.html(response);
            result.html(response.result);
        },
        error: function(result) {
            console.log(result);
        }



    });
});

/*filtro loja*/

$('#loja').change(function() {



$.ajax({
    url: "{{ route('busca-pedidos-admin-lab') }}", // Arquivo PHP que processará a busca
    type: "get",
    data: {
       loja:$('#loja').val(),


    }, // Dados a serem enviados para o servidor
    success: function(response) {

        result.html(response);
        result.html(response.result);
    },
    error: function(result) {
        console.log(result);
    }



});
});


});



    </script>
@stop
