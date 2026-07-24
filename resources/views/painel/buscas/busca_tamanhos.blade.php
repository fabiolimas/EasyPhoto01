

  <table class="table mt-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tamanhos as $tamanho)
                    <tr>
                        <th scope="row">{{ $tamanho->id }}</th>
                        <td>{{ $tamanho->nome }}</td>
                        <td>R$ {{ number_format($tamanho->preco, 2, ',', '.') }}</td>

                        <td><a href="{{ route('edit-tamanho', $tamanho->id) }}" class="btn btn-success" title="Editar"><i
                                    class="bi bi-pencil"></i></a> | <a href="{{ route('destroy-tamanho', $tamanho->id) }}"
                                class="btn btn-danger" title="Excluir"><i class="bi bi-trash"></i> </a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
  {{ $tamanhos->links() }}

