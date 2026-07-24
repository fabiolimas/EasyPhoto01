

  <table class="table table-modern align-middle mb-0">
<thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>
        <th scope="col">Email</th>
         <th scope="col">Telefone</th>
         <th scope="col">Cidade</th>

        <th scope="col">Ações</th>
      </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente)
      <tr>
        <th scope="row">{{$cliente->id}}</th>
        <td>{{$cliente->nome}}</td>
        <td>{{$cliente->email}}</td>
        <td>{{$cliente->telefone}}</td>
        <td>{{$cliente->cidade}}</td>
        <td><a href="{{route('edit-cliente', $cliente->id)}}"title="Editar" class="btn btn-success"><i class="bi bi-pencil"></i></a> </td>
      </tr>
      @endforeach
    </tbody>

  </table>
  {{ $clientes->links() }}

