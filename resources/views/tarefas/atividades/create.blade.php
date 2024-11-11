@extends('layouts.admin')

@section('title')
Cadastrar Atividade
@endsection

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card col-md-6">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success" role="alert"> {{ session('success') }} </div>
            @endif

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-outline-info btn-sm" href="{{ route('projetos.tarefas.edit', [$projeto->id, $tarefa->id]) }}">
                    <i class="fa-solid fa-pen-to-square"></i> Editar Tarefa
                </a>
            </div>

            <h4 class="mt-4">Cadastrar Atividade</h4>
            <form action="{{ route('tarefas.atividades.store', $tarefa->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="inputNomeTarefa" class="form-label"><strong>Nome da Tarefa:</strong></label>
                    <input type="text" name="nome_tarefa" class="form-control" id="inputNomeTarefa" value="{{ $tarefa->nome }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="inputDataInicio" class="form-label"><strong>Data de Início:</strong></label>
                    <input type="date" name="data_inicio" class="form-control @error('data_inicio') is-invalid @enderror" id="inputDataInicio">
                    @error('data_inicio')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="inputDataFinal" class="form-label"><strong>Data Final:</strong></label>
                    <input type="date" name="data_final" class="form-control @error('data_final') is-invalid @enderror" id="inputDataFinal">
                    @error('data_final')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="inputHorasTrabalhadas" class="form-label"><strong>Horas Trabalhadas:</strong></label>
                    <input type="number" name="horas_trabalhadas" class="form-control @error('horas_trabalhadas') is-invalid @enderror" id="inputHorasTrabalhadas">
                    @error('horas_trabalhadas')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="inputLink" class="form-label"><strong>Link:</strong></label>
                    <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" id="inputLink">
                    @error('link')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('projetos.tarefas.index', $projeto->id) }}" class="btn btn-outline-danger">Voltar</a>
                    <button type="submit" class="btn btn-outline-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
