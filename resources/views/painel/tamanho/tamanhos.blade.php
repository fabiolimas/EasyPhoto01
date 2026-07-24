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

                <a href="{{ route('tamanho') }}" class="btn btn-primary"><i class="bi bi-plus-square"></i> Novo tamanho</a>
            </div>
        </div>

        <hr>
        <input type="text" name="busca" id="busca" class="form-control" placeholder="Buscar...">

        <div class="table-responsive result">

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
                    url: "{{ route('busca-tamanhos') }}", // Arquivo PHP que processará a busca
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
