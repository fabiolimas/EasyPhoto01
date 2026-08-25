@extends('layouts.envio')

@section('content')
    {{-- Loja --}}
    <div class="store-header">
        <i class="bi bi-shop"></i>
        <div>
            <strong>{{ $laboratorio->nome ?? 'Laboratório' }}</strong>
            <span class="ms-2">- {{ $laboratorio->endereco ?? '' }}</span>
        </div>
    </div>

    <form id="uploadForm" enctype="multipart/form-data">
        @csrf

        <input type="hidden" id="val_entrega" name="val_entrega" value="0">
        <input type="hidden" id="forma_entrega" name="forma_entrega" value="">
        <input type="hidden" id="input_total" name="total" value="0">
        <input type="hidden" id="observacao_input" name="observacao" value="">
        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->id() }}">
        <input type="hidden" name="laboratorio_id" id="laboratorio_id" value="{{ $laboratorio->id }}">
        <input type="file" id="imageInput" name="images[]" multiple accept="image/*" style="visibility: hidden">
        {{-- Grid de imagens --}}
        <div id="bulkProgressContainer" style="display:none; margin-bottom:15px;">
            <div class="d-flex justify-content-between mb-1">
                <small>Atualizando tamanhos...</small>
                <small id="bulkProgressText">0%</small>
            </div>

            <div class="progress" style="height:18px;">
                <div id="bulkProgressBar" class="progress-bar" role="progressbar" style="width:0%;">
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3 mb-3" id="bulkActions" style="display:none!important;">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAllImages">
                <label class="form-check-label" for="selectAllImages">
                    Selecionar todas
                </label>
            </div>

            <select id="bulkSizeSelect" class="form-select" style="max-width:250px;">
                <option value="">Alterar tamanho das selecionadas</option>
            </select>

            <span id="selectedCount" class="text-muted">
                0 selecionadas
            </span>
        </div>
        <div class="row g-3" id="imageContainer">
            {{-- <div class="col-12 col-sm-6 col-md-4 col-lg-3">
          <label for="imageInput" class="empty-upload h-100 mb-0">
            <i class="bi bi-cloud-arrow-up"></i>
            <strong>Adicionar imagens</strong>

          </label>

        </div> --}}
        </div>
    </form>
    </div>

    {{-- Modal Observação --}}
    <div class="modal fade" id="modalObservacao" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-chat-left-text me-2"></i>Observação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <textarea id="observacao_text" class="form-control form-control-dark" rows="4"
                        placeholder="Digite uma observação para o pedido..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-action btn-action-primary" id="salvarObservacao"
                        data-bs-dismiss="modal">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Forma de entrega --}}
    <div class="modal fade" id="modalEntrega" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-truck me-2"></i>Formas de Entrega</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @foreach ($entregas as $entrega)
                        <div class="form-check mb-2">
                            <input class="form-check-input entregainput" type="radio" name="entrega"
                                id="entrega{{ $entrega->id }}" value="{{ $entrega->id }}">
                            <label class="form-check-label" for="entrega{{ $entrega->id }}">
                                {{ $entrega->nome }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-action btn-action-dark" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal aviso envio --}}
    <div class="modal fade" id="modalAviso" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-warning"><i class="bi bi-exclamation-triangle me-2"></i>Atenção</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">Selecione uma forma de envio antes de continuar.</div>
                <div class="modal-footer">
                    <button type="button" class="btn-action btn-action-primary" data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Escolha de Imagem --}}
    <div class="modal fade" id="modalEscolha" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Selecionar Imagens</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <label for="imageInput" class="btn-action btn-action-primary">
                        <i class="bi bi-images me-2"></i>Escolher arquivos
                    </label>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Progresso --}}
    <div id="progressModal">
        <button class="close">&times;</button>
        <div class="progress-box">
            <h5 class="mb-3">Enviando imagens...</h5>
            <progress id="uploadProgress" value="0" max="100" style="width:100%;height:18px"></progress>
        </div>
    </div>

    {{-- Action bar --}}
    <div class="action-bar">
        <div class="container-fluid">
            <div class="action-bar-inner">
                <label for="imageInput" class="btn-action mb-0">
                    <i class="bi bi-images"></i> Adicionar imagens
                </label>

                <div class="total-badge">
                    <small>Total</small>
                    <span id="total_pedido">R$ 0,00</span>
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    {{-- <button type="button" class="btn-action btn-action-dark" data-bs-toggle="modal"
                        data-bs-target="#modalObservacao">
                        <i class="bi bi-square"></i> Acabamento
                    </button> --}}
                    <button type="button" class="btn-action btn-action-dark" data-bs-toggle="modal"
                        data-bs-target="#modalObservacao">
                        <i class="bi bi-chat-left-text"></i> Observação
                    </button>
                    <button type="button" class="btn-action btn-action-dark" data-bs-toggle="modal"
                        data-bs-target="#modalEntrega">
                        <i class="bi bi-truck"></i> Forma de Entrega
                    </button>
                    <button type="button" id="processButton" class="btn-action btn-action-primary disabled">
                        <i class="bi bi-cart-check"></i> Enviar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        window.easyPhotoUpload = {
            MAX_CONCURRENT: 3,
            MAX_RETRIES: 3,

            queue: [],
            active: 0,

            totalBytes: 0,
            uploadedBytes: 0,

            pedido: null,
            errors: [],

            finalized: false
        };
        $(document).on('change', '.entregainput', function() {


            $('#processButton').removeClass('disabled');

            let entregaId = $('input[name="entrega"]:checked').val();

            $.ajax({
                url: '/buscar-entrega/' + entregaId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#val_entrega').val(response.valor);
                    $('#forma_entrega').val(response.nome);
                    updateTotalPedido();
                },
                error: function() {
                    console.error('Erro ao buscar valor da entrega');
                }
            });
        });

        function criarPedidoAntesUpload() {

            const formData = new FormData();


            /*
             * DADOS DO PEDIDO
             */

            formData.append(
                'user_id',
                $('input[name="user_id"]').val() || ''
            );


            formData.append(
                'laboratorio_id',
                $('input[name="laboratorio_id"]').val() ||
                $('select[name="laboratorio_id"]').val() ||
                ''
            );


            formData.append(
                'observacao',
                $('#observacao_text').val() || ''
            );


            formData.append(
                'total',
                $('#input_total').val() || 0
            );


            /*
             * ENTREGA
             *
             * Esses valores são preenchidos pela
             * função .entregainput
             */

            formData.append(
                'forma_entrega',
                $('#forma_entrega').val() || ''
            );


            formData.append(
                'val_entrega',
                $('#val_entrega').val() || 0
            );


            /*
             * CSRF
             */
            formData.append(
                '_token',
                $('input[name="_token"]').val()
            );


            /*
             * DEBUG
             */
            console.log(
                'Observação:',
                $('#observacao').val()
            );

            console.log(
                'Forma de entrega:',
                $('#forma_entrega').val()
            );

            console.log(
                'Valor entrega:',
                $('#val_entrega').val()
            );

            console.log(
                'Total:',
                $('#input_total').val()
            );


            /*
             * MODAL
             */
            $('#progressModal')
                .css('display', 'flex');


            $('#uploadProgress')
                .val(0);


            $('#progressModal h5').text(
                'Preparando envio das imagens...'
            );


            /*
             * CRIA PEDIDO
             */
            return $.ajax({

                url: '{{ route('pedido.criar') }}',

                method: 'POST',

                data: formData,

                processData: false,

                contentType: false,

                headers: {

                    'X-CSRF-TOKEN': $('input[name="_token"]').val()

                }

            });

        }
        // ===== Máscara de corte =====
        function updateCropMask($card) {
            const img = $card.find('.image-card-thumb img')[0];
            const thumb = $card.find('.image-card-thumb')[0];
            const mask = $card.find('.crop-mask')[0];
            const sel = $card.find('.size-select')[0];
            if (!img || !thumb || !mask || !sel) return;
            if (!img.naturalWidth || !img.naturalHeight) return;

            let a, b, label;
            try {
                const parsed = JSON.parse(sel.value);
                a = parseFloat(parsed.width);
                b = parseFloat(parsed.height);
                label = parsed.nome;

            } catch (e) {
                const parts = sel.value.toLowerCase().split('x').map(v => parseFloat(v));
                a = parts[0];
                b = parts[1];
                label = sel.value;
            }
            if (!a || !b) return;

            const cw = thumb.clientWidth;
            const ch = thumb.clientHeight;
            const imgRatio = img.naturalWidth / img.naturalHeight;

            // Tamanho renderizado (object-fit: contain)
            let renderedW, renderedH;
            if (imgRatio > cw / ch) {
                renderedW = cw;
                renderedH = cw / imgRatio;
            } else {
                renderedH = ch;
                renderedW = ch * imgRatio;
            }

            // Orienta o corte conforme paisagem/retrato da foto
            const longSide = Math.max(a, b);
            const shortSide = Math.min(a, b);
            let printW, printH;
            if (imgRatio >= 1) {
                printW = longSide;
                printH = shortSide;
            } else {
                printW = shortSide;
                printH = longSide;
            }
            const cropRatio = printW / printH;

            // Inscreve o retângulo de corte na imagem renderizada
            let mw, mh;
            if (cropRatio > renderedW / renderedH) {
                mw = renderedW;
                mh = renderedW / cropRatio;
            } else {
                mh = renderedH;
                mw = renderedH * cropRatio;
            }

            mask.style.width = mw + 'px';
            mask.style.height = mh + 'px';
            const state = $card.data('maskState');

            if (state) {

                state.x = 0;
                state.y = 0;

            }
            mask.setAttribute('data-size', label);
        }

        function updateTotalPedido() {
            let total = 0;
            const valor_entrega = parseFloat($('#val_entrega').val()) || 0;
            $('#imageContainer .image-wrapper').each(function() {
                const price = parseFloat($(this).find('.price-inputv').val()) || 0;
                const quantity = parseInt($(this).find('.quantity-input').val()) || 1;
                total += price * quantity;
            });
            total += valor_entrega;
            $('#input_total').val(total);
            $('#total_pedido').html(total.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }));
        }

        function updateSelectedSizesWithProgress(value) {

            if (!value) return;

            const parsedSize = JSON.parse(value);
            const price = parsedSize.price;

            const selected = $('.image-selector:checked').toArray();

            if (selected.length === 0) {
                $('#bulkSizeSelect').val('');
                return;
            }

            const total = selected.length;
            let processed = 0;

            // Mostra o progresso
            $('#bulkProgressContainer').show();
            $('#bulkProgressBar')
                .css('width', '0%')
                .attr('aria-valuenow', 0);

            $('#bulkProgressText').text('0%');

            // Desabilita o select durante o processamento
            $('#bulkSizeSelect').prop('disabled', true);

            // Quantidade de imagens processadas por ciclo
            const batchSize = 20;

            function processBatch() {

                const end = Math.min(
                    processed + batchSize,
                    total
                );

                for (let i = processed; i < end; i++) {

                    const $selector = $(selected[i]);
                    const $wrapper = $selector.closest('.image-wrapper');
                    const $card = $wrapper.find('.image-card');

                    /*
                     * 1. ALTERA O TAMANHO
                     */
                    $wrapper
                        .find('.size-select')
                        .val(value);

                    /*
                     * 2. ATUALIZA O PREÇO
                     *
                     * Não usamos updatePrice() aqui porque ela
                     * chama updateTotalPedido() para cada imagem.
                     */
                    $wrapper
                        .find('.price-input')
                        .html(
                            price.toLocaleString('pt-BR', {
                                style: 'currency',
                                currency: 'BRL'
                            })
                        );

                    $wrapper
                        .find('.price-inputv')
                        .val(price);

                    /*
                     * 3. ATUALIZA A MÁSCARA DE CORTE
                     */
                    if ($card.length) {
                        updateCropMask($card);
                    }

                    processed++;
                }

                /*
                 * 4. ATUALIZA O PROGRESSO
                 */
                const percent = Math.round(
                    (processed / total) * 100
                );

                $('#bulkProgressBar')
                    .css('width', percent + '%')
                    .attr('aria-valuenow', percent);

                $('#bulkProgressText')
                    .text(percent + '%');

                /*
                 * 5. CONTINUA PROCESSANDO
                 */
                if (processed < total) {

                    requestAnimationFrame(processBatch);

                } else {

                    /*
                     * 6. RECALCULA O TOTAL APENAS UMA VEZ
                     */
                    updateTotalPedido();

                    /*
                     * 7. LIBERA O SELECT
                     */
                    $('#bulkSizeSelect').prop(
                        'disabled',
                        false
                    );

                    /*
                     * 8. MOSTRA CONCLUÍDO
                     */
                    $('#bulkProgressText').text(
                        'Concluído'
                    );

                    $('#bulkProgressBar')
                        .css('width', '100%')
                        .attr('aria-valuenow', 100);

                    /*
                     * 9. LIMPA O SELECT
                     */
                    $('#bulkSizeSelect').val('');

                    /*
                     * 10. ESCONDE A BARRA
                     */
                    setTimeout(function() {

                        $('#bulkProgressContainer').fadeOut(300);

                    }, 1000);
                }
            }

            /*
             * Inicia o processamento
             */
            requestAnimationFrame(processBatch);
        }



        $(function() {
            /*
             * CONTADOR DE IMAGENS SELECIONADAS
             */
            function updateSelectedCount() {

                const total = $('.image-selector:checked').length;

                $('#selectedCount').text(
                    total + ' selecionadas'
                );

                $('#bulkActions').css(
                    'display',
                    $('.image-wrapper').length > 0 ?
                    'flex' :
                    'none'
                );
            }


            /*
             * SELECIONAR TODAS
             */
            $(document).on(
                'change',
                '#selectAllImages',
                function() {

                    const checked = this.checked;

                    $('.image-selector')
                        .prop('checked', checked);

                    $('.image-wrapper')
                        .toggleClass(
                            'selected',
                            checked
                        );

                    $('#selectedCount').text(

                        checked ?
                        $('.image-selector').length + ' selecionadas' :
                        '0 selecionadas'

                    );

                }
            );


            /*
             * SELEÇÃO INDIVIDUAL
             */
            $(document).on(
                'change',
                '.image-selector',
                function() {

                    const $wrapper = $(this)
                        .closest('.image-wrapper');

                    $wrapper.toggleClass(
                        'selected',
                        this.checked
                    );

                    updateSelectedCount();

                }
            );


            /*
             * ALTERAÇÃO DE TAMANHO EM MASSA
             */
            $('#bulkSizeSelect').on(
                'change',
                function() {

                    const value = this.value;

                    if (!value) {
                        return;
                    }

                    updateSelectedSizesWithProgress(value);

                    /*
                     * Permite escolher novamente o mesmo tamanho
                     */
                    setTimeout(function() {

                        $('#bulkSizeSelect').val('');

                    }, 100);

                }
            );

            function mostrarProgressoCarregamento(percent) {

    $('#progressModal').css('display', 'flex');

    $('#uploadProgress')
        .val(percent)
        .attr('max', 100);

    $('#progressModal h5').text(
        'Carregando imagens... ' + percent + '%'
    );

}

 function updatePrice(wrapper, size) {
                const parsedSize = JSON.parse(size);
                const price = parsedSize.price;
                wrapper.find('.price-input').html(price.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                }));
                wrapper.find('.price-inputv').val(price);
                updateTotalPedido();
            }

            $(document).on('input', '.quantity-input', function() {
                const wrapper = $(this).closest('.image-wrapper');
                const size = wrapper.find('.size-select').val();
                updatePrice(wrapper, size);
            });

              function initCropMask($card) {
                const img = $card.find('.image-card-thumb img')[0];
                if (!img) return;
                const run = () => updateCropMask($card);
                if (img.complete) run();
                else img.addEventListener('load', run);
            }
            // =============================
            // Editor visual da máscara
            // =============================
            function initMaskEditor($card) {

                const thumb = $card.find('.image-card-thumb');
                const mask = $card.find('.crop-mask');

                const state = {
                    x: 0,
                    y: 0,
                    dragging: false,
                    startX: 0,
                    startY: 0,
                    zoom: 1
                };

                $card.data('maskState', state);

                function update() {

                    mask.css({
                        transform: `translate(calc(-50% + ${state.x}px),
                       calc(-50% + ${state.y}px))
             scale(${state.zoom})`
                    });

                }

                update();

                mask.on('mousedown', function(e) {

                    e.preventDefault();

                    state.dragging = true;

                    state.startX = e.clientX - state.x;
                    state.startY = e.clientY - state.y;

                });

                $(document).on('mousemove.mask', function(e) {

                    if (!state.dragging) return;

                    state.x = e.clientX - state.startX;
                    state.y = e.clientY - state.startY;

                    limitar();

                    update();

                });

                $(document).on('mouseup.mask', function() {

                    state.dragging = false;

                });

                mask.on('wheel', function(e) {

                    e.preventDefault();

                    if (e.originalEvent.deltaY < 0) {

                        state.zoom += 0.05;

                    } else {

                        state.zoom -= 0.05;

                    }

                    state.zoom = Math.max(.5, Math.min(3, state.zoom));

                    limitar();

                    update();

                });

                function limitar() {

                    const img = thumb.find('img')[0];

                    if (!img.naturalWidth) return;

                    const boxW = thumb.width();
                    const boxH = thumb.height();

                    const imgRatio = img.naturalWidth / img.naturalHeight;
                    const boxRatio = boxW / boxH;

                    let renderW;
                    let renderH;

                    // tamanho REAL da imagem dentro do contain
                    if (imgRatio > boxRatio) {

                        renderW = boxW;
                        renderH = boxW / imgRatio;

                    } else {

                        renderH = boxH;
                        renderW = boxH * imgRatio;

                    }

                    const mw = mask.outerWidth() * state.zoom;
                    const mh = mask.outerHeight() * state.zoom;

                    const maxX = (renderW - mw) / 2;
                    const maxY = (renderH - mh) / 2;

                    state.x = Math.max(-maxX, Math.min(maxX, state.x));
                    state.y = Math.max(-maxY, Math.min(maxY, state.y));

                }

            }

            $(window).on('resize', function() {
                $('#imageContainer .image-wrapper .image-card').each(function() {
                    updateCropMask($(this));
                });
            });
           window.handleFiles = function(files) {



    if (files.length < 1) {
        modalEscolha.show();
        return;
    }

    const arquivos = Array.from(files);
    const total = arquivos.length;

    let processados = 0;


    /*
     * Mostra progressbar
     */
    $('#progressModal').css('display', 'flex');

    $('#uploadProgress')
        .val(0)
        .attr('max', 100);

    $('#progressModal h5').text(
        'Carregando imagens... 0%'
    );


    /*
     * Processa uma imagem por vez
     */
    function processarProximaImagem() {

        if (processados >= total) {

            $('#uploadProgress').val(100);

            $('#progressModal h5').text(
                'Imagens carregadas!'
            );


            setTimeout(function() {

                $('#progressModal').hide();

            }, 500);


            updateTotalPedido();

            return;
        }


        const file = arquivos[processados];


        /*
         * Verifica se é imagem
         */
        if (!file.type.startsWith('image/')) {

            processados++;

            requestAnimationFrame(
                processarProximaImagem
            );

            return;
        }


        /*
         * URL temporária.
         *
         * Não converte a imagem para Base64.
         */
        const imageUrl =
            URL.createObjectURL(file);


        /*
         * COLUNA
         */
        const $col = $('<div>')
            .addClass(
                'col-12 col-sm-6 col-md-4 col-lg-3 image-wrapper'
            );


        /*
         * IMPORTANTE:
         * Guarda o File original no wrapper.
         *
         * O upload posteriormente utilizará
         * exatamente esse arquivo.
         */
        $col.data('file', file);


        /*
         * CARD
         */
        const $card = $('<div>')
            .addClass('image-card');


        /*
         * THUMB
         */
        const $thumb = $('<div>')
            .addClass('image-card-thumb');


        /*
         * MÁSCARA
         */
        const $mask = $('<div>')
            .addClass('crop-mask');


        /*
         * IMAGEM
         */
        const $img = $('<img>')
            .attr('src', imageUrl)
            .attr(
                'data-filename',
                file.name
            );


        /*
         * CHECKBOX
         */
        const $check = $(`
            <label class="select-image">
                <input type="checkbox" class="image-selector">
            </label>
        `);


        $card.append($check);


        /*
         * Adiciona imagem + máscara
         */
        $thumb
            .append($img)
            .append($mask);


        /*
         * ATRIBUTOS
         */
        const $atributos =
            $('<div>')
                .addClass('atributos');


        /*
         * SELECT DE TAMANHO
         */
        const $sizeSelect =
            $('<select>')
                .addClass('size-select')
                .on('change', function() {

                    updatePrice(
                        $col,
                        $(this).val()
                    );

                    updateCropMask($card);

                });


        cropSizes.forEach(
            function(size, index) {

                const $option =
                    $('<option>')
                        .val(
                            JSON.stringify(size)
                        )
                        .text(size.nome);


                if (index === 0) {

                    $option.prop(
                        'selected',
                        true
                    );

                }


                $sizeSelect.append(
                    $option
                );

            }
        );


        /*
         * QUANTIDADE
         */
        const $qtyInput =
            $('<input>')
                .addClass('quantity-input')
                .attr({

                    type: 'number',

                    min: '1',

                    value: '1'

                });


        /*
         * PREÇO
         */
        const $priceSpan =
            $('<span>')
                .addClass('price-input');


        const $priceInput =
            $('<input>')
                .addClass('price-inputv')
                .attr({

                    type: 'hidden',

                    readonly: true

                });


        /*
         * SUBTOTAL
         */
        const $subtotal =
            $('<div>')
                .addClass(
                    'item-total mt-2'
                );


        /*
         * BOTÃO EXCLUIR
         */
        const $deleteBtn =
            $('<button>')
                .attr(
                    'type',
                    'button'
                )
                .addClass(
                    'btn btn-danger btn-sm'
                )
                .html(
                    '<i class="bi bi-trash3"></i> Remover'
                )
                .on('click', function() {

                    $col.remove();

                    updateTotalPedido();

                });


        const $controls =
            $('<div>')
                .addClass(
                    'image-controls'
                )
                .append(
                    $deleteBtn
                );


        /*
         * Monta atributos
         */
        $atributos.append(

            $('<div>').append(

                $sizeSelect,

                $qtyInput,

                $priceSpan,

                $priceInput

            ),

            $subtotal,

            $controls

        );


        /*
         * Monta card
         */
        $card.append(

            $thumb,

            $atributos

        );


        $col.append($card);


        /*
         * Adiciona ao container
         */
        $('#imageContainer')
            .append($col);


        /*
         * ==================================================
         * INICIALIZAÇÕES
         * ==================================================
         *
         * Mantemos suas funções originais.
         */

        initCropMask($card);

        initMaskEditor($card);


        /*
         * PREÇO
         *
         * A função original continua sendo utilizada.
         */
        updatePrice(
            $col,
            $sizeSelect.val()
        );


        /*
         * Quando a imagem terminar de carregar
         */
        $img.on('load', function() {

            /*
             * Garante que a máscara seja recalculada
             * depois que naturalWidth/naturalHeight
             * estiverem disponíveis.
             */
            updateCropMask($card);


            /*
             * Libera a URL temporária.
             */
            URL.revokeObjectURL(imageUrl);


            /*
             * Incrementa progresso
             */
            processados++;


            const percent =
                Math.round(
                    (processados / total) * 100
                );


            $('#uploadProgress')
                .val(percent);


            $('#progressModal h5').text(
                'Carregando imagens... ' +
                percent +
                '%'
            );


            /*
             * Próxima imagem
             */
            requestAnimationFrame(
                processarProximaImagem
            );

        });


        /*
         * Caso a imagem já esteja carregada
         */
        if ($img[0].complete) {

            $img.trigger('load');

        }

    }


    /*
     * Começa o processamento
     */
    processarProximaImagem();

};
            const modalEscolha = new bootstrap.Modal(document.getElementById('modalEscolha'));
            let precodesc = 0;
            const cropSizes = [
                @foreach ($tamanhos as $tamanho)
                    {
                        nome: '{{ $tamanho->nome }}',
                        width: {{ $tamanho->largura }},
                        height: {{ $tamanho->altura }},
                        price: {{ round($cliente->desconto > 0 ? $tamanho->preco * (1 - $cliente->desconto / 100) : $tamanho->preco, 2) }}
                    },
                @endforeach
            ];
            cropSizes.forEach(function(size) {
                $('#bulkSizeSelect').append(
                    $('<option>')
                    .val(JSON.stringify(size))
                    .text(size.nome)
                );
            });
            $('#imageInput').on('change', function() {

                const files = Array.from(this.files);
                handleFiles(files);
            });

            $('#salvarObservacao').on('click', function() {
                $('#observacao_input').val($('#observacao_text').val());
            });

            $('#processButton').on('click', function(e) {



                const images = $('#imageContainer .image-wrapper');

                if (images.length === 0) {

                    alert('Nenhuma imagem adicionada ao pedido!');
                    return;
                }

                   if ($(this).hasClass('disabled')) {
                    e.preventDefault();

                    alert('Selecione uma forma de entrega.');
                    $("#modalEntrega").modal('show');
                    return;
                }


                uploadImages();



                $(document).on('input', '.quantity-input', function() {
                    const wrapper = $(this).closest('.image-wrapper');
                    const size = wrapper.find('.size-select').val();
                    updatePrice(wrapper, size);
                });


                /*
                |--------------------------------------------------------------------------
                | INICIA O UPLOAD
                |--------------------------------------------------------------------------
                */

                function uploadImages() {

                    const state =
                        window.easyPhotoUpload;


                    /*
                     * Primeiro cria o pedido.
                     */
                    criarPedidoAntesUpload()

                        .done(function(data) {

                            if (
                                !data ||
                                !data.pedido
                            ) {

                                alert(
                                    'Não foi possível criar o pedido.'
                                );

                                $('#progressModal').hide();

                                return;
                            }


                            /*
                             * Guarda o pedido ANTES
                             * de iniciar qualquer upload.
                             */
                            state.pedido =
                                data.pedido;


                            /*
                             * Agora sim montamos a fila.
                             */
                            iniciarFilaUpload();

                        })

                        .fail(function(xhr) {

                            console.error(
                                'Erro ao criar pedido:',
                                xhr
                            );


                            $('#progressModal').hide();


                            alert(
                                'Não foi possível criar o pedido.'
                            );

                        });

                }

                function iniciarFilaUpload() {

                    const state =
                        window.easyPhotoUpload;

                    const $images =
                        $('#imageContainer .image-wrapper');


                    if (!$images.length) {

                        alert(
                            'Nenhuma imagem foi selecionada.'
                        );

                        $('#progressModal').hide();

                        return;
                    }


                    /*
                     * Limpa a fila.
                     */
                    state.queue = [];

                    state.active = 0;

                    state.totalBytes = 0;

                    state.uploadedBytes = 0;

                    state.errors = [];

                    state.finalized = false;


                    /*
                     * Monta a fila.
                     */
                    $images.each(function(index) {

                        const $wrapper =
                            $(this);


                        const file =
                            $wrapper.data('file');


                        if (!file) {

                            console.error(
                                'Arquivo não encontrado:',
                                index
                            );

                            return;

                        }


                        const size =
                            $wrapper
                            .find('.size-select')
                            .val();


                        const quantity =
                            $wrapper
                            .find('.quantity-input')
                            .val();


                        const price =
                            $wrapper
                            .find('.price-inputv')
                            .val();


                        state.totalBytes +=
                            file.size;


                        state.queue.push({

                            index: index,

                            $wrapper: $wrapper,

                            file: file,

                            size: size,

                            quantity: quantity,

                            price: price,

                            retries: 0,

                            progressBytes: 0

                        });

                    });


                    $('#progressModal h5').text(
                        'Enviando imagens...'
                    );


                    /*
                     * Inicia os 3 uploads.
                     */
                    processUploadQueue();

                }


                /*
                |--------------------------------------------------------------------------
                | PROCESSA A FILA
                |--------------------------------------------------------------------------
                */

                function processUploadQueue() {

                    const state =
                        window.easyPhotoUpload;


                    /*
                     * Preenche os slots disponíveis
                     */
                    while (

                        state.active <
                        state.MAX_CONCURRENT &&

                        state.queue.length > 0

                    ) {

                        const item =
                            state.queue.shift();


                        /*
                         * Arquivo removido antes do upload
                         */
                        if (

                            !item.$wrapper.length ||

                            item.$wrapper.data('removed')

                        ) {

                            continue;
                        }


                        state.active++;


                        item.$wrapper

                            .addClass('uploading')

                            .removeClass(
                                'upload-error upload-success'
                            );


                        uploadSingleImage(item)

                            .then(function(data) {


                                /*
                                 * Arquivo concluído
                                 */
                                state.uploadedBytes +=
                                    item.file.size;


                                item.$wrapper
                                    .removeData('uploadProgress')
                                    .removeClass('uploading')
                                    .addClass('upload-success');


                                /*
                                 * Guarda pedido
                                 */
                                if (
                                    data &&
                                    data.pedido
                                ) {

                                    state.pedido =
                                        data.pedido;

                                }


                                updateGeneralUploadProgress();

                            })


                            .catch(function(error) {


                                console.error(
                                    'Erro no upload:',
                                    item.file.name,
                                    error
                                );


                                item.$wrapper

                                    .removeClass(
                                        'uploading'
                                    )

                                    .addClass(
                                        'upload-error'
                                    );


                                state.errors.push({

                                    file: item.file.name,

                                    error: error

                                });

                            })


                            .finally(function() {

                                state.active--;

                                /*
                                 * Libera a próxima imagem
                                 */
                                processUploadQueue();

                            });

                    }


                    /*
                     * Tudo terminou
                     */
                    if (

                        state.queue.length === 0 &&

                        state.active === 0 &&

                        !state.finalized

                    ) {

                        finishUploadProcess();

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | ENVIA UMA IMAGEM
                |--------------------------------------------------------------------------
                */

                function uploadSingleImage(item) {

                    const state =
                        window.easyPhotoUpload;


                    return new Promise(function(resolve, reject) {


                        const formData =
                            new FormData();


                        /*
                         * Copia os campos do formulário
                         */
                        const originalFormData =
                            new FormData(
                                $('#uploadForm')[0]
                            );


                        originalFormData.forEach(
                            function(value, key) {

                                /*
                                 * Não copia arquivos existentes.
                                 *
                                 * A imagem será adicionada abaixo.
                                 */
                                if (
                                    !(value instanceof File)
                                ) {

                                    formData.append(
                                        key,
                                        value
                                    );

                                }

                            }
                        );


                        /*
                         * UMA imagem por requisição
                         */
                        formData.append(

                            'images[]',

                            item.file,

                            item.file.name

                        );


                        /*
                         * Dados desta imagem
                         */
                        formData.append(

                            'tamanhos',

                            JSON.stringify([
                                JSON.parse(item.size)
                            ])

                        );


                        formData.append(

                            'quantidades',

                            JSON.stringify([
                                item.quantity
                            ])

                        );


                        formData.append(

                            'precos',

                            JSON.stringify([
                                item.price
                            ])

                        );


                        /*
                         * Pedido já criado
                         */
                        if (state.pedido) {

                            formData.append(
                                'pedido_id',
                                state.pedido
                            );

                        }


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

                                const xhr =
                                    new XMLHttpRequest();


                                xhr.upload.addEventListener(

                                    'progress',

                                    function(evt) {

                                        if (
                                            !evt.lengthComputable
                                        ) {
                                            return;
                                        }


                                        item.progressBytes =
                                            evt.loaded;


                                        item.$wrapper.data(

                                            'uploadProgress',

                                            evt.loaded

                                        );


                                        updateGeneralUploadProgress();

                                    },

                                    false

                                );


                                return xhr;

                            },


                            success: function(data) {


                                item.progressBytes =
                                    item.file.size;


                                item.$wrapper.data(

                                    'uploadProgress',

                                    item.file.size

                                );


                                resolve(data);

                            },


                            error: function(xhr) {


                                /*
                                 * Retry
                                 */
                                if (
                                    item.retries <
                                    state.MAX_RETRIES
                                ) {

                                    item.retries++;


                                    console.warn(

                                        'Tentativa ' +
                                        item.retries +
                                        ' de ' +
                                        state.MAX_RETRIES,

                                        item.file.name

                                    );


                                    setTimeout(
                                        function() {


                                            item.progressBytes =
                                                0;


                                            item.$wrapper.data(

                                                'uploadProgress',

                                                0

                                            );


                                            uploadSingleImage(item)

                                                .then(resolve)

                                                .catch(reject);


                                        },

                                        item.retries * 2000

                                    );


                                } else {

                                    reject(xhr);

                                }

                            }

                        });

                    });

                }


                /*
                |--------------------------------------------------------------------------
                | ATUALIZA PROGRESSO GERAL
                |--------------------------------------------------------------------------
                */

                function updateGeneralUploadProgress() {

                    const state =
                        window.easyPhotoUpload;


                    let currentBytes =
                        state.uploadedBytes;


                    $('.image-wrapper.uploading')
                        .each(function() {

                            currentBytes +=

                                $(this).data(
                                    'uploadProgress'
                                ) || 0;

                        });


                    const percent =

                        state.totalBytes > 0

                        ?
                        Math.min(

                            100,

                            Math.round(

                                (
                                    currentBytes /
                                    state.totalBytes
                                ) * 100

                            )

                        )

                        :
                        0;


                    $('#uploadProgress')
                        .val(percent);


                    $('#progressModal h5').text(

                        'Enviando imagens... ' +
                        percent +
                        '%'

                    );

                }


                /*
                |--------------------------------------------------------------------------
                | FINALIZA O PROCESSO
                |--------------------------------------------------------------------------
                */

                function finishUploadProcess() {

                    const state =
                        window.easyPhotoUpload;


                    if (state.finalized) {
                        return;
                    }


                    state.finalized = true;


                    $('#uploadProgress')
                        .val(100);


                    if (state.errors.length === 0) {


                        $('#progressModal h5').text(
                            'Imagens enviadas com sucesso!'
                        );


                        setTimeout(function() {

                            $('#progressModal')
                                .hide();


                            if (state.pedido) {

                                window.location.href =
                                    '/pagamento/escolha/' +
                                    state.pedido;

                            } else {

                                alert(
                                    'Imagens enviadas, mas o pedido não foi identificado.'
                                );

                            }

                        }, 500);


                    } else {


                        $('#progressModal h5').text(

                            'Envio concluído com ' +
                            state.errors.length +
                            ' erro(s).'

                        );


                        console.error(
                            'Arquivos com erro:',
                            state.errors
                        );


                        setTimeout(function() {

                            $('#progressModal')
                                .hide();

                        }, 3000);


                        alert(

                            state.errors.length +
                            ' arquivo(s) não puderam ser enviados.'

                        );

                    }

                }



                $(document).on('click', '#progressModal .close', function() {
                    $('#progressModal').hide();
                });
                $(window).on('click', function(event) {
                    if (event.target === document.getElementById('progressModal')) {
                        $('#progressModal').hide();
                    }
                });
            });
        });
    </script>
    </body>

    </html>
@endsection
