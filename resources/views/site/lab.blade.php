@extends('layouts.site')

@section('title', 'Dashboard')

@section('content_header')


@section('content')


    <div class="max-w-7xl mx-auto p-6 lg:p-8">




        <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

         <!-- Modal -->
    <div class="modal fade" id="modalLab" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {{-- <div class="modal-header">
                    {{-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> --}}
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> --}}
                <div class="modal-body">
                    <h5>Selecione uma loja</h5>
                    <div class="contentModalLab mt-5">

                    <div class="row">
                        @foreach($laboratorios as $laboratorio)
                        <div class="col-md-12 mb-3 boxlab">



                                <a href="{{route('enviar-fotos',$laboratorio->id)}}">
                                    <div class="row">
                                        <div class="col-md-2 text-center">
                                            <div class="logolab"><i class="fas fa-building text-danger"></i></div>
                                        </div>
                                        <div class="col-md-10 mt-1">
                                            <div class="tituloLab">{{$laboratorio->nome}}</div>
                                            <div class="enderecoLab">{{$laboratorio->endereco}}</div>
                                        </div>
                                    </div>

                                </a>


                        </div>
                        @endforeach
                    </div>
                </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
        </div>
    </div>


    <script>

        $(document).ready(function(){

            let labModal=$('#modalLab');

            labModal.modal('show');
        })
        </script>

    </div>


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
@stop
