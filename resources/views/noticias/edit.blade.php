@extends('noticias.layout')

@section('content')
<div class="card mt-5">
    <h2 class="card-header">Editar Noticia</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('noticias.index') }}"><i
                    class="fa fa-arrow-left"></i> Voltar</a>
        </div>

        <form action="{{ route('noticias.update',$noticia->slug) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="inputTitulo" class="form-label"><strong>Titulo:</strong></label>
                <input type="text" class="form-control" name="titulo" id="inputTitulo" placeholder="Titulo..." value="{{ $noticia->titulo }}">
                @error('titulo')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputConteudo" class="form-label"><strong>Conteudo:</strong></label>
                <textarea class="form-control @error('conteudo') inválida @enderror" style="height:150px"
                    name="conteudo" id="inputConteudo" placeholder="Conteudo...">{{ $noticia->conteudo }}</textarea>
                @error('conteudo')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputAutor" class="form-label"><strong>Autor:</strong></label>
                <input type="text" class="form-control" name="autor" id="inputAutor" placeholder="Autor..." value="{{ $noticia->autor }}">
                @error('autor')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputImagem" class="form-label"><strong>Capa:</strong></label>
                <input type="file" name="imagem" class="form-control @error('imagem') inválida @enderror"
                    id="inputImagem">
                <img src="/imagens/{{ $noticia->imagem }}" width="300px">
                @error('imagem')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputAlt" class="form-label"><strong>Alt:</strong></label>
                <input type="text" class="form-control @error('alt') inválido @enderror" name="alt"
                    value="{{ $noticia->alt }}" id="inputAlt" placeholder="Descreva a capa...">
                @error('subtitulo')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputCategoria" class="form-label"><strong>Categoria:</strong></label>
                <input type="text" name="categoria" value="{{ $noticia->categoria }}"
                    class="form-control @error('categoria') inválida @enderror" id="inputAutor"
                    placeholder="Categoria...">
                @error('categoria')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Atualizar</button>
        </form>

    </div>
</div>
@endsection