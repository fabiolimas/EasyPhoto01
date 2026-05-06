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
          <textarea id="observacao_text" class="form-control form-control-dark" rows="4" placeholder="Digite uma observação para o pedido..."></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-action btn-action-primary" id="salvarObservacao" data-bs-dismiss="modal">Salvar</button>
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
              <input class="form-check-input entregainput" type="radio" name="entrega" id="entrega{{ $entrega->id }}" value="{{ $entrega->id }}">
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
          <button type="button" class="btn-action btn-action-dark" data-bs-toggle="modal" data-bs-target="#modalObservacao">
            <i class="bi bi-chat-left-text"></i> Observação
          </button>
          <button type="button" class="btn-action btn-action-dark" data-bs-toggle="modal" data-bs-target="#modalEntrega">
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
    $(function () {
      const modalEscolha = new bootstrap.Modal(document.getElementById('modalEscolha'));

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

      $('#imageInput').on('change', function () {
        const files = Array.from(this.files);
        handleFiles(files);
      });

      $('#salvarObservacao').on('click', function () {
        $('#observacao_input').val($('#observacao_text').val());
      });

      $('#processButton').on('click', function () {
        if (!selecionado) {
          new bootstrap.Modal(document.getElementById('modalAviso')).show();
          return;
        }

        const formData = new FormData($('#uploadForm')[0]);
        let sizeArray = [], quantityArray = [], priceArray = [];
        let imagesProcessed = 0;
        const images = $('#imageContainer img');

        if (images.length === 0) return;

        images.each(function (i, img) {
          fetch(img.src).then(res => res.blob()).then(blob => {
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

      let selecionado = false;

      $(document).on('change', '.entregainput', function () {
        selecionado = true;
        $('#processButton').removeClass('disabled');

        let entregaId = $('input[name="entrega"]:checked').val();

        $.ajax({
          url: '/buscar-entrega/' + entregaId,
          type: 'GET',
          dataType: 'json',
          success: function (response) {
            $('#val_entrega').val(response.valor);
            $('#forma_entrega').val(response.nome);
            updateTotalPedido();
          },
          error: function () {
            console.error('Erro ao buscar valor da entrega');
          }
        });
      });

      function handleFiles(files) {
        if (files.length < 1) {
          modalEscolha.show();
          return;
        }

        files.forEach(function (file) {
          const reader = new FileReader();
          reader.onload = function (e) {
            const $col = $('<div>').addClass('col-12 col-sm-6 col-md-4 col-lg-3 image-wrapper');
            const $card = $('<div>').addClass('image-card');
            const $thumb = $('<div>').addClass('image-card-thumb');
            const $img = $('<img>').attr('src', e.target.result);
            $thumb.append($img);

            const $atributos = $('<div>').addClass('atributos');

            const $sizeLabel = $('<label>').text('Tamanho');
            const $sizeSelect = $('<select>').addClass('size-select').on('change', function () {
              updatePrice($col, $(this).val());
            });
            cropSizes.forEach(function (size, index) {
              const $option = $('<option>').val(JSON.stringify(size)).text(size.height + 'x' + size.width);
              if (index === 0) $option.prop('selected', true);
              $sizeSelect.append($option);
            });

            const $qtyLabel = $('<label>').text('Quantidade');
            const $qtyInput = $('<input>').addClass('quantity-input').attr({
              type: 'number', min: '1', value: '1'
            });

            const $priceSpan = $('<span>').addClass('price-input');
            const $priceInput = $('<input>').addClass('price-inputv').attr({ type: 'hidden', readonly: true });
            const $subtotal = $('<div>').addClass('item-total mt-2');

            const $deleteBtn = $('<button>').attr('type', 'button')
              .addClass('btn btn-danger btn-sm')
              .html('<i class="bi bi-trash3"></i> Remover')
              .on('click', function () {
                $col.remove();
                updateTotalPedido();
              });

            const $controls = $('<div>').addClass('image-controls').append($deleteBtn);

            $atributos.append(
              $('<div class="w-100 d-flex gap-2 align-items-center flex-wrap"></div>').append(
                $sizeSelect, $qtyInput, $priceSpan, $priceInput
              ),
              $subtotal,
              $controls
            );

            $card.append($thumb, $atributos);
            $col.append($card);
            $('#imageContainer').append($col);

            updatePrice($col, $sizeSelect.val());
          };
          reader.readAsDataURL(file);
        });
      }

      function updatePrice(wrapper, size) {
        const parsedSize = JSON.parse(size);
        const price = parsedSize.price;
        wrapper.find('.price-input').html(price.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
        wrapper.find('.price-inputv').val(price);
        updateTotalPedido();
      }

      $(document).on('input', '.quantity-input', function () {
        const wrapper = $(this).closest('.image-wrapper');
        const size = wrapper.find('.size-select').val();
        updatePrice(wrapper, size);
      });

      function updateTotalPedido() {
        let total = 0;
        const valor_entrega = parseFloat($('#val_entrega').val()) || 0;
        $('#imageContainer .image-wrapper').each(function () {
          const price = parseFloat($(this).find('.price-inputv').val()) || 0;
          const quantity = parseInt($(this).find('.quantity-input').val()) || 1;
          total += price * quantity;
        });
        total += valor_entrega;
        $('#input_total').val(total);
        $('#total_pedido').html(total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
      }

      function uploadImages(formData) {
        $('#progressModal').css('display', 'flex');

        $.ajax({
          url: '{{ route('upload.image') }}',
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
          data: formData,
          processData: false,
          contentType: false,
          xhr: function () {
            const xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener('progress', function (evt) {
              if (evt.lengthComputable) {
                const percent = (evt.loaded / evt.total) * 100;
                $('#uploadProgress').val(percent);
                if (percent === 100) $('#progressModal').hide();
              }
            }, false);
            return xhr;
          },
          success: function (data) {
            if (data.images) {
              alert('Imagens enviadas com sucesso');
              window.location.href = '/detalhe-pedido/' + data.pedido;
            }
          },
          error: function (error) {
            console.error('Erro:', error);
            $('#progressModal').hide();
          }
        });
      }

      $(document).on('click', '#progressModal .close', function () {
        $('#progressModal').hide();
      });
      $(window).on('click', function (event) {
        if (event.target === document.getElementById('progressModal')) {
          $('#progressModal').hide();
        }
      });
    });
  </script>
</body>
</html>
@endsection
