@extends('layouts.painel')

@section('title', 'Dashboard')



@section('content')

    <section class="content">
        <div class="page-head">
            <div>
                <h1 class="page-title">Tamanhos de Fotos</h1>
                <p class="page-sub">Controle de tamanhos de fotos a serem usados no sistema</p>
            </div>
            <div class="page-actions">

                <a href="{{ route('tamanho') }}" class="btn btn-primary"><i class="bi bi-person-plus me-1"></i>Novo tamanho</a>
            </div>
        </div>

        <hr>
        <input type="text" name="busca" id="busca" class="form-control" placeholder="Buscar...">

        <table class="table mt-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tamanhos as $tamanho)
                    <tr>
                        <th scope="row">{{ $tamanho->id }}</th>
                        <td>{{ $tamanho->nome }}</td>
                        <td>R$ {{ number_format($tamanho->preco, 2, ',', '.') }}</td>

                        <td><a href="{{ route('edit-tamanho', $tamanho->id) }}" class="btn btn-success" title="Editar"><i
                                    class="bi bi-pencil"></i></a> | <a href="{{ route('destroy-tamanho', $tamanho->id) }}"
                                class="btn btn-danger" title="Excluir"><i class="bi bi-trash"></i> </a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
