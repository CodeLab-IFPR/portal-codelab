@extends('layouts.admin')

@section('title')
Criar Tarefa
@endsection

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
                <h3 class="mb-0">Criar Tarefa</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('projetos.show', $projeto->id) }}">{{ $projeto->nome }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Criar Tarefa</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container d-flex justify-content-center">
    <div class="card-body" style="max-width: 600px; width: 100%;">
        <form action="{{ route('tarefas.store', $projeto->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nome" class="form-label"><strong>Nome da Tarefa:</strong></label>
                <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome da Tarefa..." required
                    autocomplete="off">
            </div>

            <div class="mb-3">
                <label for="membro_id" class="form-label"><strong>Membro:</strong></label>
                <select name="membro_id" class="select2 form-select" required autocomplete="off">
                    @foreach($projeto->membros as $membro)
                        <option value="{{ $membro->id }}">
                            {{ $membro->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 d-flex align-items-center justify-content-center">
                <input class="form-check-input me-2" type="checkbox" name="status" id="inputStatusTarefa" value="1">
                <label class="form-check-label" for="inputStatusTarefa">Marcar como concluído</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('projetos.tarefas.index', $projeto->id) }}"
                    class="btn btn-outline-danger">Voltar</a>
                <button type="submit" class="btn btn-outline-success">Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection