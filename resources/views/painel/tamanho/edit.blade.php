@extends('layouts.painel')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Tamanho</h1>
@stop

@section('content')
    <section class="content">
        <div class="page-head">
            <div>
                <h1 class="page-title">Editar Tamanho</h1>
                <p class="page-sub">Edite o tamanho da foto

                </p>
            </div>
            <div class="page-actions">
                <a href="{{ route('tamanhos') }}" class="btn btn-soft"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
            </div>
        </div>
        <div class="col-md-6">
            <form method="post" action="{{ route('update-tamanho', $tamanho->id) }}" class="row g-3 mt-1">
                @csrf
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control mb-3" placeholder="Nome"
                    value="{{ $tamanho->nome }}">
                <label for="altura">Altura</label>
                <input type="text" name="altura" id="altura" class="form-control mb-3" placeholder="Altura"
                    value="{{ $tamanho->altura }}">

                <label for="largura">Largura</label>
                <input type="text" name="largura" id="largura" class="form-control mb-3" placeholder="Largura"
                    value="{{ $tamanho->largura }}">

                <label for="preco">Preço</label>
                <input type="text" name="preco" id="preco" class="form-control mb-3" placeholder="Preço"
                    value="{{ $tamanho->preco }}">

                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
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
