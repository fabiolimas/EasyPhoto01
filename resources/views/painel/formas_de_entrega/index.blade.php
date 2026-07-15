@extends('layouts.painel')

@section('title', 'Formas de Entrega')

@section('content')
    <section class="content">
        <div class="page-head">
            <div>
                <h1 class="page-title">Formas de Entrega</h1>
                <p class="page-sub">Cadastre as formas de entrega que estarão disponíveis</p>
            </div>
           <div class="page-actions">

                <a href="{{ route('forma-de-entrega') }}" class="btn btn-primary"><i class="bi bi-person-plus me-1"></i>Nova
                    forma de entrega</a>
            </div>
        </div>
        @include('components.alerts')


        <hr>

        <div class="row table-responsive" class="mt-2">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>


                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formas as $forma)
                        <tr>
                            <th scope="row">{{ $forma->id }}</th>
                            <td>{{ $forma->nome }}</td>

                            <td><a href="{{ route('edit-forma-de-entrega', $forma->id) }}"title="Editar"
                                    class="btn btn-success"><i class="bi bi-pencil"></i></a>| <a
                                    href="{{ route('delete-forma-de-entrega', $forma->id) }}" title="Excluir"
                                    class="btn btn-danger"><i class="bi bi-trash"></i></a> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
