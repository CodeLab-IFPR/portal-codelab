<table class="table admin-ui-table" id="parceiros-table">
    <thead>
        <tr>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Email</th>
            <th class="admin-ui-actions-cell">Ações</th>
        </tr>
    </thead>

    <tbody>
        @forelse($parceiros as $parceiro)
            <tr>
                <td>
                    <div class="admin-ui-media">
                        <a href="{{ $parceiro->link }}" class="admin-ui-avatar" target="_blank">
                            <img src="/imagens/parceiros/{{ $parceiro->imagem }}" alt="{{ $parceiro->alt }}">
                        </a>
                    </div>
                </td>
                <td>
                    <div class="admin-ui-media-copy">
                        <p class="admin-ui-media-title">{{ $parceiro->nome }}</p>
                    </div>
                </td>
                <td><a href="mailto:{{ $parceiro->email }}" class="admin-ui-link">{{ $parceiro->email }}</a></td>
                <td class="admin-ui-actions-cell">
                    <div class="dropdown">
                        <button class="admin-ui-dropdown-toggle" type="button"
                            id="dropdownMenuButton{{ $parceiro->id }}" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-sliders2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end admin-ui-actions-menu" aria-labelledby="dropdownMenuButton{{ $parceiro->id }}">
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('parceiros.show', $parceiro->id) }}">
                                    <i class="bi bi-eye admin-ui-action-icon-primary me-2"></i> Visualizar
                                </a>
                            </li>
                            <li>
                                @can('Editar Parceiro')
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('parceiros.edit', $parceiro->id) }}">
                                    <i class="bi bi-pencil-square admin-ui-action-icon-primary me-2"></i> Editar
                                </a>
                                @endcan
                            </li>
                            <li>
                                @can('Deletar Parceiro')
                                <a href="#" class="dropdown-item d-flex align-items-center btn-delete"
                                    data-url="{{ route('parceiros.destroy', $parceiro->id) }}"
                                    data-nome="{{ $parceiro->nome }}"
                                    data-email="{{ $parceiro->email }}">
                                    <i class="bi bi-trash admin-ui-action-icon-danger me-2"></i> Deletar
                                </a>
                                @endcan
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="admin-ui-table-empty">Não há parceiros cadastrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{!! $parceiros->withQueryString()->links('pagination::bootstrap-5') !!}
