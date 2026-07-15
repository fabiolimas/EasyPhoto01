@extends('layouts.painel')

@section('title', 'Dashboard')



@section('content')
    <section class="content">
        <div class="page-head">
            <div>
                <h1 class="page-title">Nova Forma de Entrega</h1>
                <p class="page-sub">Cadastre uma nova forma de entrega</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('formas-de-entrega') }}" class="btn btn-soft"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
            </div>
        </div>


        <form method="post" action="{{ route('store-forma-entrega') }}" class="row g-3 mt-1">
            @csrf
            <div class="col-12 col-xl-8">
                <div class="card panel">
                    <div class="panel-head">
                        <div>
                            <div class="fw-semibold">Dados da forma de entrega</div>
                            <div class="xsmall text-muted">Informações sobre a forma de entrega</div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row g-3">
                            <label for="nome">Descrição</label>
                            <input type="text" name="nome" class="form-control mb-3" placeholder="Nome" required>
                            <label for="valor">Valor</label>
                            <input type="text" name="valor" class="form-control mb-3" placeholder="R$ 0,00" required>
                            <label for="local">Local Relacionado</label>
                            <select class="form-control" name='local' id="local">
                                <option value="">Selecione o local de entrega</option>
                                @foreach ($laboratorios as $laboratorio)
                                    <option value="{{ $laboratorio->id }}">{{ $laboratorio->nome }}</option>
                                @endforeach
                            </select>
                            <label for="tipo_entrega">Tipo de entrega</label>
                            <select name="tipo_entrega" class="form-select mb-3" id="tipo_entrega">
                                <option value="">Selecione a loja</option>
                                <option value="Motoboy">Motoboy</option>
                                <option value="Retirar na loja">Retirar na loja</option>
                            </select>

                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
        </form>
    </section>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
    <script>
        $('document').ready(function() {

            $("#nivel_acesso").change(function() {

                if ($("#nivel_acesso").val() == 'laboratorio') {
                    $("#laboratorio_id").css('display', 'flex');
                }

            });
        });
    </script>
@stop
