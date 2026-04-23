
@extends('layouts.site')

@section('title', 'Dashboard')

@section('content_header')


@section('content')


<h2>Pagamento Pedido #{{ $pedidoId }}</h2>

<select id="metodo">
    <option value="pix">PIX</option>
    <option value="visa">Cartão</option>
    <option value="bolbradesco">Boleto</option>
</select>

<div id="cartao" style="display:none;">
    <input type="text" id="cardNumber" placeholder="Número do cartão"><br>
    <input type="text" id="expirationDate" placeholder="MM/YY"><br>
    <input type="text" id="securityCode" placeholder="CVV"><br>
    <input type="text" id="cardholderName" placeholder="Nome"><br>
</div>

<input type="email" id="email" placeholder="Email"><br>

<button onclick="pagar()" type="button">Pagar</button>

<div id="resultado"></div>

<script>
const mp = new MercadoPago('APP_USR-e8e49210-d802-49f0-bade-f8f1fce9bd11');

document.getElementById('metodo').addEventListener('change', function() {
    document.getElementById('cartao').style.display =
        this.value === 'visa' ? 'block' : 'none';
});

function pagar() {
    let metodo = document.getElementById('metodo').value;

    if (metodo === 'visa') {
        const cardForm = mp.cardForm({
            amount: "{{ $valor }}",
            autoMount: true,
            form: {
                id: "form-checkout",
                cardNumber: { id: "cardNumber" },
                expirationDate: { id: "expirationDate" },
                securityCode: { id: "securityCode" },
                cardholderName: { id: "cardholderName" },
                cardholderEmail: { id: "email" }
            },
            callbacks: {
                onSubmit: function(e) {
                    e.preventDefault();
                    enviar(cardForm.getCardFormData());
                }
            }
        });
    } else {
        enviar({});
    }
}

function enviar(cardData) {
    fetch('/checkout/processar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            pedido_id: "{{ $pedidoId }}",
            valor: "{{ $valor }}",
            metodo: document.getElementById('metodo').value,
            email: document.getElementById('email').value,
            token: cardData.token,
            parcelas: 1
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.point_of_interaction) {
            document.getElementById('resultado').innerHTML = `
                <img src="data:image/png;base64,${data.point_of_interaction.transaction_data.qr_code_base64}" />
                <textarea>${data.point_of_interaction.transaction_data.qr_code}</textarea>
            `;
        } else if (data.transaction_details) {
            document.getElementById('resultado').innerHTML = `
                <a href="${data.transaction_details.external_resource_url}" target="_blank">Ver Boleto</a>
            `;
        } else {
            alert("Status: " + data.status);
        }
    });
}
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
@stop
