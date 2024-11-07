@extends('layouts.admin')

@section('title')
Tarefas
@endsection

@section('content')

@if(isset($projeto))
@if(session('success'))
            <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-content">
                    <strong>{{ session('success') }}</strong>
                </div>
                <div class="progress-bar-container">
                    <div id="progress-bar" class="progress-bar"></div>
                </div>
            </div>
        @endif
    <div class="d-flex justify-content-center">
        <div class="text-center w-75">
            <h4 class="mt-4">Tarefas</h4>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-outline-info btn-sm"
                    href="{{ route('projetos.tarefas.create', $projeto->id) }}">
                    <i class="fa-solid fa-plus"></i> Criar Tarefa
                </a>
                <button class="btn btn-outline-warning btn-sm" id="generateCertificates">
                    <i class="fa-solid fa-certificate"></i> Gerar Certificados
                </button>
            </div>

            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>
                        <th>Selecionar</th>
                        <th>Nome</th>
                        <th>Membro</th>
                        <th>Horas Trabalhadas</th>
                        <th>Status</th>
                        <th width="250px">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tarefas as $tarefa)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input" value="{{ $tarefa->id }}"
                                    {{ $tarefa->certificado_gerado ? 'checked disabled' : '' }}>
                            </td>
                            <td>
                                @if(isset($tarefa->status) && $tarefa->status == 'Concluido')
                                    {{ $tarefa->nome }}
                                @else
                                    <a
                                        href="{{ route('tarefas.atividades.create', ['tarefa' => $tarefa->id]) }}">
                                        {{ $tarefa->nome }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @foreach($projeto->membros as $membro)
                                    @if($membro->id == $tarefa->membro_id)
                                        {{ $membro->nome }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @php
                                    $horasTrabalhadas = $tarefa->atividades->sum('horas_trabalhadas');
                                @endphp
                                {{ $horasTrabalhadas > 0 ? $horasTrabalhadas : 'S/N' }}
                            </td>
                            <td>
                                @if($tarefa->status == 'concluido')
                                    <span class="badge bg-success">{{ $tarefa->status }}</span>
                                @else
                                    <span class="badge bg-warning">{{ $tarefa->status }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('projetos.tarefas.edit', [$projeto->id ,$tarefa->id]) }}">
                                                <i class="fa-solid fa-edit"></i> Editar
                                            </a>
                                        </li>
                                        <li>
                                            <form
                                                action="{{ route('projetos.tarefas.destroy', [$projeto-> id,$tarefa->id]) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item"
                                                    onclick="return confirm('Tem certeza que deseja deletar esta tarefa?')">
                                                    <i class="fa-solid fa-trash"></i> Deletar
                                                </button>
                                            </form>
                                        </li>
                                        @if($tarefa->atividades->count() > 0)
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('tarefas.atividades.index', ['tarefa' => $tarefa->id]) }}">
                                                    <i class="fa-solid fa-eye"></i> Ver Atividades
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Nenhuma tarefa encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@else
    <p>Projeto não encontrado.</p>
@endif
<div class="d-flex justify-content-center">
    {!! $tarefas->links('pagination::bootstrap-5') !!}

</div>

<script>
    document.getElementById('generateCertificates').addEventListener('click', function () {
        let selectedTasks = [];
        let valid = true;

        document.querySelectorAll('input[type="checkbox"]:checked:not(:disabled)').forEach(function (checkbox) {
            let row = checkbox.closest('tr');
            let horasTrabalhadas = row.querySelector('td:nth-child(4)').innerText;

            if (horasTrabalhadas === 'S/N') {
                valid = false;
            } else {
                selectedTasks.push(checkbox.value);
            }
        });

        if (!valid) {
            alert('Não é possível gerar certificados para tarefas não concluídas.');
            return;
        }

        if (selectedTasks.length > 0) {
            fetch('{{ route('certificados.generate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        tasks: selectedTasks
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        data.generatedTaskIds.forEach(function (taskId) {
                            fetch(`/tarefas/${taskId}/update-checkbox`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        checkbox_estado: true
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        let checkbox = document.querySelector(
                                            `input[type="checkbox"][value="${taskId}"]`);
                                        if (checkbox) {
                                            checkbox.checked = true;
                                            checkbox.disabled = true;
                                        }
                                    }
                                });
                        });
                        window.location.href = data.redirect;
                    } else {
                        alert('Erro ao gerar certificados.');
                    }
                });
        } else {
            alert('Selecione pelo menos uma tarefa.');
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        let selectedTasks = JSON.parse(localStorage.getItem('selectedTasks')) || [];
        selectedTasks.forEach(function (taskId) {
            let checkbox = document.querySelector(`input[type="checkbox"][value="${taskId}"]`);
            if (checkbox) {
                checkbox.checked = true;
                checkbox.disabled = true;
            }
        });
    });
</script>
@endsection