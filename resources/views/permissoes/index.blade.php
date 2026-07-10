@extends('layouts.admin')

@section('title')
Permissões
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Permissões</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="admin-ui-page admin-ui-page-fluid">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Permissões</h1>
        </div>
        <a class="admin-ui-btn admin-ui-btn-primary" href="{{ route('permissoes.create') }}">
            <i class="fa fa-plus"></i>
            <span class="admin-ui-mobile-hide">Nova permissão</span>
        </a>
    </div>

    <hr class="admin-ui-divider">

    @if(session('success') || session('status'))
        <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="alert-content">
                <strong>{{ session('success') ?? session('status') }}</strong>
            </div>
            <div class="progress-bar-container">
                <div id="progress-bar" class="progress-bar"></div>
            </div>
        </div>
    @endif

    <div class="admin-ui-table-card admin-ui-card">
        <table class="table admin-ui-table" id="permissoes-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Criado em</th>
                    <th>Atualizado em</th>
                    <th class="admin-ui-actions-cell">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permissoes as $permissao)
                    <tr>
                        <td>
                            <div class="admin-ui-media-copy">
                                <p class="admin-ui-media-title">{{ $permissao->name }}</p>
                            </div>
                        </td>
                        <td><span class="admin-ui-meta">{{ $permissao->created_at->format('d/m/Y \à\s H:i') }}</span></td>
                        <td><span class="admin-ui-meta">{{ $permissao->updated_at->format('d/m/Y \à\s H:i') }}</span></td>
                        <td class="admin-ui-actions-cell">
                            <div class="dropdown">
                                <button class="admin-ui-dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $permissao->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-sliders2"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end admin-ui-actions-menu" aria-labelledby="dropdownMenuButton{{ $permissao->id }}">
                                    <li>
                                        @can('Editar Permissão')
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('permissoes.edit', $permissao->id) }}">
                                            <i class="bi bi-pencil-square admin-ui-action-icon-primary me-2"></i> Editar
                                        </a>
                                        @endcan
                                    </li>
                                    <li>
                                        @can('Deletar Permissão')
                                        <form action="{{ route('permissoes.destroy', $permissao->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item d-flex align-items-center"
                                                onclick="return confirm('Tem certeza que deseja deletar esta permissão?')">
                                                <i class="bi bi-trash admin-ui-action-icon-danger me-2"></i> Deletar
                                            </button>
                                        </form>
                                        @endcan
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="admin-ui-table-empty">Não há permissões cadastradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="permissoes-pagination-container">
        <x-admin.paginator :paginator="$permissoes" />
    </div>
</div>
@endsection
