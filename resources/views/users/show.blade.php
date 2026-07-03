@extends('layouts.admin')

@section('title')
{{ $user->name }}
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Membro - Visualização</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Membro - Visualização</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="admin-ui-page">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Membro</h1>
        </div>
        <a href="{{ route('users.index') }}" class="admin-ui-btn admin-ui-btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span class="admin-ui-mobile-hide">Voltar</span>
        </a>
    </div>

    <div class="admin-ui-card admin-ui-detail-card">
        <div class="admin-ui-detail-head">
            <div class="admin-ui-avatar-lg">
                <img src="/imagens/users/{{ $user->imagem }}" alt="{{ $user->alt }}">
            </div>
            <div class="admin-ui-media-copy">
                <h2 class="admin-ui-title" style="font-size: 1.85rem;">{{ $user->name ?: 'Não informado' }}</h2>
                <p class="admin-ui-subtitle">{{ $user->cargo ?: 'Não informado' }}</p>
            </div>
        </div>

        <div class="admin-ui-detail-grid">
            <div class="admin-ui-detail-item">
                <strong>Email</strong>
                <p>{{ $user->email ?: 'Não informado' }}</p>
            </div>
            <div class="admin-ui-detail-item">
                <strong>WhatsApp</strong>
                @if ($user->whatsapp)
                    <p>
                        <a href="https://wa.me/55{{ $user->whatsapp }}" target="_blank" class="admin-ui-link">
                            <i class="bi bi-whatsapp text-success me-1"></i>{{ preg_replace('/^(\d{2})(\d{5})(\d{4})$/', '($1) $2-$3', $user->whatsapp) }}
                        </a>
                    </p>
                @else
                    <p>Não informado</p>
                @endif
            </div>
            <div class="admin-ui-detail-item">
                <strong>Nome</strong>
                <p>{{ $user->name ?: 'Não informado' }}</p>
            </div>
            <div class="admin-ui-detail-item">
                <strong>Cargo</strong>
                <p>{{ $user->cargo ?: 'Não informado' }}</p>
            </div>
            <div class="admin-ui-detail-item">
                <strong>Biografia</strong>
                <p>{{ $user->biografia ?: 'Não informado' }}</p>
            </div>
            <div class="admin-ui-detail-item">
                <strong>LinkedIn</strong>
                @if ($user->linkedin)
                    <p><a href="{{ $user->linkedin }}" target="_blank" class="admin-ui-link">{{ $user->linkedin }}</a></p>
                @else
                    <p>Não informado</p>
                @endif
            </div>
            <div class="admin-ui-detail-item">
                <strong>GitHub</strong>
                @if ($user->github)
                    <p><a href="{{ $user->github }}" target="_blank" class="admin-ui-link">{{ $user->github }}</a></p>
                @else
                    <p>Não informado</p>
                @endif
            </div>
            <div class="admin-ui-detail-item">
                <strong>CPF</strong>
                <p>{{ $user->cpf ?: 'Não informado' }}</p>
            </div>
            <div class="admin-ui-detail-item">
                <strong>Status</strong>
                <p>{{ $user->ativo ? 'Sim' : 'Não' }}</p>
            </div>
            <div class="admin-ui-detail-item">
                <strong>Função</strong>
                <div class="admin-ui-role-list">
                    @if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $role)
                            <span class="admin-ui-badge admin-ui-badge-primary">{{ $role }}</span>
                        @endforeach
                    @else
                        <p>Não informado</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
