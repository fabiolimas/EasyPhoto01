

  <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Permissão</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <th scope="row">{{ $usuario->id }}</th>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td><span
                                        class="tag @if ($usuario->nivel == 'administrador') tag-purple @elseif($usuario->nivel == 'laboratorio') tag-blue @else tag-gray @endif">{{ $usuario->nivel }}</span>
                                </td>
                                <td><a href="{{ route('edit-user', $usuario->id) }}"title="Editar"
                                        class="btn btn-success"><i class="bi bi-pencil"></i></a> | <a
                                        href="{{ route('destroy-user', $usuario->id) }}"title="Excluir"
                                        class="btn btn-danger"><i class="bi bi-trash"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
  {{ $usuarios->links() }}

