<table class="table admin-ui-table" id="galeria-table">
    <thead>
        <tr>
            <th>Mídia</th>
            <th>Título</th>
            <th>Descrição</th>
            <th class="admin-ui-actions-cell">Ações</th>
        </tr>
    </thead>

    <tbody>
        @forelse($midias as $midia)
            <tr id="midia-{{ $midia->id }}">
                <td>
                    @php
                        $videoId = '';

                        if ($midia->tipo === 'video' && preg_match('/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/', $midia->caminho, $match)) {
                            $videoId = $match[7];
                        }
                    @endphp

                    <div class="admin-ui-media">
                        <div class="admin-ui-thumbnail admin-ui-thumbnail-4x3">
                            @if($midia->tipo === 'imagem')
                                <img src="{{ asset($midia->caminho) }}" alt="{{ $midia->titulo }}">
                            @else
                                <img src="https://img.youtube.com/vi/{{ $videoId }}/mqdefault.jpg" alt="{{ $midia->titulo }}">
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <div class="admin-ui-media-copy">
                        <p class="admin-ui-media-title">{{ $midia->titulo }}</p>
                    </div>
                </td>
                <td><span class="admin-ui-meta">{{ $midia->descricao ?: 'Sem descrição' }}</span></td>
                <td class="admin-ui-actions-cell">
                    <div class="dropdown">
                        <button class="admin-ui-dropdown-toggle" type="button"
                            id="dropdownMenuButton{{ $midia->id }}" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-sliders2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end admin-ui-actions-menu" aria-labelledby="dropdownMenuButton{{ $midia->id }}">
                            <li>
                                @can('Editar Galeria')
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('galeria.edit', $midia->id) }}">
                                    <i class="bi bi-pencil-square admin-ui-action-icon-primary me-2"></i> Editar
                                </a>
                                @endcan
                            </li>
                            <li>
                                @can('Deletar Galeria')
                                <button type="button" class="dropdown-item d-flex align-items-center btn-delete"
                                    data-url="{{ route('galeria.destroy', $midia->id) }}"
                                    data-titulo="{{ $midia->titulo }}"
                                    data-preview="{{ $midia->tipo === 'imagem' ? asset($midia->caminho) : 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg' }}">
                                    <i class="bi bi-trash admin-ui-action-icon-danger me-2"></i> Deletar
                                </button>
                                @endcan
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="admin-ui-table-empty">Não há mídias cadastradas.</td>
            </tr>
        @endforelse
    </tbody>
</table>
