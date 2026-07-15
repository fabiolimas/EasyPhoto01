@extends('layouts.painel')

@section('title', 'Dashboard')


@section('content')
    <section class="content">
        <div class="page-head">
            <div>
                <h1 class="page-title">Editar Laboratório</h1>
                <p class="page-sub">Editar informações do laboratório</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('laboratorios') }}" class="btn btn-soft"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
            </div>
        </div>
        <div class="col-md-6">
            <form method="post" action="{{ route('update-lab', $laboratorio->id) }}" class="row g-3 mt-1">
                @csrf
                <input type="text" name="nome" class="form-control mb-3" placeholder="Nome"
                    value="{{ $laboratorio->nome }}">
                <input type="text" name="endereco" class="form-control mb-3" placeholder="Endereço"
                    value="{{ $laboratorio->endereco }}">



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
