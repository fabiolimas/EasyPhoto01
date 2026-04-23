

<table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">Pedido</th>
        <th scope="col">Cliente</th>
        <th scope="col">Data</th>
        <th scope="col">Status</th>
         <th scope="col">Opções</th>
      </tr>
    </thead>
    <tbody class="result">
        @foreach($pedidos as $pedido)
      <tr>
        <th scope="row"><a href="{{route('detalhes-pedidos-admin', $pedido->id)}}">{{$pedido->id}}</th>
        <td>{{$pedido->cliente}}</td>
        <td>{{date('d/m/Y H:i', strtotime($pedido->created_at))}}</td>
        <td class="@if($pedido->status=='Aguardando Impressão') text-danger @else text-success @endif">{{$pedido->status}}</td>

        <td><a href="{{route('download-files',$pedido->id)}}"><i class="fa fa-user-pen"></i> <i class="fas fa-download"></i></a> | <a href="{{route('altera-status', $pedido->id)}}"><i class="fas fa-check-circle"></i></a></td>
      </tr>
      @endforeach
    </tbody>

  </table>
  {{ $pedidos->links() }}

