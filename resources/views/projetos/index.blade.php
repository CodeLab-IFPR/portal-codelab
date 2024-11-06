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
            <div class="alert alert-success" role="alert"> {{ session('success') }} </div>
        @endif

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('projetos.create') }}"> <i class="fa fa-plus"></i> Adicionar um novo projeto</a>
        </div>

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Membros</th>
                    <th>Status</th>
                    <th width="250px">Ação</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projetos as $projeto)
                    <tr>
                        <td>{{ $projeto->nome }}</td>
                        <td>{{ $projeto->descricao ?? 'Sem descrição' }}</td>
                        <td>
                            @foreach($projeto->membros as $membro)
                                {{ $membro->nome }}@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>
                            <span class="badge {{ $projeto->status == 'concluido' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($projeto->status) }}
                            </span>
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('projetos.tarefas.index', $projeto->id) }}"><i class="fa-solid fa-eye"></i> Ver Tarefas</a>
                            <form action="{{ route('projetos.destroy', $projeto->id) }}" method="POST" class="d-inline">
                                <a class="btn btn-info btn-sm" href="{{ route('projetos.edit', $projeto->id) }}"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Não há projetos 😢</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {!! $projetos->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection