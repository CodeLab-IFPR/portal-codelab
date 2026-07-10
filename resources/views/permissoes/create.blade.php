@extends('layouts.admin')

@section('title')
Nova Permissão
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('permissoes.index') }}">Permissões</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nova permissão</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="admin-ui-page admin-ui-page-narrow">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Nova permissão</h1>
        </div>
        <a href="{{ route('permissoes.index') }}" class="admin-ui-btn admin-ui-btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span class="admin-ui-mobile-hide">Voltar</span>
        </a>
    </div>

    <form action="{{ route('permissoes.store') }}" method="POST">
        @csrf

        <div class="admin-ui-card admin-ui-card-form">
            <div class="admin-ui-grid">
                <div class="admin-ui-field">
                    <label for="inputNomePermissao" class="admin-ui-label">Nome da permissão</label>
                    <input type="text" name="name" class="admin-ui-input @error('name') is-invalid @enderror"
                        id="inputNomePermissao" placeholder="Nome da permissão" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="admin-ui-actions">
            <a href="{{ route('permissoes.index') }}" class="admin-ui-btn admin-ui-btn-secondary">Cancelar</a>
            <button type="submit" class="admin-ui-btn admin-ui-btn-primary">
                <i class="fa-regular fa-floppy-disk"></i> Salvar
            </button>
        </div>
    </form>
</div>
@endsection
