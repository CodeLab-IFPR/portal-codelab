@extends('noticias.layout')

@section('content')
<div class="card mt-5">
    <h2 class="card-header">Cadastro de Noticias</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('noticias.index') }}"><i
                    class="fa fa-arrow-left"></i> Voltar</a>
        </div>

        <form action="{{ route('noticias.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="inputTitulo" class="form-label"><strong>Titulo:</strong></label>
                <input type="text" class="form-control" name="titulo" id="inputTitulo" placeholder="Titulo...">
                @error('titulo')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputConteudo" class="form-label"><strong>Conteudo:</strong></label>
                <textarea class="form-control" style="height: 600px" name="conteudo" id="inputConteudo"
                    placeholder="Conteudo..."></textarea>
                @error('conteudo')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputAutor" class="form-label"><strong>Autor:</strong></label>
                <input type="text" class="form-control" name="autor" id="inputAutor" placeholder="Autor...">
                @error('autor')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputImagem" class="form-label"><strong>Capa:</strong></label>
                <input type="file" name="imagem" class="form-control @error('imagem') inválida @enderror"
                    id="inputImagem">
                @error('imagem')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputAlt" class="form-label"><strong>Alt:</strong></label>
                <input type="text" class="form-control @error('alt') inválido @enderror" name="alt" id="inputAlt"
                    placeholder="Descreva a capa...">
                @error('alt')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputCategoria" class="form-label"><strong>Categoria:</strong></label>
                <input type="text" class="form-control @error('categoria') inválida @enderror" name="categoria"
                    id="inputCategoria" placeholder="Categoria...">
                @error('categoria')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
        </form>

    </div>
</div>
@endsection