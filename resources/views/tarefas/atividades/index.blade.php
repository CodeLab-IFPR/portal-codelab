@extends('layouts.admin')

@section('title')
{{ $tarefa->nome }}
@endsection

@section('content')

@if(isset($projeto) && isset($tarefa))
    <div class="d-flex justify-content-center">
        <div class="text-center w-75">
            <h2 class="mt-4">Atividades</h2>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-info btn-sm"
                    href="{{ route('projetos.tarefas.edit', [$projeto->id, $tarefa->id]) }}">
                    <i class="fa-solid fa-pen-to-square"></i> Editar Tarefa
                </a>
            </div>

            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>
                        <th>Tarefa</th>
                        <th>Data de Início</th>
                        <th>Data Final</th>
                        <th>Horas Trabalhadas</th>
                        <th>Link</th>
                        <th width="250px">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tarefa->atividades as $atividade)
                        <tr>
                            <td>{{ $tarefa->nome ?? 'Nome não disponível' }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($atividade->data_inicio)->format('d/m/Y') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($atividade->data_final)->format('d/m/Y') }}
                            </td>
                            <td>{{ $atividade->horas_trabalhadas }} Horas.</td>
                            <td><a href="{{ $atividade->link }}" target="_blank">{{ $atividade->link }}</a></td>
                            <td>
                                <div class="dropdown d-inline"></div>
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-gear"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('atividades.edit', $atividade->id) }}">
                                            <i class="fa-solid fa-pen-to-square"></i> Editar
                                        </a>
                                    </li>
                                    <li>
                                        <form
                                            action="{{ route('atividades.destroy', $atividade->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item"
                                                onclick="return confirm('Tem certeza que deseja deletar esta atividade?')">
                                                <i class="fa-solid fa-trash"></i> Excluir
                                            </button>
                                        </form>
                                    </li>
                                </ul>
        </div>
        </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">Nenhuma atividade encontrada.</td>
        </tr>
@endforelse
</tbody>
</table>
</div>
</div>
@else
<p>Projeto ou tarefa não encontrado.</p>
@endif
@endsection