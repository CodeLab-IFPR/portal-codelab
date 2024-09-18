<table class="table table-bordered table-striped mt-4">
    <thead>
        <tr>
            <th>Membro - Nome</th>
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
                <td>{{ $certificado->membro->nome }}</td>
                <td>{{ mb_strimwidth("$certificado->descricao", 0, 250, "...") }}</td>
                <td>{{ $certificado->horas }}</td>
                <td>{{ \Carbon\Carbon::parse($certificado->data)->format('d/m/Y') }}</td>
                <td>{{ $certificado->token }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                            id="dropdownMenuButton{{ $certificado->id }}" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-gear"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $certificado->id }}">
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('certificados.view',$certificado->id) }}">
                                    <i class="bi bi-eye text-secondary me-2"></i> Visualizar
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('certificados.edit',$certificado->id) }}">
                                    <i class="bi bi-pencil-square text-warning me-2"></i> Editar
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('certificados.destroy',$certificado->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item d-flex align-items-center">
                                        <i class="bi bi-trash text-danger me-2"></i> Deletar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a class="btn btn-outline-success btn-sm" href="{{ route('certificados.create') }}">
                            <i class="fa fa-plus"></i> Adicionar Certificado
                        </a>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>