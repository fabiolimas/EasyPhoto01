@extends('layouts.painel')

@section('title', 'Dashboard')

@section('content')
    <section class="content">
        <div class="page-head">
            <div>
                <h1 class="page-title">Novo Tamanho</h1>
                <p class="page-sub">Cadastre um novo tamanho de foto</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('tamanhos') }}" class="btn btn-soft"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
            </div>
        </div>

        <form method="post" action="{{ route('store-tamanho') }}" class="row g-3 mt-1">
            @csrf
            <div class="col-12 col-xl-8">
                <div class="card panel">
                    <div class="panel-head">
                        <div>
                            <div class="fw-semibold">Dados do tamanho das impressões</div>
                            <div class="xsmall text-muted">Informações básicas tamanho, e preço</div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row g-3">
                            <input type="text" name="nome" class="form-control mb-3" placeholder="Nome" required>
                            <input type="text" name="altura" class="form-control mb-3" placeholder="Altura" required>
                            <input type="text" name="largura" class="form-control mb-3" placeholder="Largura" required>
                            <input type="text" name="preco" class="form-control mb-3" placeholder="Preço" required>




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
@stop
