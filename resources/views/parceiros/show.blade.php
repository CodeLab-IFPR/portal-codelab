@extends('layouts.admin')

@section('title')
{{ $parceiro->nome }}
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Parceiro - Visualização</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Parceiro - Visualização</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="admin-ui-page admin-ui-page-narrow">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Parceiro</h1>
        </div>
        <a href="{{ route('parceiros.index') }}" class="admin-ui-btn admin-ui-btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span class="admin-ui-mobile-hide">Voltar</span>
        </a>
    </div>

    <div class="admin-ui-card admin-ui-detail-card">
        <div class="admin-ui-detail-head">
            <div class="admin-ui-avatar-lg">
                <img src="/imagens/parceiros/{{ $parceiro->imagem }}" alt="{{ $parceiro->alt }}">
            </div>
            <div class="admin-ui-media-copy">
                <h2 class="admin-ui-title" style="font-size: 1.85rem;">{{ $parceiro->nome }}</h2>
                <p class="admin-ui-subtitle">Cadastro de parceiro do ecossistema CodeLab.</p>
            </div>
        </div>

        <div class="admin-ui-detail-grid">
            <div class="admin-ui-detail-item">
                <strong>Nome</strong>
                <p>{{ $parceiro->nome }}</p>
            </div>
            <div class="admin-ui-detail-item">
                <strong>E-mail</strong>
                <p>{{ $parceiro->email }}</p>
            </div>
            <div class="admin-ui-detail-item">
                <strong>URL</strong>
                <p><a href="{{ $parceiro->link }}" target="_blank" class="admin-ui-link">{{ $parceiro->link }}</a></p>
            </div>
            <div class="admin-ui-detail-item">
                <strong>Alt</strong>
                <p>{{ $parceiro->alt }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
