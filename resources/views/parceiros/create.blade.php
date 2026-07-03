@extends('layouts.admin')

@section('title')
Novo Parceiro
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Novo Parceiro</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Novo Parceiro</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="admin-ui-page admin-ui-page-narrow">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Novo Parceiro</h1>
        </div>
        <a href="{{ route('parceiros.index') }}" class="admin-ui-btn admin-ui-btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span class="admin-ui-mobile-hide">Voltar</span>
        </a>
    </div>

    <form action="{{ route('parceiros.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="admin-ui-card admin-ui-card-form">
            <h2 class="admin-ui-card-title">Dados do parceiro</h2>

            <div class="admin-ui-grid">
                <div class="admin-ui-field">
                    <label for="inputNome" class="admin-ui-label">Nome</label>
                    <input
                        type="text"
                        name="nome"
                        id="inputNome"
                        class="admin-ui-input @error('nome') is-invalid @enderror"
                        placeholder="Nome do parceiro"
                        value="{{ old('nome') }}"
                        required
                    >
                    @error('nome')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputEmail" class="admin-ui-label">E-mail</label>
                    <input
                        type="email"
                        name="email"
                        id="inputEmail"
                        class="admin-ui-input @error('email') is-invalid @enderror"
                        placeholder="E-mail do parceiro"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputLink" class="admin-ui-label">URL</label>
                    <input
                        type="url"
                        name="link"
                        id="inputLink"
                        class="admin-ui-input @error('link') is-invalid @enderror"
                        placeholder="https://exemplo.com"
                        value="{{ old('link') }}"
                        required
                    >
                    @error('link')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputAlt" class="admin-ui-label">Alt</label>
                    <input
                        type="text"
                        name="alt"
                        id="inputAlt"
                        class="admin-ui-input @error('alt') is-invalid @enderror"
                        placeholder="Descrição da imagem"
                        value="{{ old('alt') }}"
                        required
                    >
                    @error('alt')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputImagem" class="admin-ui-label">Imagem</label>
                    <div class="admin-ui-file-control">
                        <label class="admin-ui-file-button" for="inputImagem" aria-label="Selecionar imagem">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <span class="admin-ui-file-name" data-admin-file-name>Nenhum arquivo selecionado</span>
                        </label>
                        <input type="file" name="imagem" class="admin-ui-file-native @error('imagem') is-invalid @enderror image" id="inputImagem">
                    </div>
                    @error('imagem')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                    <input type="hidden" name="cropped_image" id="cropped_image">
                </div>

                <div class="admin-ui-field" id="croppedImageContainer" style="display: none;">
                    <label for="croppedImagePreview" class="admin-ui-label">Preview da imagem</label>
                    <div id="croppedImagePreview" style="width: 160px; height: 160px; border: 1px solid #ddd; border-radius: 50%; overflow: hidden;">
                        <img id="croppedImage" src="" alt="Imagem recortada" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-ui-actions">
            <a href="{{ route('parceiros.index') }}" class="admin-ui-btn admin-ui-btn-secondary">Cancelar</a>
            <button type="submit" class="admin-ui-btn admin-ui-btn-primary">
                <i class="fa-regular fa-floppy-disk"></i> Salvar
            </button>
        </div>
    </form>
</div>
@endsection
