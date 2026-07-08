@extends('layouts.painel')




@section('content')
    <section class="content">
        <div class="page-head">
            <div>
                <h1 class="page-title">Pedidos</h1>
                <p class="page-sub">Gerencie e acompanhe todos os pedidos do portal</p>
            </div>
            {{-- <div class="page-actions">
                <button class="btn btn-soft"><i class="bi bi-download me-1"></i>Exportar</button>
                <button class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Novo pedido</button>
            </div> --}}
        </div>
        <!-- Mini KPIs -->
        <div class="row g-3 mt-1">
            <div class="col-6 col-xl-3">
                <div class="kpi kpi-1">
                    <div class="kpi-head"><span class="kpi-label">Total</span><span class="kpi-ico"><i
                                class="bi bi-bag"></i></span></div>
                    <div class="kpi-value">{{ $pedidos->count() }}</div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="kpi kpi-2">
                    <div class="kpi-head"><span class="kpi-label">Novos</span><span class="kpi-ico"><i
                                class="bi bi-lightning-charge"></i></span></div>
                    <div class="kpi-value">{{ $pedidosPendentes }}</div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="kpi kpi-5">
                    <div class="kpi-head"><span class="kpi-label">Cancelados</span><span class="kpi-ico"><i
                                class="bi bi-x-circle"></i></span></div>
                    <div class="kpi-value">{{ $pedidosCancelados }}</div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="kpi kpi-4">
                    <div class="kpi-head"><span class="kpi-label">Finalizados</span><span class="kpi-ico"><i
                                class="bi bi-check2-circle"></i></span></div>
                    <div class="kpi-value">{{ $pedidosConcluidos }}</div>
                </div>
            </div>
        </div>
        <div class="filtros mb-3">
            {{-- <input type="text" name="busca" id="busca" class="form-control" placeholder="Buscar..."> --}}


        </div>
        <!-- Filters + Table -->
        <div class="card panel mt-3 mb-4">
            <div class="panel-head flex-wrap gap-2">
                {{-- <div class="d-flex flex-wrap gap-2 align-items-center">
                    <div class="filter-tabs">
                        <button class="ftab active" id="status_todos">Todos <span>{{ $pedidos->count() }}</span></button>
                        <button class="ftab" id="status_novos">Novos <span>{{ $pedidosPendentes }}</span></button>
                        <button class="ftab" id="status_finalizado">Finalizados <span>{{ $pedidosConcluidos }}</span></button>
                        <button class="ftab" id="cancelados">Cancelados <span>{{ $pedidosCancelados }}</span></button>
                    </div>
                </div> --}}
                <div class="d-flex gap-2">
                    <div class="input-icon">
                        <i class="bi bi-search"></i>
                        <input type="text" name ="busca" id="busca" class="form-control form-control-sm"
                            placeholder="Buscar por cliente...">
                    </div>
                    @can('is_admin')
                        <select class="form-select form-select-sm" style="width:auto" name="laboratorio" id="loja">
                            <option>Todos laboratórios</option>
                            @foreach ($laboratorios as $laboratorio)
                                <option value="{{ $laboratorio->id }}">{{ $laboratorio->nome }}</option>
                            @endforeach
                        </select>
                    @endcan
                    <button class="icon-btn"><i class="bi bi-funnel"></i></button>
                </div>
            </div>
            <div class="table-responsive result">
                <table class="table table-modern align-middle mb-0">
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
                        @foreach ($pedidos as $pedido)
                            <tr>
                                @php

                                    $nome = $pedido->cliente;

                                    $iniciais = mb_strstr($nome, ' ', true)[0] . trim(mb_strstr($nome, ' ')[1]);

                                @endphp
                                <th scope="row"><a
                                        href="{{ route('detalhes-pedidos-admin', $pedido->id) }}">{{ $pedido->id }}</th>
                                <td>
                                    <div class="cell-user">
                                        <div class="avatar xs">{{ $iniciais }}</div>{{ $pedido->cliente }}
                                    </div>
                                </td>
                                <td>{{ date('d/m/Y H:i', strtotime($pedido->created_at)) }}</td>
                                <td>{{ $pedido->observacao }}</td>
                                <td><span
                                        class="chip @if ($pedido->status == 'Finalizado') chip-green @elseif($pedido->status == 'Aguardando Impressão') chip-amber @else chip-red @endif ">{{ $pedido->status }}</span>
                                </td>

                                <td><span class="chip @if ($pedido->status_pagamento == 'pendente') chip-red @else chip-green @endif">
                                        {{ $pedido->status_pagamento }}</span></td>

                                <td class="text-end">
                                    <button class="icon-btn sm" title="Ver"><a
                                            href="{{ route('detalhes-pedidos-admin', $pedido->id) }}"><i
                                                class="bi bi-eye"></i></a></button>
                                    <div class="dropdown">
                                        <button type="button" class="icon-btn sm " data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('download-files', $pedido->id) }}">Baixar</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('altera-status', $pedido->id) }}">Finalizar</a></li>

                                        </ul>
                                    </div>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $pedidos->links() }}
    </section>
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

            var status='';





            busca.keyup(function() {



                $.ajax({
                    url: "{{ route('busca-pedidos-admin') }}", // Arquivo PHP que processará a busca
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

            /*filtro loja*/

            $('#loja').change(function() {



                $.ajax({
                    url: "{{ route('busca-pedidos-admin-lab') }}", // Arquivo PHP que processará a busca
                    type: "get",
                    data: {
                        loja: $('#loja').val(),


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
