@extends('layouts.admin')

@section('title')
Editar - {{ $projeto->nome }}
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Editar Projeto</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Projeto</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container d-flex justify-content-center">
    <div class="card-body" style="max-width: 600px; width: 100%;">
        <form action="{{ route('projetos.update', $projeto->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="inputNome" class="form-label"><strong>Nome:</strong></label>
                <input type="text" name="nome" value="{{ old('nome', $projeto->nome) }}" class="form-control @error('nome') inválido @enderror" id="inputNome" placeholder="Nome...">
                @error('nome')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputDescricao" class="form-label"><strong>Descrição:</strong></label>
                <textarea name="descricao" class="form-control @error('descricao') inválido @enderror" id="inputDescricao" placeholder="Descrição...">{{ old('descricao', $projeto->descricao) }}</textarea>
                @error('descricao')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputStatus" class="form-label"><strong>Status:</strong></label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="status" id="inputStatus" {{ $projeto->status == 'concluido' ? 'checked' : '' }}>
                    <label class="form-check-label" for="inputStatus"></label>
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
