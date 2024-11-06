@extends('layouts.admin')

@section('title')
Cadastrar Tarefas
@endsection

@section('content')
<div class="d-flex justify-content-center">
    <h2 class="mt-4">Adicionar Tarefa</h2>
</div>
<hr>
<br>
<div class="d-flex justify-content-center">
    <div class="text-center w-75">
        <form action="{{ route('projetos.tarefas.store', $projeto->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="inputNomeTarefa" class="form-label"><strong>Nome da Tarefa:</strong></label>
                <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                    id="inputNomeTarefa" placeholder="Nome da Tarefa...">
                @error('nome')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="membro_id" class="form-label"><strong>Membro:</strong></label>
                <select name="membro_id" class="select2 form-select" required>
                    @foreach($membros as $membro)
                        <option value="{{ $membro->id }}"
                            {{ $projeto->membros->contains($membro->id) ? 'selected' : '' }}>
                            {{ $membro->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 d-flex align-items-center justify-content-center">
                <input class="form-check-input me-2" type="checkbox" name="status" id="inputStatusTarefa" value="1">
                <label class="form-check-label" for="inputStatusTarefa">Marcar como concluído</label>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-outline-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Selecione um membro',
        });
    });
</script>
@endsection