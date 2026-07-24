@extends('layouts.envio')

@section('title', 'Dashboard')

@section('content_header')


@section('content')
 @include('components.alerts')
<style>
        body {
            background: #f5f6fa;
        }
        .card-pix {
            max-width: 500px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .qr-code {
            max-width: 250px;
            margin: 0 auto;
        }
        .copy-box {
            background: #f1f2f6;
            border-radius: 8px;
            padding: 10px;
            font-size: 13px;
            word-break: break-all;
        }
    </style>
    <input type="text" name="busca" id="busca" class="form-control mb-3" placeholder="Buscar...">
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
                    <td class="">
                        <span
                                        class="chip @if ($pedido->status == 'Finalizado') chip-green @elseif($pedido->status == 'Aguardando Impressão') chip-amber @else chip-red @endif ">{{ $pedido->status }}</span></td>
                         <td >
                       <span class="chip @if ($pedido->status_pagamento == 'pendente') chip-red @else chip-green @endif">
                                        {{ $pedido->status_pagamento }}</span></td>

                    <td><a href="{{ route('detalhe-pedido', $pedido->id) }}" class="btn btn-danger"><i class="bi bi-images"></i> Visualizar</a></td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    {{ $pedidos->links() }}

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
