@extends('layouts.admin')

@section('title', 'Funções')

@section('breadcrumb')
<x-admin.breadcrumb :items="[
    ['label' => 'Início', 'url' => route('admin')],
    ['label' => 'Funções'],
]" />
@endsection

@section('content')
<div class="admin-ui-page admin-ui-page-fluid">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Funções</h1>
        </div>
        @can('Criar Função')
            <a class="admin-ui-btn admin-ui-btn-primary" href="{{ route('funcoes.create') }}" aria-label="Nova função">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <span class="admin-ui-mobile-hide">Nova função</span>
            </a>
        @endcan
    </div>
    <hr class="admin-ui-divider">

    @if (session('success') || session('status'))
        <div class="alert alert-success" role="alert">{{ session('success') ?? session('status') }}</div>
    @endif

    <div class="admin-ui-table-card admin-ui-card">
        <table class="table admin-ui-table" id="funcoes-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Permissões</th>
                    <th>Data de criação</th>
                    <th>Data de atualização</th>
                    <th class="admin-ui-actions-cell">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr>
                        <td><p class="admin-ui-media-title">{{ $role->name }}</p></td>
                        <td>
                            <div class="admin-ui-permission-tags">
                                @forelse ($role->permissions->take(4) as $permissao)
                                    <span class="admin-ui-permission-chip">{{ $permissao->name }}</span>
                                @empty
                                    <span class="admin-ui-meta">Sem permissões</span>
                                @endforelse
                                @if ($role->permissions->count() > 4)
                                    <button type="button" class="admin-ui-permission-more" data-bs-toggle="modal"
                                        data-bs-target="#rolePermissions{{ $role->id }}" aria-label="Ver todas as permissões de {{ $role->name }}">
                                        +{{ $role->permissions->count() - 4 }} mais
                                    </button>
                                @endif
                            </div>
                        </td>
                        <td><span class="admin-ui-meta">{{ $role->created_at?->format('d/m/Y \à\s H:i') ?? '—' }}</span></td>
                        <td><span class="admin-ui-meta">{{ $role->updated_at?->format('d/m/Y \à\s H:i') ?? '—' }}</span></td>
                        <td class="admin-ui-actions-cell">
                            @canany(['Editar Função', 'Deletar Função'])
                                <div class="dropdown">
                                    <button class="admin-ui-dropdown-toggle" type="button" id="roleActions{{ $role->id }}"
                                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="Ações de {{ $role->name }}">
                                        <i class="bi bi-sliders2" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end admin-ui-actions-menu" aria-labelledby="roleActions{{ $role->id }}">
                                        @can('Editar Função')
                                            <li><a class="dropdown-item d-flex align-items-center" href="{{ route('funcoes.edit', $role->id) }}">
                                                <i class="bi bi-pencil-square admin-ui-action-icon-primary me-2"></i> Editar
                                            </a></li>
                                        @endcan
                                        @can('Deletar Função')
                                            <li><button type="button" class="dropdown-item d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#confirmDeleteRoleModal"
                                                data-url="{{ route('funcoes.destroy', $role->id) }}" data-name="{{ $role->name }}">
                                                <i class="bi bi-trash admin-ui-action-icon-danger me-2"></i> Deletar
                                            </button></li>
                                        @endcan
                                    </ul>
                                </div>
                            @endcanany
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="admin-ui-table-empty">Não há funções cadastradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <x-admin.paginator :paginator="$roles->withQueryString()" />
</div>

@foreach ($roles as $role)
    @if ($role->permissions->count() > 4)
        <div class="modal fade" id="rolePermissions{{ $role->id }}" tabindex="-1" aria-labelledby="rolePermissionsTitle{{ $role->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5 text-break" id="rolePermissionsTitle{{ $role->id }}">Permissões de {{ $role->name }}</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="admin-ui-role-list">
                            @foreach ($role->permissions as $permissao)
                                <span class="admin-ui-permission-chip">{{ $permissao->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="admin-ui-btn admin-ui-btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

@can('Deletar Função')
    <div class="modal fade" id="confirmDeleteRoleModal" tabindex="-1" aria-labelledby="confirmDeleteRoleTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="confirmDeleteRoleTitle">Confirmar exclusão</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza de que deseja excluir a função <strong id="delete-role-name" class="text-break"></strong>?</p>
                    <p class="mb-0">Esta ação não pode ser desfeita.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="admin-ui-btn admin-ui-btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="delete-role-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('confirmDeleteRoleModal').addEventListener('show.bs.modal', function (event) {
            document.getElementById('delete-role-name').textContent = event.relatedTarget.dataset.name;
            document.getElementById('delete-role-form').action = event.relatedTarget.dataset.url;
        });
    </script>
@endcan
@endsection
