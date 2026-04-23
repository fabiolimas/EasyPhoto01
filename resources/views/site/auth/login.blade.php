@extends('layouts.site')

@section('title', 'Dashboard')

@section('content_header')

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@section('content')



    <div class="row d-flex justify-content-center align-itens-center mt-5">
        <div class="col-md-6">
            <div class="logoEasyPHoto">
                <img src="{{asset('assets/img/logo_easy_photo.png')}}" class="w-100">
            </div>

        </div>
            <div class="col-md-6 ">
                <h4>Login</h4>
                <form id="loginForm" method ="post" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>
                    </div>
                <div class="form-group mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Senha" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="entrar" class="btn btn-dark">Entrar</button>
                    </div>

                </form>
                <div class="row text-center">
                    <h5>Não tem Cadastro?</h5>
                    <a href="{{route('registro_cliente')}}" class="item-link text-white">Clique aqui e cadastre-se</a>
                </div>



            </div>
        </div>



        @section('css')
        {{-- Add here extra stylesheets --}}
        {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    @stop

    @section('js')
        <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    @stop
    @stop
