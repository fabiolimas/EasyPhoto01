@extends('layouts.site')

@section('title', 'Dashboard')

@section('content_header')


@section('content')


    <input type="text" name="busca" id="busca" class="form-control" placeholder="Buscar...">
    <div class="row table-responsive">
    <table class="table result">
        <thead>
            <tr>
                <th scope="col">Pedido</th>
                <th scope="col">Cliente</th>
                <th scope="col">Loja</th>
                <th scope="col">Data</th>
                <th scope="col">Obs.</th>
                <th scope="col">Status Pedido</th>
                <th scope="col">Status Pagamento</th>

                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidos as $pedido)
                <tr>
                    <th scope="row">{{ $pedido->id }}</th>
                    <td>{{ $pedido->cliente }}</td>
                    @switch($pedido->laboratorio_id)
                        @case(1)
                            <td>Jacobina</td>
                        @break

                        @case(2)
                            <td>Petrolina</td>
                        @break

                        @default
                    @endswitch

                    <td>{{ date('d/m/Y H:i', strtotime($pedido->created_at)) }}</td>
                    <td>{{$pedido->observacao}}</td>
                    <td class="@if ($pedido->status == 'Finalizado') text-success @else text-danger @endif">
                        {{ $pedido->status }}</td>
                         <td class="@if ($pedido->status_pagamento == 'pago') text-success @else text-danger @endif">
                        {{ $pedido->status_pagamento }}</td>

                    <td><a href="{{ route('detalhe-pedido', $pedido->id) }}" class="btn btn-danger"><i class="far fa-images"></i> Visualizar</a></td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    {{ $pedidos->links() }}

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).ready(function() {

            var busca = $("#busca");
            var result = $(".result");

            busca.keyup(function() {

                $.ajax({
                    url: "{{ route('busca-pedidos') }}", // Arquivo PHP que processará a busca
                    type: "get",
                    data: {
                        busca: busca.val(),


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
@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>


@stop
@stop
