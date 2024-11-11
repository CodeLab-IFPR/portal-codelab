@extends('layouts.admin')

@section('title')
Projeto - Criar
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Novo Projeto</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Novo Projeto</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container d-flex justify-content-center">
    <div class="card-body" style="max-width: 600px;">
        <form action="{{ route('projetos.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="inputNome" class="form-label"><strong>Nome:</strong></label>
                <input type="text" name="nome" class="form-control @error('nome') inválido @enderror" id="inputNome"
                    placeholder="Nome...">
                @error('nome')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="Descricao" class="form-label"><strong>Descrição:</strong></label>
                <textarea name="descricao" class="form-control @error('descricao') inválida @enderror"
                    id="inputDescricao" placeholder="Descrição do Projeto..."></textarea>
                @error('nome')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputStatus" class="form-label"><strong>Status:</strong></label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="status" id="inputStatus">
                    <label class="form-check-label" for="inputStatus">
                        Concluído
                    </label>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('projetos.index') }}"
                    class="btn btn-outline-danger">Voltar</a>
                <button type="submit" class="btn btn-outline-success">Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection
