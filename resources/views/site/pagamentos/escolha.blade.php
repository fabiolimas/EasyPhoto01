@extends('layouts.site')

@section('content')
<div class="container py-5">

    <h3 class="mb-4 text-center">Escolha a forma de pagamento</h3>

    <div class="row justify-content-center">

        <div class="col-md-8">

            <form method="POST" action="{{ route('pagamento.processar', $pedido->id) }}">
                @csrf

                <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">

                <div class="row g-4">

                    {{-- PIX --}}
                    <div class="col-md-6">
                        <label class="w-100">
                            <input type="radio" name="forma_pagamento" value="pix" class="d-none input-pagamento">

                            <div class="card card-pagamento p-4 text-center h-100">
                                <h5>PIX</h5>
                                <p class="text-muted">Pagamento instantâneo</p>

                                <i class="fa-solid fa-qrcode fa-3x text-success"></i>
                            </div>
                        </label>
                    </div>

                    {{-- CARTÃO --}}
                    <div class="col-md-6">
                        <label class="w-100">
                            <input type="radio" name="forma_pagamento" value="cartao" class="d-none input-pagamento">

                            <div class="card card-pagamento p-4 text-center h-100">
                                <h5>Cartão de Crédito</h5>
                                <p class="text-muted">Parcelamento disponível</p>

                                <i class="fa-solid fa-credit-card fa-3x text-primary"></i>
                            </div>
                        </label>
                    </div>

                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-dark px-5">
                        Continuar
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

<style>
.card-pagamento {
    cursor: pointer;
    border: 2px solid #eee;
    transition: all .2s;
}

.card-pagamento:hover {
    border-color: #198754;
    transform: scale(1.02);
}

.input-pagamento:checked + .card-pagamento {
    border-color: #198754;
    background-color: #f0fff4;
}
</style>

@endsection
