@extends('layouts.envio')

@section('title', 'Dashboard')

@section('content_header')


@section('content')

    <style>
        body {
            background: #f5f6fa;
        }

        .card-pix {
            max-width: 500px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
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
    <div class="row">
        <h4>Detalhes do pedido #{{ $pedido->id }}</h4>
        <div class="row detalhesPedido">
            <table class="table table-striped mb-3 mt-3">
                <tr>
                    <td>Cliente: <b>{{ mb_convert_case($pedido->cliente, MB_CASE_TITLE, 'UTF-8') }}</b></td>
                    <td>Telefone: <b>{{ $cliente->telefone }}</b></td>
                </tr>
                <tr>
                    <td>Data: <b>{{ date('d/m/Y H:i', strtotime($pedido->created_at)) }}</b></td>
                    <td>Entrega: <b> {{ $pedido->forma_de_entrega }} </b></td>
                </tr>
                <tr>
                    <td>Enviado para: <b>{{ $laboratorio->nome }}</b></td>
                    <td>Pagamento: <b>
                            @if ($pedido->payment_method == null)
                                Aguardando pagamento
                            @else
                                {{ $pedido->payment_method }}
                            @endif
                        </b></td>
                </tr>
                <tr>
                    <td>Observação: <span class="text-danger"><b>{{ $pedido->observacao }}</b></span></td>
                    <td class="">Status Pagamento: <span
                            class="@if ($pedido->status_pagamento == 'pago') text-success @else text-danger @endif"><b>{{ $pedido->status_pagamento }}</b>
                    </td>
                </tr>
                <tr>
                    <td class="">Status do pedido: <span
                            class="@if ($pedido->status == 'Finalizado') text-success @else text-danger @endif"><b>{{ $pedido->status }}</b>
                    </td>
                    {{-- <td>ID Pagamento: @if ($payment->payment_id != null){{$payment->payment_id}}@else @endif</td> --}}
                </tr>

            </table>
        </div>
    </div>
    <div class="row btnAcoes mb-3 mt-3">
        <div class="col-md-3  offset-sd-1">
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalPedido"><i class="bi bi-images"></i>
                Visualizar Fotos</button>


        </div>
        <div class="col-md-3  offset-sd-2">
            <a href="{{ route('cancelar-pedido', $pedido->id) }}" class="btn btn-warning">
                <i class="bi bi-x-circle"></i> Cancelar Pedido
            </a>


        </div>

        @if ($pedido->status_pagamento === 'pendente' && !empty($cliente?->cpf))
            <div class="col-md-3  offset-md-3 d-flex mt-2">
                <a href="{{ route('pagamento.escolha', $pedido->id) }}" class="btn btn-success">
                    <i class="bi bi-bag"></i> Fazer Pagamento
                </a>
            </div>
        @elseif(empty($cliente?->cpf))
            <div class="col-md-3  offset-md-3 d-flex mt-2">

                <a href="{{ route('meus-dados', ['id' => Auth::user()->id]) }}" class="btn btn-warning">
                    <i class="bi bi-floppy"></i> Fazer Pagamento
                </a>
            </div>
        @endif

    </div>
    <hr>
    <div class="row table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    {{-- <th scope="col">Imagem</th> --}}
                    <th scope="col">Arquivos</th>
                    <th scope="col">Tamanho</th>
                    <th scope="col">Cópias</th>
                    <th scope="col">Valor unitário</th>
                    <th scope="col">Valor Total</th>

                </tr>
            </thead>
            <tbody>
                                      @php
    $modalIndex = 0;
@endphp

@foreach ($itensPedido as $tamanho => $itens)

    {{-- Cabeçalho do grupo --}}
    <tr>
        <td colspan="6" class="bg-light">
            <h5 class="m-3">
                {{ $tamanho }}
            </h5>
        </td>
    </tr>

    {{-- Itens do grupo --}}
    @foreach ($itens as $item)

        @php
            $modalIndex++;
            $totalItem = $item->quantidade * $item->preco;
            $totalPedido += $totalItem;
        @endphp

        <tr>
            {{-- <td>
                <div class="minImagem"
                    data-bs-toggle="modal"
                    data-bs-target="#modalMiniatura-{{ $modalIndex }}">

                    <img src="{{ Storage::url($item->caminho) }}"
                        alt="Selecionar imagens"
                        title="Selecionar Imagens"
                        class="w-100"
                        style="cursor: pointer">

                </div>

                {{-- Modal Miniatura --}}
                {{-- <div class="modal fade"
                    id="modalMiniatura-{{ $modalIndex }}"
                    tabindex="-1"
                    aria-labelledby="modalLabel-{{ $modalIndex }}"
                    aria-hidden="true">

                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">

                                <h1 class="modal-title fs-5"
                                    id="modalLabel-{{ $modalIndex }}">
                                    Imagem: {{ $item->nome }}
                                </h1>

                                <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                                </button>

                            </div>

                            <div class="modal-body">

                                <div class="contentMiniatura mt-3">

                                    <div class="row">

                                        <div class="imagemMiniatura">
                                            <img src="{{ Storage::url($item->caminho) }}"
                                                alt="Selecionar imagens"
                                                title="Selecionar Imagens"
                                                class="w-100"
                                                style="cursor: pointer">
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </td> --}}

            <td>{{ $item->nome }}</td>

            <td>{{ $item->tamanho }}</td>

            <td>{{ $item->quantidade }}</td>

            <td>
                R$ {{ number_format($item->preco, 2, ',', '.') }}
            </td>

            <td>
                R$ {{ number_format($totalItem, 2, ',', '.') }}
            </td>

        </tr>

    @endforeach

@endforeach
                <tr>

                    <td></td>
                    <td></td>
                    <td></td>
                    <th scope="now">Entrega</th>
                    @if ($pedido->val_entrega == 0 || $pedido->val_entrega == null)
                        <td>{{ $pedido->forma_de_entrega }}</td>
                    @else
                        <th scope="now">R$ {{ number_format($pedido->val_entrega, 2, ',', '.') }}</th>
                    @endif
                </tr>
                <tr>
                    <th scope="now">Total</td>
                    <td></td>
                    <td></td>
                    <td>{{ $totalImagens }}</td>
                    <td></td>
                    <th scope="now">R$ {{ number_format($totalPedido + $pedido->val_entrega, 2, ',', '.') }}</th>
                </tr>



            </tbody>
        </table>

        <div class="modal fade" id="modalPedido" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Pedido #{{ $pedido->id }}
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <div class="contentModalLab mt-3">

                            <div class="row">


                                @foreach ($itensPedido as $tamanho => $itens)
                                                            <div class="col-12 m-3">
                                                                <h5>{{ $tamanho }}</h5>
                                                            </div>

                                                            @foreach ($itens as $item)
                                                                <div class="imagemPedido col-md-4">
                                                                    <img src="{{ Storage::url($item->caminho) }}"
                                                                        alt="Selecionar imagens" title="Selecionar Imagens"
                                                                        class="w-100" style="cursor: pointer">
                                                                </div>
                                                            @endforeach
                                                        @endforeach


                            </div>
                        </div>
                    </div>
                    {{-- <div class="modal-footer">


                            <button type="button" class="btn btn-danger">Selecionar imagens</button>

                         </div> --}}
                </div>
            </div>
        </div>


    </div>

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
