@extends('layouts.site')

@section('title', 'Dashboard')

@section('content_header')


@section('content')



    <div class="row">
        <h4><i class="fas fa-building text-danger"></i> {{ $laboratorio->nome }} - <span
                class="endlab">{{ $laboratorio->endereco }}</span></h4>
    </div>
    <div class="content position-relative">

        <div class="row">
            <div id="imageContainer" class="row">

            </div>
        </div>


    </div>
    <div class="row envioBar">
        <div class="col-md-3"><label for="imageInput">
                <span class="btn btn-danger me-3"> <i class="fa-solid fa-images"></i> Adicionar imagens</span>
            </label></div>
        <div class="col-md-9">
            <span class="me-3 offset-md-6 "><span id="total_pedido"></span> </span>
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf

                <input type="file" name="images[]" id="imageInput" accept="image/*" multiple style="visibility: hidden">

                <input type="hidden" name="laboratorio_id" id="laboratorio_id" value="{{ $laboratorio->id }}">
                 <input type="hidden" name="val_entrega" id="val_entrega">
                <input type="hidden" name="total" id="input_total">
                <input type="hidden" name="user_id" id="user_id" value="{{ auth()->id() }}">
                {{-- Modal Observação --}}
                <div class="modal fade" id="modalObservacao" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Observação </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="contentModalLab mt-3">
                                    <div class="row">
                                        <textarea name="observacao" id="observacao" cols="70" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Modal Forma de entrega --}}
                <div class="modal fade" id="modalEntrega" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Formas de Entrega </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="contentModalLab mt-3">
                                    <div class="row">
                                        @foreach ($entregas as $entrega)
                                            <div class="form-check">
                                                <input class="form-check-input entregainput" type="radio" name="entrega"
                                                    id="entrega-{{ $entrega->nome }}" value="{{ $entrega->valor }}">
                                                <label class="form-check-label" for="entrega-{{ $entrega->nome }}">
                                                    {{ $entrega->nome }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                              <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                        </div>

                    </div>
                </div>

        <div class="row fimBtns">
            <div class="col-md-4 col-sd-6">
                <span class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#modalObservacao"><i
                        class="fas fa-sticky-note"></i> Observação</span>
            </div>
            <div class="col-md-4 col-sd-6">
                <span class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#modalEntrega"><i
                        class="fas fa-shipping-fast"></i> Forma de Entrega</span>
            </div>
            <div class="col-md-4 col-sd-6">
                <button type="button" id="processButton" class="btn btn-dark mt-3 mb-3 w-100 disabled" ><i
                        class="fa-solid fa-cart-shopping"></i>
                    Enviar</button>
            </div>


        </div>
        </form>
            {{-- modal aviso envio --}}

            <div class="modal fade" id="modalAviso" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Atenção</h5>
      </div>
      <div class="modal-body">
        Selecione uma forma de envio antes de continuar.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
        <!-- Modal for Progress Bar -->
        <div id="progressModal" class="modalProg" style="display: none;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <progress id="uploadProgress" value="0" max="100"></progress>
            </div>
        </div>

        {{-- Modal Escolha de Imagem --}}
        <div class="modal fade" id="modalEscolha" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="text-center">Selecionar Imagens</h5>
                        <div class="contentModalLab mt-3">
                            <div class="row">
                                <label for="imageInput">
                                    <div class="imagem">
                                        <img src="{{ asset('assets/img/upload.jpg') }}" alt="Selecionar imagens"
                                            title="Selecionar Imagens" class="w-100" style="cursor: pointer">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .modalProg {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgb(0, 0, 0);
                background-color: rgba(0, 0, 0, 0.4);
                padding-top: 60px;
            }

            .modal-content {
                background-color: #fefefe;
                margin: 5% auto;
                padding: 20px;
                border: 1px solid #888;

            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }

            .image-wrapper {

                margin-bottom: 20px;
            }

            .image-wrapper img {
                max-width: 100%;
                height: auto;
                display: block;


            }

            .crop-controls {
                display: flex;
                justify-content: center;
                gap: 10px;
                margin-top: 10px;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                let modalEscolha = $("#modalEscolha");
                modalEscolha.modal('show');

                const cropSizes = [
                    @foreach ($tamanhos as $tamanho)
                        {
                            width: {{ $tamanho->largura }},
                            height: {{ $tamanho->altura }},
                            @if ($cliente->desconto > 1)
                                price: {{ $tamanho->preco * $desconto }}
                            @else
                                price: {{ $tamanho->preco }}
                            @endif
                        },
                    @endforeach
                ];

                $('#imageInput').on('change', function() {
                    const files = Array.from(this.files);
                    handleFiles(files);
                });

                $('#processButton').on('click', function() {
                    const formData = new FormData($('#uploadForm')[0]);
                    let sizeArray = [];
                    let quantityArray = [];
                    let priceArray = [];

                    let imagesProcessed = 0;
                    const images = $('#imageContainer img');

                    images.each(function(i, img) {
                        fetch(img.src)
                            .then(res => res.blob())
                            .then(blob => {
                                formData.append('images[]', blob, 'image_' + i + '.jpg');

                                const wrapper = $(img).closest('.image-wrapper');
                                const size = JSON.parse(wrapper.find('.size-select').val());
                                const quantity = wrapper.find('.quantity-input').val();
                                const price = wrapper.find('.price-inputv').val();



                                sizeArray.push(size);
                                quantityArray.push(quantity);
                                priceArray.push(price);

                                imagesProcessed++;
                                if (imagesProcessed === images.length) {
                                    formData.append('tamanhos', JSON.stringify(sizeArray));
                                    formData.append('quantidades', JSON.stringify(quantityArray));
                                    formData.append('precos', JSON.stringify(priceArray));
                                    uploadImages(formData);
                                }
                            });
                    });
                });
                // Taxa de entrega
                let selecionado = false;

    // quando selecionar o radio
    $('.entregainput').on('change', function () {
        selecionado = true;

        $('#processButton')
            .removeClass('disabled')
            .addClass('btn-success');

           let valorSelecionado = $('input[name="entrega"]:checked').val();

        $('#val_entrega').val(valorSelecionado);


        updateTotalPedido();

        console.log(valorSelecionado);
    });

    // clique no botão
    $('#processButton').on('click', function () {

        if (!selecionado) {
            // abre modal de aviso
            $('#modalAviso').modal('show');
            return;
        }});

                function handleFiles(files) {
                    if (files.length >= 1) {
                        modalEscolha.modal('hide');
                    } else {
                        modalEscolha.modal('show');
                    }

                    files.forEach(function(file, i) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const $wrapper = $('<div>').addClass('col-md-3 image-wrapper');
                            const $atributos = $('<div>').addClass('col-md-3 atributos');
                            const $img = $('<img>').attr('src', e.target.result).css({
                                width: '100%',
                                height: 'auto',
                                marginBottom: '10px'
                            });

                            const $sizeLabel = $('<label>').text('Tamanho:');
                            const $sizeSelect = $('<select>').addClass('size-select').on('change',
                            function() {
                                updatePrice($wrapper, $(this).val());
                            });

                            cropSizes.forEach(function(size, index) {
                                const $option = $('<option>')
                                    .val(JSON.stringify(size))
                                    .text(`${size.height}x${size.width}`);
                                if (index === 0) $option.prop('selected', true);
                                $sizeSelect.append($option);
                            });

                            const $quantityLabel = $('<label>').text('Quantidade:');
                            const $quantityInput = $('<input>').addClass('quantity-input').attr({
                                type: 'number',
                                min: '1',
                                value: '1',
                                placeholder: 'Quantidade'
                            });

                            const $priceLabel = $('<label>').text('Preço:');
                            const $priceInput = $('<input>').addClass('price-inputv').attr({
                                type: 'hidden',
                                readonly: true
                            });

                            const $priceSpan = $('<span>').addClass('price-input');

                            const $subtotal = $('<div>').addClass('item-total mt-2');

                            const $deleteButton = $('<button>').attr('type', 'button').addClass(
                                'btn btn-danger mt-2 text-center').html(
                                '<i class="fa-solid fa-trash"></i>').on('click', function() {
                                $wrapper.remove();
                                updateTotalPedido();
                            });

                            const $controls = $('<div>').addClass('image-controls text-center').append(
                                $deleteButton);

                            $atributos.append($sizeLabel, $sizeSelect, $quantityLabel, $quantityInput,
                                $priceLabel, $priceSpan, $priceInput, $subtotal);
                            $wrapper.append($img, $atributos, $controls);
                            $('#imageContainer').append($wrapper);

                            updatePrice($wrapper, $sizeSelect.val());
                        };

                        reader.readAsDataURL(file);
                    });
                }

                function updatePrice(wrapper, size) {
                    const parsedSize = JSON.parse(size);

                    const price = parsedSize.price;
                    const quantity = parseInt(wrapper.find('.quantity-input').val()) || 1;
                    const subtotal = price * quantity;


                    wrapper.find('.price-input').html(price.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    }));
                    wrapper.find('.price-inputv').val(price);
                    //wrapper.find('.item-total').html('Subtotal: ' + subtotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));

                    updateTotalPedido();
                }

                $(document).on('input', '.quantity-input', function() {
                    const wrapper = $(this).closest('.image-wrapper');
                    const size = wrapper.find('.size-select').val();
                    updatePrice(wrapper, size);
                });

                function updateTotalPedido() {
                    let total = 0;
                     const valor_entrega=parseInt($('#val_entrega').val())|| 0;
                    $('#imageContainer .image-wrapper').each(function() {
                        const price = parseFloat($(this).find('.price-inputv').val()) || 0;
                        const quantity = parseInt($(this).find('.quantity-input').val()) || 1;

                        total += price * quantity;

                    });
                    total+=valor_entrega;
                    $('#input_total').val(total);
                    $('#total_pedido').html(total.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    }));
                }

                function uploadImages(formData) {
                    $('#progressModal').show();

                    $.ajax({
                        url: '{{ route('upload.image') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        },
                        data: formData,
                        processData: false,
                        contentType: false,
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = (evt.loaded / evt.total) * 100;
                                    $('#uploadProgress').val(percentComplete);
                                    if (percentComplete === 100) {
                                        $('#progressModal').hide();
                                    }
                                }
                            }, false);
                            return xhr;
                        },
                        success: function(data) {
                            if (data.images) {
                                alert('Imagens enviadas com sucesso');
                                window.location.href = "/detalhe-pedido/" + data.pedido;
                            }
                        },
                        error: function(error) {
                            console.error('Erro:', error);
                            $('#progressModal').hide();
                        }
                    });
                }

                $('.close').on('click', function() {
                    $('#progressModal').hide();
                });

                $(window).on('click', function(event) {
                    if (event.target == document.getElementById('progressModal')) {
                        $('#progressModal').hide();
                    }
                });
            });
        </script>

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
