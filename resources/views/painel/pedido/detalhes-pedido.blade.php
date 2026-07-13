@extends('layouts.painel')




@section('content')


    <section class="content">
        <div class="page-head">
            <div>
                <h1 class="page-title">Detalhes do pedido #{{ $pedido->id }}</h1>
                <p class="page-sub">Informações completas do pedido, cliente e itens</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('pedidos') }}" class="btn btn-soft"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
                {{-- <button class="btn btn-soft"><i class="bi bi-printer me-1"></i>Imprimir</button> --}}
            </div>
        </div>

        <div class="row">

               <!-- Detalhes -->


            <div class="row detalhesPedido table-responsive">
                <table class="table table-striped mb-3 mt-3">
                    <tr>
                        <td>Cliente: <b>{{ $pedido->cliente }}</b>
                            <i class="bi bi-search m-2" data-bs-toggle="modal" data-bs-target="#dadosCliente"
                                style="cursor:pointer"></i>
                        </td>
                        <td>Telefone: <b>{{ $cliente->telefone }}</b></td>
                    </tr>
                    <tr>
                        <td>Data: <b>{{ date('d/m/Y H:i', strtotime($pedido->created_at)) }}</b></td>
                        <td>Entrega: <b> {{ $pedido->forma_de_entrega }} </b></td>
                    </tr>
                    <tr>
                        <td>Enviado para: <b>{{ $laboratorio->nome }}</b></td>
                        <td>Pagamento: <b>
                                @if ($pedido->val_entrega == 0 and $pedido->payment_method == null)
                                    Pagamento na Retirada
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


                        <td>ID Pagamento: @if ($payment != null)

                            {{$paymentId = $payment->payment_id}}
                                {{-- {{ $payment->payment_id }} --}}
                            @else


                            {{$paymentId=''}}

                            @endif <a href="{{ route('consultar.pagamento', $paymentId) }}"
                                class="btn btn-success" title="Verificar Pagamento"><i class="bi bi-search"></i></a></td>
                    </tr>

                </table>
            </div>
        </div>

        <div class="row btnAcoes mb-3 mt-3">
            @if ($pedido->status == 'Finalizado')
                <div class="col-md-2 col-sd-6 d-flex justify-content-start">
                    <a href="{{ route('altera-status', $pedido->id) }}" class="btn btn-dark disabled w-100 mt-2"> <i class="bi bi-check-circle"></i> Finalizar</a>
                </div>
            @else
                <div class="col-md-2 col-sd-6 d-flex justify-content-start">
                    <a href="{{ route('altera-status', $pedido->id) }}" class="btn btn-dark w-100 mt-2"> <i class="bi bi-check-circle"></i> Finalizar</a>
                </div>
            @endif
            <div class="col-md-2 col-sd-6 d-flex justify-content-start">
                <a href="{{ route('download-files', $pedido->id) }}" class="btn btn-success w-100 mt-2">
                    <i class="bi bi-download"></i> Baixar</a>
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                <button class="btn btn-danger w-100 mt-2" data-bs-toggle="modal" data-bs-target="#modalPedido"><i class="bi bi-images"></i> Visualizar Fotos</a>
            </div>

        </div>
        <hr>
        <div class="card panel mb-4">
        <div class="panel-head">
          <div>
            <div class="panel-title">Itens do pedido</div>

          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-modern align-middle mb-0">
            <thead>
              <tr>
                <th style="width:80px">Imagem</th>
                <th>Arquivos</th>
                <th>Tamanho</th>
                <th>Cópias</th>
                <th>Valor unitário</th>
                <th>Valor Total</th>
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
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Imagem:
                                                    {{ $item->nome }}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">


                                                <div class="contentMiniatura mt-3">

                                                    <div class="row">


                                                        <div class="imagemMiniatura">
                                                            <img src="{{ Storage::url($item->caminho) }}"
                                                                alt="Selecionar imagens" title="Selecionar Imagens"
                                                                class="w-100" style="cursor: pointer">
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
                            <td>R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                            @php
                                $totalItem = $item->quantidade * $item->preco;
                                $totalPedido += $totalItem;
                            @endphp
                            <td>R$ {{ number_format($totalItem, 2, ',', '.') }}</td>



                            {{-- Modal Visualização --}}
                            <div class="modal fade" id="modalPedido" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Pedido #{{ $pedido->id }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">


                                            <div class="contentModalLab mt-3">

                                                <div class="row">

                                                    @foreach ($itensPedido as $item)
                                                        <div class="imagemPedido">
                                                            <img src="{{ Storage::url($item->caminho) }}"
                                                                alt="Selecionar imagens" title="Selecionar Imagens"
                                                                class="w-100" style="cursor: pointer">
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
                <td></td>
                <td class="fw-semibold">Entrega</td>
                 @if ($pedido->val_entrega == 0 || $pedido->val_entrega == null)
                            <td>{{ $pedido->forma_de_entrega }}</td>
                        @else
                            <th scope="now">R$ {{ number_format($pedido->val_entrega, 2, ',', '.') }}</th>
                        @endif
              </tr>
              <tr class="table-active">
                <td></td>
                <td class="fw-bold">Total</td>
                <td></td>
                <td class="fw-bold">{{ $totalImagens }}</td>
                <td></td>
                <td class="fw-bold">R$ {{ number_format($totalPedido + $pedido->val_entrega, 2, ',', '.') }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>


        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
        </script>


        <!-- Modal1 -->
        <div class="modal fade" id="dadosCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
            aria-hidden="true" style="--bs-modal-width: 900px">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Dados do Cliente</h5>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                Nome: <input type="text" class="form-control" value="{{ $cliente->nome }}" readonly>
                            </div>
                            <div class="col-md-6">
                                Telefone: <input type="text" class="form-control" value="{{ $cliente->telefone }}"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                Endereço: <input type="text" class="form-control" value="{{ $cliente->endereco }}"
                                    readonly>
                            </div>
                            <div class="col-md-2">
                                Bairro: <input type= "text" class="form-control" value="{{ $cliente->bairro }}"
                                    readonly>
                            </div>
                            <div class="col-md-2">
                                Cidade: <input type= "text" class="form-control" value="{{ $cliente->cidade }}"
                                    readonly>
                            </div>
                            <div class="col-md-2">
                                CEP: <input type= "text" class="form-control" value="{{ $cliente->cep }}" readonly>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>

                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="{{ asset('assets/css/admin_custom.css') }}">
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
