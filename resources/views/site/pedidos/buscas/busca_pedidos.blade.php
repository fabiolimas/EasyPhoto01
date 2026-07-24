<table class="table">
    <thead>
      <tr>
        <th scope="col">Pedido</th>
        <th scope="col">Cliente</th>
        <th scope="col">Loja</th>
        <th scope="col">Data</th>
        <th scope="col">Obs.</th>
        <th scope="col">Status</th>
           <th scope="col">Status Pagamento</th>

         <th scope="col">Ações</th>
      </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $pedido)
      <tr>
        <th scope="row">{{$pedido->id}}</th>
        <td>{{$pedido->cliente}}</td>
        @switch($pedido->laboratorio_id)
            @case(1)
            <td>Jacobina</td>
                @break
            @case(2)
            <td>Petrolina</td>
                @break
            @default

        @endswitch

        <td>{{date('d/m/Y H:i', strtotime($pedido->created_at))}}</td>
        <td>{{$pedido->observacao}}</td>
        <td class="">
                        <span
                                        class="chip @if ($pedido->status == 'Finalizado') chip-green @elseif($pedido->status == 'Aguardando Impressão') chip-amber @else chip-red @endif ">{{ $pedido->status }}</span></td>
                         <td >
                       <span class="chip @if ($pedido->status_pagamento == 'pendente') chip-red @else chip-green @endif">
                                        {{ $pedido->status_pagamento }}</span></td>

        <td><a href="{{route('detalhe-pedido', $pedido->id)}}" class="btn btn-danger"><i class="bi bi-images"></i> Visualizar</a></td>

      </tr>
      @endforeach
    </tbody>
  </table>
{{$pedidos->links()}}
