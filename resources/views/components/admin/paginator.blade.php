@props([
    'paginator',
])

@php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
    $window = 1;
    $pageItemCount = $paginator->count();
    $total = $paginator->total();
@endphp

@if ($lastPage > 1)
    <div class="admin-ui-pagination-shell">
        <p class="admin-ui-pagination-summary mb-0">
            Mostrando {{ $pageItemCount }} de {{ $total }} resultados
        </p>

        <nav class="admin-ui-pagination" aria-label="Navegacao de paginas">
            <a
                href="{{ $paginator->onFirstPage() ? '#' : $paginator->previousPageUrl() }}"
                class="admin-ui-pagination-btn admin-ui-pagination-btn-nav {{ $paginator->onFirstPage() ? 'is-disabled' : '' }}"
                aria-label="Pagina anterior"
                @if ($paginator->onFirstPage()) aria-disabled="true" tabindex="-1" @endif
            >
                <i class="bi bi-chevron-left"></i>
            </a>

            @for ($page = 1; $page <= $lastPage; $page++)
                @if (
                    $page === 1 ||
                    $page === $lastPage ||
                    ($page >= $currentPage - $window && $page <= $currentPage + $window)
                )
                    <a
                        href="{{ $paginator->url($page) }}"
                        class="admin-ui-pagination-btn {{ $page === $currentPage ? 'is-active' : '' }}"
                        aria-current="{{ $page === $currentPage ? 'page' : 'false' }}"
                    >
                        {{ $page }}
                    </a>
                @elseif (
                    $page === 2 && $currentPage - $window > 2 ||
                    $page === $lastPage - 1 && $currentPage + $window < $lastPage - 1
                )
                    <span class="admin-ui-pagination-ellipsis" aria-hidden="true">...</span>
                @endif
            @endfor

            <a
                href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() : '#' }}"
                class="admin-ui-pagination-btn admin-ui-pagination-btn-nav {{ $paginator->hasMorePages() ? '' : 'is-disabled' }}"
                aria-label="Proxima pagina"
                @if (! $paginator->hasMorePages()) aria-disabled="true" tabindex="-1" @endif
            >
                <i class="bi bi-chevron-right"></i>
            </a>
        </nav>
    </div>
@endif
