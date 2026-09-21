@extends('layouts.painel')


@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


     <div class="page-head">
        <div>
          <h1 class="page-title">Dashboard</h1>
          <p class="page-sub">Visão geral dos pedidos e desempenho do portal</p>
        </div>
        <div class="page-actions">
          <div class="btn-group">
            <button class="btn btn-soft "><a href="{{route('home',1)}}">Hoje</a></button>
            <button class="btn btn-soft"><a href="{{route('home', 7)}}">7 dias</a></button>
            <button class="btn btn-soft"><a href="{{route('home', 30)}}">30 dias</a></button>
            <button class="btn btn-soft"><a href="{{route('home', 90)}}">90 dias</a></button>

            <div class="dropdown">
<button type="button" class="btn btn-soft btn-primary text-white" data-bs-toggle="dropdown">
Periodo
</button>
<ul class="dropdown-menu p-2">
<li><label for="inicio">Inicio *</label>
    <input type="date" name="inicio" class="form-control" id="inicio" required></li>
<li>
    <label for="fim">Fim *</label>
    <input type="date" name="fim" class="form-control" id="fim" required></li>
    <li><button class="btn btn-primary text-center m-2" id="btnPeriodo">Confirmar</button></li>

</ul>
</div>
          </div>
          {{-- <button class="btn btn-primary"><i class="bi bi-download me-1"></i>Exportar</button> --}}
        </div>
      </div>
      <!-- KPI Cards -->
      <div class="row g-3 mt-1">
        <div class="col-12 col-md-6 col-xl-3">
          <div class="kpi kpi-1">
            <div class="kpi-head">
              <span class="kpi-label">Total de Pedidos</span>
              <span class="kpi-ico"><i class="bi bi-bag"></i></span>
            </div>
            <div class="kpi-value" id="totalPedidos">{{$pedidos->count()}}</div>
            <div class="kpi-foot">
              {{-- <span class="trend up"><i class="bi bi-arrow-up-right"></i> 12,4%</span> --}}
              <a href="{{route('pedidos')}}">Ver detalhes <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
          <div class="kpi kpi-2">
            <div class="kpi-head">
              <span class="kpi-label">Novos Pedidos</span>
              <span class="kpi-ico"><i class="bi bi-lightning-charge"></i></span>
            </div>
            <div class="kpi-value" id="pedidosPendentes">{{$pedidosPendentes}}</div>
            <div class="kpi-foot">
              {{-- <span class="trend up"><i class="bi bi-arrow-up-right"></i> 5,1%</span> --}}
              <a href="{{route('pedidos')}}">Ver detalhes <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
          <div class="kpi kpi-3">
            <div class="kpi-head">
              <span class="kpi-label">Pedidos Finalizados</span>
              <span class="kpi-ico"><i class="bi bi-check2-circle"></i></span>
            </div>
            <div class="kpi-value" id="pedidosConcluidos">{{$pedidosConcluidos}}</div>
            <div class="kpi-foot">
              {{-- <span class="trend up"><i class="bi bi-arrow-up-right"></i> 8,7%</span> --}}
              <a href="{{route('pedidos')}}">Ver detalhes <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
          <div class="kpi kpi-4">
            <div class="kpi-head">
              <span class="kpi-label">Receita do mês</span>
              <span class="kpi-ico"><i class="bi bi-currency-dollar"></i></span>
            </div>
            <div class="kpi-value" id="totalPedidosValor">R$ {{number_format($totalPedidos,2,',','.')}}</div>
            <div class="kpi-foot">
              {{-- <span class="trend down"><i class="bi bi-arrow-down-right"></i> 2,3%</span> --}}
              <a href="#"> <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
      <!-- Chart + Side panel -->
      <div class="row g-3 mt-1">


        <div class="col-12 col-xl-4">
          <div class="card panel h-100">
            <div class="panel-head">
              <div>
                <h2 class="panel-title">Status dos pedidos</h2>
                <p class="panel-sub">Distribuição atual</p>
              </div>
            </div>
            <div class="panel-body">
              <div class="donut-wrap">
                <canvas id="statusChart"></canvas>
                <div class="donut-center">
                  <div class="donut-value" id="chartTotalPedidos">{{$pedidos->count()}}</div>
                  <div class="donut-label">Total</div>
                </div>
              </div>
              <ul class="legend">

                <li><span class="sw" style="background:#f59e0b" ></span>Aguardando Impressão<b id="chartPendentes">{{$pedidosPendentes}}</b></li>
                <li><span class="sw" style="background:#22c55e"></span>Finalizados<b id="chartConcluidos">{{$pedidosConcluidos}}</b></li>
                <li><span class="sw" style="background:#e20909"></span>Cancelados<b id="chartCancelados">{{$pedidosCancelados}}</b></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-8">
          <div class="card panel">
            <div class="panel-head">
              <div>
                <h2 class="panel-title">Pedidos recentes</h2>
                <p class="panel-sub">Últimas movimentações do portal</p>
              </div>
              <a href="{{route("pedidos")}}" class="link-arrow">Ver todos <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
              <table class="table table-modern align-middle mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Laboratório</th>
                    <th>Obs.</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                @foreach($pedidos_recentes as $recente)

                @php
                    $nome = $recente->cliente;
                    $iniciais = strstr($nome, ' ', true)[0] . trim(strstr($nome, ' ')[1]);

                @endphp
                  <tr>
                    <td class="text-muted">#{{$recente->id}}</td>
                    <td><div class="cell-user"><div class="avatar xs">{{$iniciais}}</div> {{ mb_convert_case($recente->cliente, MB_CASE_TITLE, "UTF-8") }}</div></td>
                    <td>{{$recente->labNome}}</td>
                    <td>{{$recente->observacao}}</td>
                    <td class="fw-semibold">{{number_format($recente->total,2, ',','.')}}</td>
                    <td><span class="chip @if($recente->status == 'Finalizado') chip-green @elseif($recente->status == 'Aguardando Impressão') chip-amber @else chip-red @endif ">{{$recente->status}}</span></td>
                    <td class="text-end">
                        <div class="dropdown">
