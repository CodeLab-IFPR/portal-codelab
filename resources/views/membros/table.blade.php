<table class="table table-bordered table-striped mt-4" id="membros-table">
    <thead>
        <tr>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Cpf</th>
            <th>Ativo</th>
            <th>Cargo</th>
            <th>Ação</th>
        </tr>
    </thead>

    <tbody>
        @forelse($membros as $membro)
            <tr>
                <td><img src="/imagens/{{ $membro->imagem }}" alt="{{ $membro->alt }}" width="100px"></td>
                <td>{{ $membro->nome }}</td>
                <td>{{ $membro->cpf }}</td>
                <td>{{ $membro->ativo ? 'Sim' : 'Não' }}</td>
                <td>{{ $membro->cargo }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                            id="dropdownMenuButton{{ $membro->id }}" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-gear"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $membro->id }}">
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('membros.show', $membro->id) }}">
                                    <i class="bi bi-eye text-secondary me-2"></i> Visualizar
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('membros.edit', $membro->id) }}">
                                    <i class="bi bi-pencil-square text-warning me-2"></i> Editar
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item d-flex align-items-center btn-delete"
                                    data-url="{{ route('membros.destroy', $membro->id) }}"
                                    data-nome="{{ $membro->nome }}"
                                    data-cpf="{{ $membro->cpf }}"
                                    data-cargo="{{ $membro->cargo }}"
                                    data-imagem="/imagens/{{ $membro->imagem }}"
                                    data-alt="{{ $membro->alt }}">
                                    <i class="bi bi-trash text-danger me-2"></i> Deletar
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a class="btn btn-outline-success btn-sm"
                            href="{{ route('membros.create') }}">
                            <i class="fa fa-plus"></i> Adicionar Membro
                        </a>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

{!! $membros->withQueryString()->links('pagination::bootstrap-5') !!}