@extends('layouts.site')

@section('title', 'Pagamento Cartão')

@section('content_header')

@section('content')
<div class="container py-5">

    <h3 class="text-center mb-4">Pagamento com Cartão</h3>

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow p-4">

                <form id="formCartao" method="POST" action="{{ route('pagamento.cartao.processar', $pedido->id) }}">
                    @csrf

                    <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">

                    {{-- Número --}}
                    <div class="mb-3">
                        <label>Número do Cartão</label>
                        <input type="text" name="numero" id="numero" class="form-control" maxlength="19" placeholder="0000 0000 0000 0000" required>
                    </div>

                    {{-- Nome --}}
                    <div class="mb-3">
                        <label>Nome no Cartão</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>

                    <div class="row">
                        {{-- Validade --}}
                        <div class="col-md-6 mb-3">
                            <label>Validade (MM/AA)</label>
                            <input type="text" name="validade" id="validade" class="form-control" placeholder="MM/AA" required>
                        </div>

                        {{-- CVV --}}
                        <div class="col-md-6 mb-3">
                            <label>CVV</label>
                            <input type="text" name="cvv" id="cvv" class="form-control" maxlength="4" required>
                        </div>
                    </div>

                    {{-- Parcelamento --}}
                    <div class="mb-3">
                        <label>Parcelamento</label>
                        <select name="parcelas" id="parcelas" class="form-control"></select>
                    </div>

                    <button class="btn btn-success w-100">Pagar</button>
                </form>

            </div>

        </div>
    </div>
</div>

<script>
let total = {{ $pedido->total }};

// 🔄 Gerar parcelas
function gerarParcelas() {
    let select = document.getElementById('parcelas');
    select.innerHTML = '';

    for (let i = 1; i <= 12; i++) {
        let valor = (total / i).toFixed(2);
        let option = document.createElement('option');
        option.value = i;
        option.text = i + 'x de R$ ' + valor;
        select.appendChild(option);
    }
}

gerarParcelas();

// 💳 Máscara número
document.getElementById('numero').addEventListener('input', function(e){
    let v = e.target.value.replace(/\D/g,'').slice(0,16);
    e.target.value = v.replace(/(\d{4})(?=\d)/g, '$1 ');
});

// 📅 Validade
document.getElementById('validade').addEventListener('input', function(e){
    let v = e.target.value.replace(/\D/g,'').slice(0,4);
    e.target.value = v.replace(/(\d{2})(\d)/, '$1/$2');
});

// 🔒 CVV
document.getElementById('cvv').addEventListener('input', function(e){
    e.target.value = e.target.value.replace(/\D/g,'');
});

// ✅ Validação
document.getElementById('formCartao').addEventListener('submit', function(e){

    let numero = document.getElementById('numero').value.replace(/\s/g,'');
    let validade = document.getElementById('validade').value;
    let cvv = document.getElementById('cvv').value;

    if(numero.length < 16){
        alert('Número do cartão inválido');
        e.preventDefault();
        return;
    }

    if(!validade.match(/^\d{2}\/\d{2}$/)){
        alert('Validade inválida');
        e.preventDefault();
        return;
    }

    if(cvv.length < 3){
        alert('CVV inválido');
        e.preventDefault();
        return;
    }
});
</script>

@endsection