<button type="button" class="icon-btn sm " data-bs-toggle="dropdown">
<i class="bi bi-three-dots"></i>
</button>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="{{route('detalhes-pedidos-admin', $recente->id)}}">Detalhes</a></li>
<li><a class="dropdown-item" href="{{route('altera-status',$recente->id)}}">Finalizar</a></li>
<li><a class="dropdown-item" href="{{route('download-files',$recente->id)}}">Baixar</a></li>
</ul>
</div>

                        </td>
                  </tr>
                  @endforeach

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    // Status chart (doughnut)
const sc = document.getElementById('statusChart');

if (sc && window.Chart) {

    statusChart = new Chart(sc, {
        type: 'doughnut',

        data: {
            labels: [
                'Aguardando Impressão',
                'Finalizados',
                'Cancelados'
            ],

            datasets: [{
                data: [
                    {{ $pedidosPendentes }},
                    {{ $pedidosConcluidos }},
                    {{ $pedidosCancelados }}
                ],

                backgroundColor: [
                    '#f59e0b',
                    '#22c55e',
                    '#e20909'
                ],

                borderWidth: 0,
                hoverOffset: 6
            }]
        },

        options: {
            cutout: '72%',

            plugins: {
                legend: {
                    display: false
                },

                tooltip: {
                    backgroundColor: '#0f172a',
                    padding: 10,
                    cornerRadius: 8
                }
            }
        }
    });
}


$('#btnPeriodo').click(function(e) {

    e.preventDefault();

    let inicio = $('#inicio').val();
    let fim = $('#fim').val();

    if (!inicio || !fim) {
        alert('Selecione o período inicial e final.');
        return;
    }

    if (inicio > fim) {
        alert('A data inicial não pode ser maior que a data final.');
        return;
    }

    $.ajax({

        url: "{{ route('home') }}",

        type: "GET",

        dataType: "json",

        data: {
            inicio: inicio,
            fim: fim
        },

        beforeSend: function() {

            $('#btnPeriodo')
                .prop('disabled', true)
                .text('Carregando...');
        },

        success: function(response) {

            console.log('Dados do período:', response);

            /*
             * =========================
             * CARDS
             * =========================
             */

            $('#totalPedidos').text(response.totalPedidos);

            $('#pedidosPendentes').text(response.pedidosPendentes);

            $('#pedidosConcluidos').text(response.pedidosConcluidos);

            $('#totalPedidosValor').text(
                'R$ ' + Number(response.totalPedidosValor)
                    .toLocaleString('pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
            );


            /*
             * =========================
             * GRÁFICO
             * =========================
             */

            $('#chartTotalPedidos').text(response.totalPedidos);

            $('#chartPendentes').text(response.pedidosPendentes);

            $('#chartConcluidos').text(response.pedidosConcluidos);

            $('#chartCancelados').text(response.pedidosCancelados);


            if (statusChart) {

                statusChart.data.datasets[0].data = [
                    response.pedidosPendentes,
                    response.pedidosConcluidos,
                    response.pedidosCancelados
                ];

                statusChart.update();
            }


            /*
             * =========================
             * FECHA O DROPDOWN
             * =========================
             */

            $('.dropdown-menu').removeClass('show');

        },

        error: function(xhr) {

            console.log('Erro:', xhr);

            if (xhr.responseJSON && xhr.responseJSON.message) {

                alert(xhr.responseJSON.message);

            } else {

                alert('Erro ao buscar os dados do período.');
            }
        },

        complete: function() {

            $('#btnPeriodo')
                .prop('disabled', false)
                .text('Confirmar');
        }

    });

});
</script>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
