@extends('layouts.painel')



@section('content')
    <section class="content">
        <div class="page-head">
            <div>
                <h1 class="page-title">Usuários</h1>
                <p class="page-sub">Controle de acesso e permissões do sistema</p>
            </div>
            <div class="page-actions">

                <a href="{{ route('usuario') }}" class="btn btn-primary"><i class="bi bi-person-plus me-1"></i>Novo usuário</a>
            </div>
        </div>

        {{-- <div class="row g-3 mt-1">
            <div class="col-6 col-xl-4">
                <div class="kpi kpi-1">
                    <div class="kpi-head"><span class="kpi-label">Total</span><span class="kpi-ico"><i
                                class="bi bi-people"></i></span></div>
                    <div class="kpi-value">248</div>
                </div>
            </div>
            <div class="col-6 col-xl-4">
                <div class="kpi kpi-3">
                    <div class="kpi-head"><span class="kpi-label">Ativos</span><span class="kpi-ico"><i
                                class="bi bi-check-circle"></i></span></div>
                    <div class="kpi-value">214</div>
                </div>
            </div>

            <div class="col-6 col-xl-4">
                <div class="kpi kpi-4">
                    <div class="kpi-head"><span class="kpi-label">Administradores</span><span class="kpi-ico"><i
                                class="bi bi-shield-lock"></i></span></div>
                    <div class="kpi-value">6</div>
                </div>
            </div>
        </div> --}}
        <div class="card panel mt-3 mb-4">
            <div class="panel-head flex-wrap gap-2">

                <div class="d-flex gap-2">
                    <div class="input-icon">
                        <i class="bi bi-search"></i>
                        <input type="text" id="busca" name="busca" class="form-control form-control-sm"
                            placeholder="Buscar usuário...">
                    </div>
                    <button class="icon-btn"><i class="bi bi-funnel"></i></button>
                </div>
            </div>
            <div class="table-responsive result">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Permissão</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <th scope="row">{{ $usuario->id }}</th>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td><span
                                        class="tag @if ($usuario->nivel == 'administrador') tag-purple @elseif($usuario->nivel == 'laboratorio') tag-blue @else tag-gray @endif">{{ $usuario->nivel }}</span>
                                </td>
                                <td><a href="{{ route('edit-user', $usuario->id) }}"title="Editar"
                                        class="btn btn-success"><i class="bi bi-pencil"></i></a> | <a
                                        href="{{ route('destroy-user', $usuario->id) }}"title="Excluir"
                                        class="btn btn-danger"><i class="bi bi-trash"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


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
                    url: "{{ route('busca-usuarios') }}", // Arquivo PHP que processará a busca
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
