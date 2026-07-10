@props([
    'items' => null,
    'resource' => null,
    'action' => null,
])

@php
    $resources = [
        'funcoes' => [
            'label' => 'Cargos',
            'route' => 'funcoes.index',
            'create' => 'Novo Cargo',
            'edit' => 'Editar Função',
        ],
        'permissoes' => [
            'label' => 'Permissões',
            'route' => 'permissoes.index',
            'create' => 'Nova permissão',
            'edit' => 'Editar permissão',
        ],
        'noticias' => [
            'label' => 'Notícias',
            'route' => 'noticias.index',
            'create' => 'Nova notícia',
            'edit' => 'Editar notícia',
        ],
        'users' => [
            'label' => 'Membros',
            'route' => 'users.index',
            'create' => 'Novo Membro',
            'edit' => 'Editar Membro',
        ],
        'parceiros' => [
            'label' => 'Parceiros',
            'route' => 'parceiros.index',
            'create' => 'Novo Parceiro',
            'edit' => 'Editar Parceiro',
        ],
        'galeria' => [
            'label' => 'Galeria',
            'route' => 'galeria.indexAdmin',
            'create' => 'Nova Mídia',
            'edit' => 'Editar Galeria',
        ],
        'certificados' => [
            'label' => 'Certificados',
            'route' => 'certificados.index',
            'create' => 'Novo certificado',
            'edit' => 'Editar certificado',
        ],
        'projetos' => [
            'label' => 'Projetos',
            'route' => 'projetos.index',
            'create' => 'Novo Projeto',
            'edit' => 'Editar Projeto',
        ],
        'servicos' => [
            'label' => 'Serviços',
            'route' => 'servicos.index',
            'create' => 'Novo Serviço',
            'edit' => 'Editar Serviço',
        ],
        'lancamentos' => [
            'label' => 'Lançamentos',
            'route' => 'lancamentos.index',
            'create' => 'Novo Lançamento',
            'edit' => 'Editar Lançamento',
        ],
        'tags' => [
            'label' => 'Tags',
            'route' => 'tags.index',
            'create' => 'Nova tag',
            'edit' => 'Editar tag',
        ],
    ];

    $segments = request()->segments();
    $adminHomeUrl = route('admin');
    $adminHomePath = route('admin', [], false);
    $isAdminHome = request()->getPathInfo() === $adminHomePath;
    $resolvedItems = $items ? collect($items)->values()->all() : null;

    if (!$resolvedItems) {
        $resourceKey = $resource;

        if (!$resourceKey) {
            $resourceKey = collect($segments)
                ->reverse()
                ->first(fn ($segment) => array_key_exists($segment, $resources));
        }

        $resourceConfig = $resourceKey ? ($resources[$resourceKey] ?? null) : null;
        $lastSegment = collect($segments)->last();
        $resolvedAction = $action;

        if (!$resolvedAction && in_array($lastSegment, ['create', 'edit', 'editar'], true)) {
            $resolvedAction = $lastSegment === 'create' ? 'create' : 'edit';
        }

        if ($isAdminHome) {
            $resolvedItems = [
                ['label' => 'Início', 'active' => true],
            ];
        } elseif ($resourceConfig) {
            $resolvedItems = [
                ['label' => 'Início', 'url' => $adminHomeUrl],
            ];

            if ($resolvedAction) {
                $resolvedItems[] = [
                    'label' => $resourceConfig['label'],
                    'url' => route($resourceConfig['route']),
                ];
                $resolvedItems[] = [
                    'label' => $resourceConfig[$resolvedAction] ?? $resourceConfig['label'],
                    'active' => true,
                ];
            } else {
                $resolvedItems[] = [
                    'label' => $resourceConfig['label'],
                    'active' => true,
                ];
            }
        } else {
            $fallbackLabel = trim($__env->yieldContent('title')) ?: 'Início';
            $resolvedItems = [
                ['label' => 'Início', 'url' => $adminHomeUrl],
                ['label' => $fallbackLabel, 'active' => true],
            ];
        }
    }
@endphp

<ol {{ $attributes->merge(['class' => 'breadcrumb admin-header-breadcrumb']) }}>
    @foreach ($resolvedItems as $index => $item)
        @php
            $isFirst = $index === 0;
            $isActive = $item['active'] ?? $loop->last;
            $label = $item['label'] ?? '';
            $url = $item['url'] ?? null;
        @endphp

        <li class="breadcrumb-item {{ $isActive ? 'active' : '' }}" @if($isActive) aria-current="page" @endif>
            @if ($url && !$isActive)
                <a href="{{ $url }}">
                    @if ($isFirst)
                        <i class="bi bi-house-door" aria-hidden="true"></i>
                    @endif
                    {{ $label }}
                </a>
            @else
                @if ($isFirst)
                    <i class="bi bi-house-door" aria-hidden="true"></i>
                @endif
                {{ $label }}
            @endif
        </li>
    @endforeach
</ol>
