@extends('parceiros.layout')

@section('content')
<div class="card mt-5">
    <h2 class="card-header">Cadastro de Parceiros</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('parceiros.index') }}"><i
                    class="fa fa-arrow-left"></i> Voltar</a>
        </div>

        <form action="{{ route('parceiros.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="inputNome" class="form-label"><strong>Nome:</strong></label>
                <input type="text" name="nome" class="form-control @error('nome') inválido @enderror" id="inputName"
                    placeholder="Nome...">
                @error('nome')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputEmail" class="form-label"><strong>E-mail:</strong></label>
                <input type="email" class="form-control @error('email') inválido @enderror" name="email" id="inputEmail"
                    placeholder="E-mail...">
                @error('email')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputLink" class="form-label"><strong>URL:</strong></label>
                <input type="url" class="form-control @error('link') inválido @enderror" name="link" id="inputLink"
                    placeholder="URL...">
                @error('link')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputImagem" class="form-label"><strong>Imagem:</strong></label>
                <input type="file" name="imagem" class="form-control @error('imagem') inválida @enderror"
                    id="inputImagem">
                @error('imagem')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputAlt" class="form-label"><strong>Alt:</strong></label>
                <input type="text" class="form-control @error('alt') inválida @enderror" name="alt" id="inputAlt"
                    placeholder="Descrição da imagem...">
                @error('Alt')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
        </form>

    </div>
</div>
@endsection