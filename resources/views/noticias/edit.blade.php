@extends('layouts.admin')

@section('title')
Editar Notícia
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Editar Notícia</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('noticias.index') }}">Notícias</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="admin-ui-page admin-ui-page-narrow">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Editar Notícia</h1>
        </div>
        <a href="{{ route('noticias.index') }}" class="admin-ui-btn admin-ui-btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span class="admin-ui-mobile-hide">Voltar</span>
        </a>
    </div>

    <form action="{{ route('noticias.update', $noticia->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="admin-ui-card admin-ui-card-form">
            <h2 class="admin-ui-card-title">Dados da notícia</h2>

            <div class="admin-ui-grid admin-ui-grid-2">
                <div class="admin-ui-field" style="grid-column: 1 / -1;">
                    <label for="inputTitulo" class="admin-ui-label">Título</label>
                    <input type="text" class="admin-ui-input @error('titulo') is-invalid @enderror" name="titulo"
                        id="inputTitulo" placeholder="Título..." value="{{ old('titulo', $noticia->titulo) }}">
                    @error('titulo')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field" style="grid-column: 1 / -1;">
                    <label for="inputConteudo" class="admin-ui-label">Conteúdo</label>
                    <textarea class="admin-ui-textarea @error('conteudo') is-invalid @enderror"
                        style="min-height: 600px;" name="conteudo" id="inputConteudo"
                        placeholder="Conteúdo...">{{ old('conteudo', $noticia->conteudo) }}</textarea>
                    @error('conteudo')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputAutor" class="admin-ui-label">Autor</label>
                    <input type="text" class="admin-ui-input @error('autor') is-invalid @enderror" name="autor"
                        id="inputAutor" placeholder="Autor..." value="{{ old('autor', $noticia->autor) }}">
                    @error('autor')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputCategoria" class="admin-ui-label">Categoria</label>
                    <input type="text" class="admin-ui-input @error('categoria') is-invalid @enderror" name="categoria"
                        id="inputCategoria" placeholder="Categoria..." value="{{ old('categoria', $noticia->categoria) }}">
                    @error('categoria')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputAlt" class="admin-ui-label">Alt</label>
                    <input type="text" class="admin-ui-input @error('alt') is-invalid @enderror" name="alt"
                        id="inputAlt" placeholder="Descreva a capa..." value="{{ old('alt', $noticia->alt) }}">
                    @error('alt')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputImagem" class="admin-ui-label">Capa</label>
                    <div class="admin-ui-file-control">
                        <label class="admin-ui-file-button" for="inputImagem" aria-label="Selecionar imagem">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <span class="admin-ui-file-name" data-admin-file-name>Nenhum arquivo selecionado</span>
                        </label>
                        <input type="file" name="imagem" class="admin-ui-file-native @error('imagem') is-invalid @enderror"
                            id="inputImagem">
                    </div>
                    @if($noticia->imagem)
                        <p class="admin-ui-file-current">Imagem atual</p>
                        <div class="admin-ui-avatar-lg">
                            <img src="/imagens/noticias/{{ $noticia->imagem }}" alt="{{ $noticia->alt ?? $noticia->titulo }}">
                        </div>
                    @endif
                    @error('imagem')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="admin-ui-actions">
            <a href="{{ route('noticias.index') }}" class="admin-ui-btn admin-ui-btn-secondary">Cancelar</a>
            <button type="submit" class="admin-ui-btn admin-ui-btn-primary">
                <i class="fa-regular fa-floppy-disk"></i> Atualizar
            </button>
        </div>
    </form>
</div>
@endsection
