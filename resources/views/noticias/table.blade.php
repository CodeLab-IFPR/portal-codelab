<table class="table table-bordered table-striped mt-4" id="noticias-table">
    <thead>
        <tr>
            <th>Imagem</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Categoria</th>
            <th>Ação</th>
        </tr>
    </thead>

    <tbody>
        @forelse($noticias as $noticia)
            <tr>
                <td><img src="/imagens/noticias/{{ $noticia->imagem }}" alt="{{ $noticia->titulo }}" width="100px"></td>
                <td>{{ $noticia->titulo }}</td>
                <td>{{ $noticia->autor }}</td>
                <td>{{ $noticia->categoria }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                            id="dropdownMenuButton{{ $noticia->id }}" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-gear"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $noticia->id }}">
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('noticias.show', $noticia->id) }}">
                                    <i class="bi bi-eye text-secondary me-2"></i> Visualizar
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('noticias.edit', $noticia->id) }}">
                                    <i class="bi bi-pencil-square text-warning me-2"></i> Editar
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item d-flex align-items-center btn-delete"
                                    data-url="{{ route('noticias.destroy', $noticia->id) }}"
                                    data-titulo="{{ $noticia->titulo }}"
                                    data-autor="{{ $noticia->autor }}"
                                    data-categoria="{{ $noticia->categoria }}">
                                    <i class="bi bi-trash text-danger me-2"></i> Deletar
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Não há notícias 😢</td>
            </tr>
        @endforelse
    </tbody>
</table>

{!! $noticias->withQueryString()->links('pagination::bootstrap-5') !!}