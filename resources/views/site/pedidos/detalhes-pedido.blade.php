@extends('layouts.site')

@section('title', 'Dashboard')

@section('content_header')


@section('content')

    <div class="row">
        <h4>Detalhes do pedido #{{ $pedido->id }}</h4>
        <div class="row detalhesPedido">
            <table class="table table-striped mb-3 mt-3">
                <tr>
                    <td>Cliente: <b>{{ $pedido->cliente }}</b></td>
                </tr>
                <tr>
                    <td>Data: <b>{{ date('d/m/Y H:i', strtotime($pedido->created_at)) }}</b></td>
                </tr>
                <tr>
                    <td>Enviado para: <b>{{ $laboratorio->nome}}</b></td>
                </tr>
                <tr>
                    <td >Observação: <span class="text-danger"><b>{{ $pedido->observacao }}</b></span></td>
                </tr>
                <tr>
                    <td class="">Status do pedido: <span class="@if($pedido->status =='Finalizado') text-success @else text-danger @endif"><b>{{ $pedido->status }}</b></td>
                </tr>
                   <tr>
                    <td class="">Status Pagamento: <span class="@if($pedido->status_pagamento =='pago') text-success @else text-danger @endif"><b>{{ $pedido->status_pagamento }}</b></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row btnAcoes mb-3 mt-3">
        <div class="col-md-3 offset-md-10 offset-sd-1">
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalPedido"><i class="far fa-images"></i> Visualizar Fotos</a>
        </div>

    </div>
    <hr>
<div class="row table-responsive">
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Imagem</th>
                <th scope="col">Arquivos</th>
                <th scope="col">Tamanho</th>
                <th scope="col">Cópias</th>
                <th scope="col">Valor unitário</th>
         <th scope="col">Valor Total</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($itensPedido as $item)
                <tr>
                    <td>
                        <div class="minImagem" data-bs-toggle="modal"
                            data-bs-target="#modalMiniatura-{{ $loop->index + 1 }}">
                            <img src="{{ Storage::url($item->caminho) }}" alt="Selecionar imagens"
                                title="Selecionar Imagens" class="w-100" style="cursor: pointer">

                        </div>
                        {{-- Modal Miniatura --}}
                        <div class="modal fade" id="modalMiniatura-{{ $loop->index + 1 }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Imagem: {{ $item->nome }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">


                                        <div class="contentMiniatura mt-3">

                                            <div class="row">


                                                <div class="imagemMiniatura">
                                                    <img src="{{ Storage::url($item->caminho) }}" alt="Selecionar imagens"
                                                        title="Selecionar Imagens" class="w-100" style="cursor: pointer">
                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="modal-footer">


                            <button type="button" class="btn btn-danger">Selecionar imagens</button>

                         </div> --}}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $item->nome }}</td>
                    <td>{{ $item->tamanho }}</td>
                    <td>{{ $item->quantidade }}</td>
                    <td>R$ {{number_format($item->preco,2,',','.')}}</td>
                    @php
                        $totalItem=$item->quantidade*$item->preco;
                        $totalPedido+=$totalItem;
                    @endphp
                    <td>R$ {{number_format($totalItem,2,',','.')}}</td>



                    {{-- Modal Visualização --}}
                    <div class="modal fade" id="modalPedido" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                 <div class="modal-header">
                             <h1 class="modal-title fs-5" id="exampleModalLabel">Pedido #{{ $pedido->id }}</h1>
                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                                <div class="modal-body">


                                    <div class="contentModalLab mt-3">

                                        <div class="row">

                                            @foreach ($itensPedido as $item)
                                                <div class="imagemPedido">
                                                    <img src="{{ Storage::url($item->caminho) }}" alt="Selecionar imagens"
                                                        title="Selecionar Imagens" class="w-100" style="cursor: pointer">
                                                </div>
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

                </tr>
            @endforeach
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <th scope="now">Entrega</th>
                @if($pedido->val_entrega == 0 || $pedido->val_entrega == null)
                <td>Retirar na loja</td>
                @else
                <th scope="now">R$ {{number_format($pedido->val_entrega,2,',','.')}}</th>
                @endif
            </tr>
            <tr>
                <th scope="now">Total</td>
                <td></td>
                <td></td>
                <td>{{ $totalImagens }}</td>
                <td></td>
                <th scope="now">R$ {{number_format($totalPedido+$pedido->val_entrega,2,',','.')}}</th>
            </tr>



        </tbody>
    </table>

 @if($pedido->status_pagamento === 'pendente' && !empty($cliente?->cpf))
    <div class="col-md-3 offset-9 d-flex justify-content-end">
        <a href="/cielo/{{ $pedido->id }}" class="btn btn-success">
            <i class="fa-solid fa-cart-arrow-down"></i> Finalizar compra
        </a>
    </div>

    @elseif(empty($cliente?->cpf))

        <div class="col-md-3 offset-9 d-flex justify-content-end">

        <a href="{{ route('meus-dados', ['id'=>Auth::user()->id]) }}" class="btn btn-warning">
            <i class="fa-solid fa-save"></i> Finalizar Cadastro
        </a>
    </div>

@endif
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
