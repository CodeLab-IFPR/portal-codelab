@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Projetos</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Projetos</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="card-body">
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

        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <a class="btn btn-outline-success btn-sm" href="{{ route('projetos.create') }}"> <i class="fa fa-plus"></i> Novo projeto</a>
        </div>

        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Membros</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projetos as $projeto)
                        <tr>
                            <td>{{ $projeto->nome }}</td>
                            <td>{{ $projeto->descricao ?? 'Sem descrição' }}</td>
                            <td>
                                @foreach($projeto->users as $user)
                                    {{ $user->name }}@if(!$loop->last), @endif
                                @endforeach
                            </td>
                            <td>
                                <span class="badge {{ $projeto->status == 'concluido' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($projeto->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown text-center"></div>
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="{{ route('projetos.tarefas.index', $projeto->id) }}"><i class="fa-solid fa-eye"></i> Ver Tarefas</a></li>
                                        <li><a class="dropdown-item" href="{{ route('projetos.edit', $projeto->id) }}"><i class="fa-solid fa-pen-to-square"></i> Editar</a></li>
                                        <li>
                                            <form action="{{ route('projetos.destroy', $projeto->id) }}" method="POST" class="d-inline">
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Não há projetos 😢</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {!! $projetos->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection