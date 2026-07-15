@extends('layouts.painel')

@section('title', 'Dashboard')


@section('content')

    <section class="content">
        <div class="page-head">
            <div>
                <h1 class="page-title">Novo Usuário</h1>
                <p class="page-sub">Cadastre um novo usuário e defina suas permissões de acesso</p>
            </div>
            <div class="page-actions">
                <a href="{{route('usuarios')}}" class="btn btn-soft"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
            </div>
        </div>
        <div class="col-md-6">
            <form method="post" action="{{ route('store-user') }}" class="row g-3 mt-1">
                @csrf
                <input type="text" name="name" class="form-control mb-3" placeholder="Nome" required>
                <input type="text" name="email" class="form-control mb-3" placeholder="E-mail" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Senha" required>
                <select name="nivel" class="form-select mb-3" required id="nivel_acesso">
                    <option value="">Nivel de Acesso</option>
                    <option value="administrador">Administrador</option>
                    <option value="laboratorio">Laboratório</option>
                    <option value="cliente">Cliente</option>
                </select>
                <select name="laboratorio_id" class="form-select mb-3" id="laboratorio_id" style="display:none">
                    <option value="">Selecione a loja</option>
                    <option value="1">Jacobina</option>
                    <option value="2">Petrolina</option>
                </select>

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
