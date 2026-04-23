@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="row">
    <div class="col-lg-4 col-sd-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{$pedidos->count()}}</h3>

          <p>Total de Pedidos</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{route('pedidos')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{$pedidosPendentes}}</h3>

          <p>Novos Pedidos</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{route('pedidos')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
      <!-- small box -->
      <div class="small-box  bg-success">
        <div class="inner">
          <h3>{{$pedidosConcluidos}}</h3>

          <p>Pedidos Finalizados</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="{{route('pedidos')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->

    <!-- ./col -->
  </div>
  <div class="row">
    <div class="col-md-12 col-sd-6">
    <div class="card bg-light">
        <div class="card-header">
          <h3 class="card-title">Pedidos por usuário</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">

          <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
            <canvas id="graficoPedidos" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 521px;" width="521" height="250" class="chartjs-render-monitor"></canvas>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
  </div>
</div>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script>
    const ctx = document.getElementById('graficoPedidos').getContext('2d');

    const graficoPedidos = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($clientes->pluck('name')) !!},
            datasets: [{
                label: '',
                data: {!! json_encode($clientes->pluck('total_pedidos')) !!},
                backgroundColor: {!! json_encode($clientes->map(function($c, $i) {
    // Gera uma cor HSL diferente para cada barra
    return "hsl(" . ($i * 40 % 360) . ", 70%, 60%)";
})) !!},
borderColor: {!! json_encode($clientes->map(function($c, $i) {
    return "hsl(" . ($i * 40 % 360) . ", 70%, 40%)";
})) !!},
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Pedidos'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Usuários'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true
                },
                title: {
                    display: false,
                    text: 'Pedidos por Usuário'
                }
            }
        }
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
