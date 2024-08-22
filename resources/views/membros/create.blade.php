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
                <h3 class="mb-0">Membro</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Membro
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="card-body">
        <form action="{{ route('membros.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="inputNome" class="form-label"><strong>*Nome:</strong></label>
                <input type="text" name="nome" class="form-control  @error('nome') inválido @enderror" id="inputNome"
                    placeholder="Nome..." required>
                @error('nome')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputCargo" class="form-label"><strong>*Cargo:</strong></label>
                <input type="text" class="form-control @error('cargo') inválido @enderror" name="cargo" id="inputCargo"
                    placeholder="Cargo..." required>
                @error('cargo')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputBiografia" class="form-label"><strong>*Biografia:</strong></label>
                <textarea class="form-control @error('biografia') inválido @enderror" style="height:150px"
                    name="biografia" id="inputBiografia" placeholder="Biografia..." required></textarea>
                @error('biografia')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputImagem" class="form-label"><strong>*Imagem:</strong></label>
                <input type="file" name="imagem" class="form-control @error('imagem') inválido @enderror"
                    id="inputImagem" required>
                @error('imagem')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputAlt" class="form-label"><strong>Alt:</strong></label>
                <input type="text" class="form-control @error('alt') inválido @enderror" name="alt" id="inputAlt"
                    placeholder="Descrição da imagem..." required>
                @error('alt')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <input type="submit" class="btn btn-outline-secondary" value="Salvar">
            </div>
        </form>

    </div>
</div>
@endsection