@extends('layouts.admin')

@section('title')
Nova Mídia
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('galeria.indexAdmin') }}">Galeria</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nova mídia</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="admin-ui-page admin-ui-page-narrow">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Nova mídia</h1>
        </div>
        <a href="{{ route('galeria.indexAdmin') }}" class="admin-ui-btn admin-ui-btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span class="admin-ui-mobile-hide">Voltar</span>
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif

    <form action="{{ route('galeria.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="admin-ui-card admin-ui-card-form">
            <h2 class="admin-ui-card-title">Dados da mídia</h2>

            <div class="admin-ui-grid">
                <div class="admin-ui-field">
                    <label for="tipo" class="admin-ui-label">Tipo*</label>
                    <select class="admin-ui-input @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                        <option value="" disabled {{ old('tipo') ? '' : 'selected' }}>Selecione o tipo</option>
                        <option value="imagem" {{ old('tipo') === 'imagem' ? 'selected' : '' }}>Imagem</option>
                        <option value="video" {{ old('tipo') === 'video' ? 'selected' : '' }}>Vídeo do YouTube</option>
                    </select>
                    @error('tipo')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div id="file-input" class="admin-ui-field d-none">
                    <label for="file" class="admin-ui-label">Selecionar mídia</label>
                    <div class="admin-ui-file-control">
                        <label class="admin-ui-file-button" for="file" aria-label="Selecionar mídia">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <span class="admin-ui-file-name" data-admin-file-name>Nenhum arquivo selecionado</span>
                        </label>
                        <input type="file" class="admin-ui-file-native @error('file') is-invalid @enderror" id="file" name="file" accept="image/*">
                    </div>
                    @error('file')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div id="link-input" class="admin-ui-field d-none">
                    <label for="link" class="admin-ui-label">Link do YouTube*</label>
                    <input type="url" class="admin-ui-input @error('link') is-invalid @enderror"
                        id="link" name="link" value="{{ old('link') }}" placeholder="https://www.youtube.com/watch?v=...">
                    @error('link')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="titulo" class="admin-ui-label">Título*</label>
                    <input type="text" class="admin-ui-input @error('titulo') is-invalid @enderror"
                        id="titulo" name="titulo" value="{{ old('titulo') }}" placeholder="Título da mídia" required>
                    @error('titulo')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="descricao" class="admin-ui-label">Descrição</label>
                    <textarea class="admin-ui-textarea @error('descricao') is-invalid @enderror"
                        id="descricao" name="descricao" rows="3" placeholder="Descrição da mídia">{{ old('descricao') }}</textarea>
                    @error('descricao')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="admin-ui-actions">
            <a href="{{ route('galeria.indexAdmin') }}" class="admin-ui-btn admin-ui-btn-secondary">Cancelar</a>
            <button type="submit" class="admin-ui-btn admin-ui-btn-primary">
                <i class="fa-regular fa-floppy-disk"></i> Salvar
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeInput = document.getElementById('tipo');
        const fileGroup = document.getElementById('file-input');
        const linkGroup = document.getElementById('link-input');
        const fileInput = document.getElementById('file');
        const linkInput = document.getElementById('link');

        const syncMediaFields = function () {
            const isImage = typeInput.value === 'imagem';
            const isVideo = typeInput.value === 'video';

            fileGroup.classList.toggle('d-none', !isImage);
            linkGroup.classList.toggle('d-none', !isVideo);
            fileInput.required = isImage;
            linkInput.required = isVideo;
        };

        typeInput.addEventListener('change', syncMediaFields);
        syncMediaFields();
    });
</script>
@endsection
