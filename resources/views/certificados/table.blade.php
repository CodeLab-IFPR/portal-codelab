<table class="table table-bordered table-striped mt-4" id="certificados-table">
            <thead>
                <tr>
                    <th>User - Nome</th>
                    <th>Descrição</th>
                    <th>Horas</th>
                    <th>Data Certificado</th>
                    <th>Token</th>
                    <th>Ação</th>
                </tr>
            </thead>

            <tbody>
                @forelse($certificados as $certificado)
                    <tr>
                        <td>{{ $certificado->user->nome }}</td>
                        <td>{{ mb_strimwidth("$certificado->descricao", 0, 250, "...") }}
                        </td>
                        <td>{{ $certificado->horas }} </td>
                        <td>{{ \Carbon\Carbon::parse($certificado->data)->format('d/m/Y') }}
                        </td>
                        <td>{{ $certificado->token }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $certificado->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-gear"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $certificado->id }}">
                                <a class="dropdown-item d-flex align-items-center external-link" href="{{ route('certificados.view', $certificado->id) }}">
                                    <i class="bi bi-eye text-secondary me-2"></i> Visualizar
                                </a>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('certificados.edit', $certificado->id) }}">
                                            <i class="bi bi-pencil-square text-warning me-2"></i> Editar
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item d-flex align-items-center btn-delete"
                                            data-url="{{ route('certificados.destroy', $certificado->id) }}"
                                            data-nome="{{ $certificado->user->nome }}"
                                            data-descricao="{{ $certificado->descricao }}"
                                            data-horas="{{ $certificado->horas }}"
                                            data-data="{{ \Carbon\Carbon::parse($certificado->data)->format('d/m/Y') }}"
                                            data-token="{{ $certificado->token }}">
                                            <i class="bi bi-trash text-danger me-2"></i> Deletar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Não há certificados 😢</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

{!! $certificados->withQueryString()->links('pagination::bootstrap-5') !!}