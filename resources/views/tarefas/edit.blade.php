@extends('layouts.admin')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Editar Tarefa</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('projetos.show', $projeto->id) }}">{{ $projeto->nome }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Tarefa</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="card-body">
        <form action="{{ route('projetos.tarefas.update', [$projeto->id, $tarefa->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="inputNomeTarefa" class="form-label"><strong>Nome da Tarefa:</strong></label>
                <input type="text" name="nome" value="{{ old('nome', $tarefa->nome) }}" class="form-control @error('nome') is-invalid @enderror" id="inputNomeTarefa" placeholder="Nome da Tarefa...">
                @error('nome')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputUser" class="form-label"><strong>User:</strong></label>
                <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" id="inputUser">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $tarefa->user_id == $user->id ? 'selected' : '' }}>{{ $user->nome }}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputStatusTarefa" class="form-label"><strong>Status:</strong></label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="status" id="inputStatusTarefa" {{ $tarefa->status == 'concluido' ? 'checked' : '' }}>
                    <label class="form-check-label" for="inputStatusTarefa">
                        Concluído
                    </label>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <input type="submit" class="btn btn-outline-secondary" value="Salvar">
            </div>
        </form>
    </div>
</div>
@endsection