@extends('layouts.admin')

@section('title')
Parceiro - Edição
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Parceiro - Edição</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end"></ol>
            </div>
        </div>
    </div>
</div>

<div class="admin-ui-page admin-ui-page-narrow">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Editar Parceiro</h1>
        </div>
        <a href="{{ route('parceiros.index') }}" class="admin-ui-btn admin-ui-btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span class="admin-ui-mobile-hide">Voltar</span>
        </a>
    </div>

    <form action="{{ route('parceiros.update',$parceiro->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="admin-ui-card admin-ui-card-form">
            <h2 class="admin-ui-card-title">Dados do parceiro</h2>

            <div class="admin-ui-grid">
                <div class="admin-ui-field">
                    <label for="inputNome" class="admin-ui-label">Nome</label>
                    <input type="text" name="nome" value="{{ $parceiro->nome }}"
                        class="admin-ui-input @error('nome') is-invalid @enderror" id="inputNome" placeholder="Nome do parceiro">
                    @error('nome')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputEmail" class="admin-ui-label">E-mail</label>
                    <input type="email" name="email" value="{{ $parceiro->email }}"
                        class="admin-ui-input @error('email') is-invalid @enderror" id="inputEmail" placeholder="E-mail do parceiro">
                    @error('email')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputLink" class="admin-ui-label">URL</label>
                    <input type="url" name="link" value="{{ $parceiro->link }}"
                        class="admin-ui-input @error('link') is-invalid @enderror" id="inputLink" placeholder="https://exemplo.com">
                    @error('link')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputAlt" class="admin-ui-label">Alt</label>
                    <input type="text" name="alt" value="{{ $parceiro->alt }}"
                        class="admin-ui-input @error('alt') is-invalid @enderror" id="inputAlt"
                        placeholder="Descrição da imagem">
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
                    @if($parceiro->imagem)
                        <p class="admin-ui-file-current">Imagem atual</p>
                        <div class="admin-ui-avatar-lg">
                            <img src="/imagens/parceiros/{{ $parceiro->imagem }}" alt="{{ $parceiro->alt }}">
                        </div>
                    @endif
                    @error('imagem')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                    <div id="newImagePreview" class="mt-2"></div>
                </div>
            </div>
        </div>

        <div class="admin-ui-actions">
            <a href="{{ route('parceiros.index') }}" class="admin-ui-btn admin-ui-btn-secondary">Cancelar</a>
            <button type="submit" class="admin-ui-btn admin-ui-btn-primary">
                <i class="fa-regular fa-floppy-disk"></i> Atualizar
            </button>
        </div>
    </form>
</div>
@endsection
