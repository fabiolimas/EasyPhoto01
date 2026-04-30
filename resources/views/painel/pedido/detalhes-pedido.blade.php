@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

@section('content')

    <div class="row">
        <h4>Detalhes do pedido #{{ $pedido->id }}</h4>
        <div class="row detalhesPedido table-responsive">
              <table class="table table-striped mb-3 mt-3">
                <tr>
                    <td>Cliente: <b>{{ $pedido->cliente }}</b></td><td>Telefone: <b>{{$cliente->telefone}}</b></td>
                </tr>
                <tr>
                    <td>Data: <b>{{ date('d/m/Y H:i', strtotime($pedido->created_at)) }}</b></td><td>Entrega: <b> {{$pedido->forma_de_entrega}} </b></td>
                </tr>
                <tr>
                    <td>Enviado para: <b>{{ $laboratorio->nome}}</b></td><td>Pagamento: <b> @if($pedido->val_entrega == 0 and $pedido->payment_method == null) Pagamento na Retirada @else {{$pedido->payment_method}} @endif </b></td>
                </tr>
                <tr>
                    <td >Observação: <span class="text-danger"><b>{{ $pedido->observacao }}</b></span></td> <td class="">Status Pagamento: <span class="@if($pedido->status_pagamento =='pago') text-success @else text-danger @endif"><b>{{ $pedido->status_pagamento }}</b></td>
                </tr>
                <tr>
                    <td class="">Status do pedido: <span class="@if($pedido->status =='Finalizado') text-success @else text-danger @endif"><b>{{ $pedido->status }}</b></td><td></td>
                </tr>

            </table>
        </div>
    </div>
    <div class="row btnAcoes mb-3 mt-3">
        @if($pedido->status == 'Finalizado')
        <div class="col-md-2 col-sd-6 d-flex justify-content-start">
            <a href="{{route('altera-status',$pedido->id)}}" class="btn btn-dark disabled w-100 mt-2"> <i class="fas fa-check-circle"></i> Finalizar</a>
            </div>
        @else
        <div class="col-md-2 col-sd-6 d-flex justify-content-start">
            <a href="{{route('altera-status',$pedido->id)}}" class="btn btn-dark w-100 mt-2" > <i class="fas fa-check-circle"></i> Finalizar</a>
            </div>
            @endif
            <div class="col-md-2 col-sd-6 d-flex justify-content-start">
                <a href="{{route('download-files',$pedido->id)}}" class="btn btn-success w-100 mt-2">
              <i class="fas fa-download "></i> Baixar</a>
                </div>
        <div class="col-md-8 d-flex justify-content-end">
        <button class="btn btn-danger w-100 mt-2" data-bs-toggle="modal" data-bs-target="#modalPedido"><i class="far fa-images"></i> Visualizar Fotos</a>
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
                <td>{{$pedido->forma_de_entrega}}</td>
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
</div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
@stop
@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="{{asset('assets/css/admin_custom.css')}}">
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
@stop
