@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <h1>Editar Cliente</h1>
@stop

@section('content')
<div class="col-md-6">
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
            <div class="invalid-feedback">
    CPF inválido
</div>
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
            <input type="text" name="desconto" id="desconto" class="form-control" placeholder="0" value="{{$cliente->desconto}}">
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
<script src="https://unpkg.com/imask"></script>
<script>


    const telefone = document.getElementById('telefone');
    const cpf = document.getElementById('cpf');
const maskOptions = {
  mask: '(00) 00000-0000'
};
const maskcpf={
    mask:'000.000.000-00'
}
const mask = IMask(telefone, maskOptions);
const maskc = IMask(cpf, maskcpf);

    </script>
<script>

// ===============================
// VALIDADOR DE CPF
// ===============================
function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g,'');

    if (cpf.length !== 11) return false;

    // elimina CPFs inválidos conhecidos
    if (/^(\d)\1+$/.test(cpf)) return false;

    let soma = 0;
    let resto;

    // 1º dígito
    for (let i = 1; i <= 9; i++)
        soma += parseInt(cpf.substring(i-1, i)) * (11 - i);

    resto = (soma * 10) % 11;
    if ((resto === 10) || (resto === 11)) resto = 0;

    if (resto !== parseInt(cpf.substring(9, 10))) return false;

    soma = 0;

    // 2º dígito
    for (let i = 1; i <= 10; i++)
        soma += parseInt(cpf.substring(i-1, i)) * (12 - i);

    resto = (soma * 10) % 11;
    if ((resto === 10) || (resto === 11)) resto = 0;

    if (resto !== parseInt(cpf.substring(10, 11))) return false;

    return true;
}

// ===============================
// VALIDAÇÃO EM TEMPO REAL
// ===============================
cpf.addEventListener('blur', function () {
    if (!validarCPF(this.value)) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
    } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    }
});

// ===============================
// BLOQUEAR SUBMIT
// ===============================
document.getElementById('registerForm').addEventListener('submit', function(e){

    if (!validarCPF(cpf.value)) {
        e.preventDefault();
        cpf.classList.add('is-invalid');
        alert('CPF inválido!');
        return;
    }

});

</script>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

    <script>
        $('document').ready(function(){

            if($("#nivel_acesso") == 'laboratorio'){
                $("$laboratorio_id").css('display','none');
            }else{
                $("#laboratorio_id").css('display','flex');
            }

            $("#nivel_acesso").change(function(){

                if($("#nivel_acesso").val() == 'laboratorio'){
                    $("#laboratorio_id").css('display','flex');
                }

            });
        });
    </script>
@stop
