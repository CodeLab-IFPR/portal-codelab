@extends('layouts.admin')

@section('title')
    Lançamentos
@endsection

@section('content')
<div class="container d-flex justify-content-center">
    <div class="w-75">
        <h1 class="text-center">Lançamentos de Serviços</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('lancamentos.index') }}" class="mb-3">
            <div class="row align-items-start">
                <div class="col-2">
                    <select name="order" class="form-control" style="width: 120px;">
                        <option value="created_at" {{ $order == 'created_at' ? 'selected' : '' }}>Mais Recentes</option>
                        <option value="created_at" {{ $order == 'created_at' && $direction == 'asc' ? 'selected' : '' }}>Mais Antigos</option>
                        <option value="data_inicio" {{ $order == 'data_inicio' ? 'selected' : '' }}>Data Início</option>
                        <option value="data_final" {{ $order == 'data_final' ? 'selected' : '' }}>Data Final</option>
                        <option value="projeto_id" {{ $order == 'projeto_id' ? 'selected' : '' }}>Projeto (A-Z)</option>
                        <option value="servico_id" {{ $order == 'servico_id' ? 'selected' : '' }}>Serviço (A-Z)</option>
                    </select>
                </div>
                <div class="col-2">
                    <select name="direction" class="form-control">
                        <option value="asc" {{ $direction == 'asc' ? 'selected' : '' }}>Ascendente</option>
                        <option value="desc" {{ $direction == 'desc' ? 'selected' : '' }}>Descendente</option>
                    </select>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-outline-primary">Ordenar</button>
                </div>
                <div class="col">
                <a href="{{ route('lancamentos.create') }}" class="btn btn-outline-success mb-3"><i class="fa fa-plus"></i> Novo Lançamento</a>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Projeto</th>
                    <th>Serviço</th>
                    <th>Data Início</th>
                    <th>Data Final</th>
                    <th>Horas Trabalhadas</th>
                    <th>Link</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lancamentos as $lancamento)
                    <tr>
                        <td>{{ $lancamento->projeto->nome }}</td>
                        <td>{{ $lancamento->servico->descricao }}</td>
                        <td>{{ \Carbon\Carbon::parse($lancamento->data_inicio)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($lancamento->data_final)->format('d/m/Y') }}</td>
                        <td>{{ $lancamento->horas_trabalhadas }}</td>
                        <td><a href="{{ $lancamento->link }}" target="_blank">Commit</a></td>
                        <td>
                                <div class="dropdown text-center"></div>
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="{{ route('lancamentos.edit', $lancamento->id) }}"><i class="fa-solid fa-pen-to-square"></i> Editar</a></li>
                                        <li>
                                            <form action="{{ route('lancamentos.destroy', $lancamento->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item"
                                                    onclick="return confirm('Tem certeza que deseja deletar este lançamento?')">
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
                        <td colspan="4" class="text-center">Não há lançamentos 😢</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {!! $lancamentos->withQueryString()->links('pagination::bootstrap-5') !!}
</div>
@endsection