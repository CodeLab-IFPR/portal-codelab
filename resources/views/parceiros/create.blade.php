@extends('layouts.admin')

<!-- Titulo -->
@section('title')
Parceiros
@endsection
<!-- Titulo -->

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Parceiro</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Parceiro
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container d-flex justify-content-center">
    <div class="card-body" style="max-width: 600px;">
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

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <input type="submit" class="btn btn-outline-secondary" value="Salvar">
            </div>
        </form>
    </div>
</div>
@endsection