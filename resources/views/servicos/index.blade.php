@extends('layouts.admin')

@section('title')
Serviços
@endsection

@php
    use Illuminate\Support\Facades\Auth;

    $podeEditarServico = Auth::user()->can('Editar Serviço');
    $podeDeletarServico = Auth::user()->can('Deletar Serviço');
@endphp

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Serviços</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Serviços</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container d-flex justify-content-center">
    <div class="w-75">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <a class="btn btn-outline-success btn-sm" href="{{ route('servicos.create') }}"> <i class="fa fa-plus"></i> Novo serviço</a>
        </div>
        <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-4">Descrição</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicos as $servico)
                        <tr>
                            <td>{{ $servico->descricao ?? 'Sem descrição' }}</td>
                            <td>
                                <div class="dropdown text-center"></div>
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="{{ !$podeEditarServico ? 'disabled' : '' }} dropdown-item" href="{{ route('servicos.edit', $servico->id) }}"><i class="fa-solid fa-pen-to-square"></i> Editar</a></li>
                                        <li>
                                            <form action="{{ route('servicos.destroy', $servico->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="{{ !$podeDeletarServico ? 'disabled' : '' }} dropdown-item"
                                                    onclick="return confirm('Tem certeza que deseja deletar este serviço?')">
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
                            <td colspan="4" class="text-center">Não há serviços 😢</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {!! $servicos->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection