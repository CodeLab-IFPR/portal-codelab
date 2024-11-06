@extends('layouts.admin')

@section('title')
Tarefas
@endsection

@section('content')

@if(isset($projeto))
    <div class="d-flex justify-content-center">
        <div class="text-center w-75">
            <h4 class="mt-4">Tarefas</h4>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm"
                    href="{{ route('projetos.tarefas.create', $projeto->id) }}">
                    <i class="fa-solid fa-plus"></i> Criar Tarefa
                </a>
            </div>

            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>
                        <th>Tarefa</th>
                        <th>Membro</th>
                        <th>Status</th>
                        <th width="250px">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projeto->tarefas as $tarefa)
                        <tr>
                            <td>
                                <a
                                    href="{{ route('tarefas.atividades.index', ['tarefa' => $tarefa->id]) }}">
                                    {{ $tarefa->nome }}
                                </a>
                            </td>
                            <td>
                                @foreach($projeto->membros as $membro)
                                    @if($membro->id == $tarefa->membro_id)
                                        {{ $membro->nome }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @if($tarefa->status)
                                    <span class="badge bg-success">Concluído</span>
                                @else
                                    <span class="badge bg-warning">Pendente</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown d-inline"></div>
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-cog"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('projetos.tarefas.edit', [$projeto->id, $tarefa->id]) }}">
                                            <i class="fa-solid fa-edit"></i> Editar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('tarefas.atividades.index', [$projeto->id, $tarefa->id]) }}">
                                            <i class="fa-solid fa-tasks"></i> Atividades
                                        </a>
                                    </li>
                                    <li>
                                        <form
                                            action="{{ route('projetos.tarefas.destroy', [$projeto->id, $tarefa->id]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item"
                                                onclick="return confirm('Tem certeza que deseja deletar esta tarefa?')">
                                                <i class="fa-solid fa-trash"></i> Deletar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
        </div>
        </td>
        <div class="dropdown d-inline"></div>
        </tr>
    @empty
        <tr>
            <td colspan="4">Nenhuma tarefa encontrada.</td>
        </tr>
@endforelse
</tbody>
</table>
</div>
</div>
@else
<p>Projeto não encontrado.</p>
@endif
@endsection
