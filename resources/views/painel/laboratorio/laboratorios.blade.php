@extends('layouts.painel')

@section('title', 'Dashboard')


@section('content')

    <section class="content">
        <div class="page-head">
            <div>
                <h1 class="page-title">Laboratórios</h1>
                <p class="page-sub">Controle de laboratórios</p>
            </div>
            <div class="page-actions">

                <a href="{{ route('laboratorio') }}" class="btn btn-primary"><i class="bi bi-person-plus me-1"></i>Novo
                    laboratório</a>
            </div>
        </div>

        <div class="row mt-1">

            <input type="text" name="busca" id="busca" class="form-control" placeholder="Buscar...">
        </div>
        <div class="row table-responsive mt-2">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laboratorios as $laboratorio)
                        <tr>
                            <th scope="row">{{ $laboratorio->id }}</th>
                            <td>{{ $laboratorio->nome }}</td>
                            <td>{{ $laboratorio->endereco }}</td>

                            <td><a href="{{ route('edit-lab', $laboratorio->id) }}" title="Editar"
                                    class="btn btn-success"><i class="bi bi-pencil"></i></a> | <a
                                    href="{{ route('destroy-lab', $laboratorio->id) }}" title="Excluir"
                                    class="btn btn-danger"><i class="bi bi-trash"></i></a></td>
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
