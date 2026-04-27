@extends('layouts.site')

@section('title', 'Dashboard')

@section('content_header')


@section('content')



<div class="col-md-6 container-fluid registroCliente ">
    <h4>Meus Dados</h4>
    <form id="registerForm" method ="post" action="{{route('editar-cliente', $cliente->id)}}">
        @csrf
        @method('put')

        <div class="row">
        <div class="form-group mb-3">
            <label for="nome">Nome Completo</label>
            <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome completo" value="{{$cliente->nome}}">
        </div>
         <div class="form-group mb-3">
            <label for="cpf">CPF</label>
            <input type="text" name="cpf" id="cpf" class="form-control"  value="{{$cliente->cpf}}">
        </div>
        <div class="form-group mb-3" >
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" class="form-control" placeholder="(xx)xxxx-xxxx" value="{{$cliente->telefone}}">
        </div>
        <div class="form-group mb-3">
            <label for="endereco">Endereço</label>
            <input type="text" name="endereco" id="endereco" class="form-control" placeholder="Endereço" value="{{$cliente->endereco}}">
        </div>
        <div class="form-group mb-3 col-md-6">
            <label for="bairro">Bairro</label>
            <input type="text" name="bairro" id="bairro" class="form-control" placeholder="Bairro" value="{{$cliente->bairro}}">
        </div>
        <div class="form-group mb-3 col-md-6">
            <label for="cep">CEP</label>
            <input type="text" name="cep" id="cep" class="form-control" placeholder="CEP" value="{{$cliente->cep}}">
        </div>
        <div class="form-group mb-3 col-md-6">
            <label for="cidade">Cidade</label>
            <input type="text" name="cidade" id="cidade" class="form-control" placeholder="Cidade" value="{{$cliente->cidade}}">
        </div>
        <div class="form-group mb-3 col-md-6">
            <label for="uf">Estado</label>
        <select class="form-select" name="uf" id="uf">
            <option value="{{$cliente->uf}}" selected>{{$cliente->uf}}</option>
            <option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espirito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MT">Mato Grosso</option>
            <option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
        </select>
        </div>

          <div class="form-group mb-3">
            <label for="desconto">Desconto %</label>
            <input type="text" name="desconto" id="desconto" class="form-control" value="{{$cliente->desconto}}" readonly>
        </div>
        <div class="form-group mb-3">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" value="{{$cliente->email}}">
        </div>

    <div class="form-group mb-3">
        <label for="password">Senha</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Senha">
        <p class="text-warning">Deixe em branco caso não queira alterar</p>
        </div>
        <div class="form-group">
            <button type="submit" id="salvar" class="btn btn-dark">Salvar</button>
        </div>
    </div>
    </form>




</div>
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
