@extends('layouts.admin')

@section('title')
Novo Lançamento de Serviço
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Novo Lançamento</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Novo Lançamento</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container d-flex justify-content-center align-items-center">
    <div class="col-md-6">
        <form action="{{ route('lancamentos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="projeto_id"><strong>Projeto</strong></label>
                <select name="projeto_id" class="form-control" required>
                    @foreach($projetos as $projeto)
                        <option value="{{ $projeto->id }}">{{ $projeto->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="servico_id"><strong>Serviço</strong></label>
                <select name="servico_id" class="form-control" required>
                    @foreach($servicos as $servico)
                        <option value="{{ $servico->id }}">{{ $servico->descricao }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="data_inicio"><strong>Data de Início</strong></label>
                <input type="date" name="data_inicio" class="form-control" placeholder="dd/mm/yyyy" required>
            </div>
            <div class="form-group">
                <label for="data_final"><strong>Data Final</strong></label>
                <input type="date" name="data_final" class="form-control" placeholder="dd/mm/yyyy" required>
            </div>
            <div class="form-group">
                <label for="horas_trabalhadas"><strong>Horas Trabalhadas</strong></label>
                <input type="number" name="horas_trabalhadas" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="link"><strong>Link</strong></label>
                <input type="url" name="link" class="form-control" required>
            </div>
            <div class="form-group mt-4 d-flex justify-content-between">
                <a href="{{ route('lancamentos.index') }}" class="btn btn-outline-danger">Voltar</a>
                <button type="submit" class="btn btn-outline-success">Salvar</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        var linkInput = document.querySelector('input[name="link"]');
        if (!linkInput.value.startsWith('https://github.com/')) {
            event.preventDefault();
            alert('Link não permitido!');
        }
    });

    document.querySelectorAll('input[type="text"][name="data_inicio"], input[type="text"][name="data_fim"]').forEach(function(input) {
        input.addEventListener('input', function() {
            var value = input.value.replace(/\D/g, '');
            if (value.length >= 2) value = value.slice(0, 2) + '/' + value.slice(2);
            if (value.length >= 5) value = value.slice(0, 5) + '/' + value.slice(5);
            input.value = value;
        });
    });
</script>
@endsection