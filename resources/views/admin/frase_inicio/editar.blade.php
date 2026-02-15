@extends('layouts.admin')

<!-- Titulo -->
@section('title')
Editar Frases
@endsection
<!-- Titulo -->

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Editar Frases</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container d-flex justify-content-center">
    <div class="card-body" style="max-width: 600px;">
        <form action="{{ route('admin.frase_inicio.atualizar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="frase_inicio" class="form-label"><strong>Frase Tela Inicial*</strong></label>
                <textarea name="frase_inicio" id="frase_inicio" class="form-control @error('frase_inicio') is-invalid @enderror" rows="3" required>{{ old('frase_inicio', $fraseInicio->frase ?? '') }}</textarea>
                @error('frase_inicio')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="frase_sobre" class="form-label"><strong>Frase Sobre Nós*</strong></label>
                <textarea name="frase_sobre" id="frase_sobre" class="form-control @error('frase_sobre') is-invalid @enderror" rows="3" required>{{ old('frase_sobre', $fraseSobre->frase ?? '') }}</textarea>
                @error('frase_sobre')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="titulo_1" class="form-label"><strong>Título 1</strong></label>
                <input type="text" name="titulo_1" id="titulo_1" class="form-control @error('titulo_1') is-invalid @enderror" value="{{ old('titulo_1', $titulo_1->frase ?? '') }}">
                @error('titulo_1')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="titulo_2" class="form-label"><strong>Título 2</strong></label>
                <input type="text" name="titulo_2" id="titulo_2" class="form-control @error('titulo_2') is-invalid @enderror" value="{{ old('titulo_2', $titulo_2->frase ?? '') }}">
                @error('titulo_2')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="titulo_3" class="form-label"><strong>Título 3</strong></label>
                <input type="text" name="titulo_3" id="titulo_3" class="form-control @error('titulo_3') is-invalid @enderror" value="{{ old('titulo_3', $titulo_3->frase ?? '') }}">
                @error('titulo_3')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nome_organizacao" class="form-label"><strong>Nome da Organização*</strong></label>
                <input type="text" name="nome_organizacao" id="nome_organizacao" class="form-control @error('nome_organizacao') is-invalid @enderror" value="{{ old('nome_organizacao', $nomeOrganizacao->frase ?? '') }}" required>
                @error('nome_organizacao')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="endereco" class="form-label"><strong>Endereço*</strong></label>
                <textarea name="endereco" id="endereco" class="form-control @error('endereco') is-invalid @enderror" rows="2" required>{{ old('endereco', $endereco->frase ?? '') }}</textarea>
                @error('endereco')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nos_encontre_online" class="form-label"><strong>Nos Encontre Online (Link):</strong></label>
                <input type="url" name="nos_encontre_online" id="nos_encontre_online" class="form-control @error('nos_encontre_online') is-invalid @enderror" value="{{ old('nos_encontre_online', $nosEncontreOnline->frase ?? '') }}">
                @error('nos_encontre_online')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="icon_logo" class="form-label"><strong>Logo</strong></label>
                <input type="file" name="icon_logo" id="icon_logo" class="form-control @error('icon_logo') is-invalid @enderror" accept="image/*">
                <div class="form-text">jpeg, png ou jpg</div>
                @error('icon_logo')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="fav_icon" class="form-label"><strong>Favicon</strong></label>
                <input type="file" name="fav_icon" id="fav_icon" class="form-control @error('fav_icon') is-invalid @enderror" accept="image/*">
                <div class="form-text">png, jpeg ou jpg</div>
                @error('fav_icon')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
                @if($favIcon && $favIcon->frase)
                    <div class="mt-2">
                        <small>Favicon atual: {{ basename($favIcon->frase) }}</small>
                    </div>
                @endif
            </div>
            
            <div class="mb-3">
                <label for="seo_title" class="form-label"><strong>SEO - Title</strong></label>
                <input type="text" name="seo_title" id="seo_title" class="form-control @error('seo_title') is-invalid @enderror" value="{{ old('seo_title', $seoTitle->frase ?? '') }}">
                @error('seo_title')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="seo_descricao" class="form-label"><strong>SEO - Descrição</strong></label>
                <textarea name="seo_descricao" id="seo_descricao" class="form-control @error('seo_descricao') is-invalid @enderror" rows="3">{{ old('seo_descricao', $seoDescricao->frase ?? '') }}</textarea>
                @error('seo_descricao')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="seo_author" class="form-label"><strong>SEO - Autor</strong></label>
                <input type="text" name="seo_author" id="seo_author" class="form-control @error('seo_author') is-invalid @enderror" value="{{ old('seo_author', $seoAuthor->frase ?? '') }}">
                @error('seo_author')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="seo_keywords" class="form-label"><strong>SEO - Palavras-chave</strong></label>
                <textarea name="seo_keywords" id="seo_keywords" class="form-control @error('seo_keywords') is-invalid @enderror" rows="3">{{ old('seo_keywords', $seoKeywords->frase ?? '') }}</textarea>
                @error('seo_keywords')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection