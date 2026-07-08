

<table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Pedido</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Data</th>
                            <th scope="col">Obs.</th>
                            <th scope="col">Status Pedido</th>
                            <th scope="col">Status Pagamento</th>
                            <th scope="col">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos as $pedido)
                            <tr>
                                @php

                                    $nome = $pedido->cliente;

                                    $iniciais = mb_strstr($nome, ' ', true)[0] . trim(mb_strstr($nome, ' ')[1]);

                                @endphp
                                <th scope="row"><a
                                        href="{{ route('detalhes-pedidos-admin', $pedido->id) }}">{{ $pedido->id }}</th>
                                <td>
                                    <div class="cell-user">
                                        <div class="avatar xs">{{ $iniciais }}</div>{{ $pedido->cliente }}
                                    </div>
                                </td>
                                <td>{{ date('d/m/Y H:i', strtotime($pedido->created_at)) }}</td>
                                <td>{{ $pedido->observacao }}</td>
                                <td><span
                                        class="chip @if ($pedido->status == 'Finalizado') chip-green @elseif($pedido->status == 'Aguardando Impressão') chip-amber @else chip-red @endif ">{{ $pedido->status }}</span>
                                </td>

                                <td><span class="chip @if ($pedido->status_pagamento == 'pendente') chip-red @else chip-green @endif">
                                        {{ $pedido->status_pagamento }}</span></td>

                                <td class="text-end">
                                    <button class="icon-btn sm" title="Ver"><a
                                            href="{{ route('detalhes-pedidos-admin', $pedido->id) }}"><i
                                                class="bi bi-eye"></i></a></button>
                                    <div class="dropdown">
                                        <button type="button" class="icon-btn sm " data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('download-files', $pedido->id) }}">Baixar</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('altera-status', $pedido->id) }}">Finalizar</a></li>

                                        </ul>
                                    </div>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
  {{ $pedidos->links() }}

