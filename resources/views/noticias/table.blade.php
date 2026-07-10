<table class="table admin-ui-table" id="noticias-table">
    <thead>
        <tr>
            <th>Imagem</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Categoria</th>
            <th class="admin-ui-actions-cell">Ações</th>
        </tr>
    </thead>

    <tbody>
        @forelse($noticias as $noticia)
            <tr>
                <td>
                    <div class="admin-ui-media">
                        <div class="admin-ui-thumbnail admin-ui-thumbnail-4x3">
                            <img src="/imagens/noticias/{{ $noticia->imagem }}" alt="{{ $noticia->alt ?? $noticia->titulo }}">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="admin-ui-media-copy">
                        <p class="admin-ui-media-title">{{ $noticia->titulo }}</p>
                    </div>
                </td>
                <td><span class="admin-ui-meta">{{ $noticia->autor }}</span></td>
                <td><span class="admin-ui-meta">{{ $noticia->categoria }}</span></td>
                <td class="admin-ui-actions-cell">
                    <div class="dropdown">
                        <button class="admin-ui-dropdown-toggle" type="button"
                            id="dropdownMenuButton{{ $noticia->id }}" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-sliders2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end admin-ui-actions-menu" aria-labelledby="dropdownMenuButton{{ $noticia->id }}">
                            <li>
                                @can('Editar Notícia')
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('noticias.edit', $noticia->id) }}">
                                    <i class="bi bi-pencil-square admin-ui-action-icon-primary me-2"></i> Editar
                                </a>
                                @endcan
                            </li>
                            <li>
                                @can('Deletar Notícia')
                                <a href="#" class="dropdown-item d-flex align-items-center btn-delete"
                                    data-url="{{ route('noticias.destroy', $noticia->id) }}"
                                    data-titulo="{{ $noticia->titulo }}"
                                    data-autor="{{ $noticia->autor }}"
                                    data-categoria="{{ $noticia->categoria }}">
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
                <td colspan="5" class="admin-ui-table-empty">Não há notícias cadastradas.</td>
            </tr>
        @endforelse
    </tbody>
</table>
