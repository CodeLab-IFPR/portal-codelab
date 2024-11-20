@extends('layouts.admin')

@section('title')
Cargos
@endsection

@php
    use Illuminate\Support\Facades\Auth;

    $podeEditarFuncao = Auth::user()->can('Editar Função');
    $podeDeletarFuncao = Auth::user()->can('Deletar Função');
@endphp

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Cargos</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cargos</li>
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
            <a class="btn btn-outline-success btn-sm" href="{{ route('roles.create') }}"> <i class="fa fa-plus"></i> Novo Cargo</a>
        </div>
        <br>
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Permissões</th>
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->permissions->isNotEmpty() ? $role->permissions->pluck('name')->implode(', ') : 'Sem permissões' }}</td>
                            <td>{{ $role->created_at->format('d M Y \à\s H:i:s') }}</td>
                            <td>{{ $role->updated_at->eq($role->created_at) ? 'Sem atualização' : $role->updated_at->format('d M Y \à\s H:i:s') }}</td>
                            <td>
                                <div class="dropdown text-center">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $role->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $role->id }}">
                                        <li><a class="{{ !$podeEditarFuncao ? 'disabled' : '' }} dropdown-item" href="{{ route('roles.edit', $role->id) }}"><i class="fas fa-pen-to-square"></i> Editar</a></li>
                                        <li>
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="{{ !$podeDeletarFuncao ? 'disabled' : '' }} dropdown-item danger" onclick="return confirm('Tem certeza que deseja deletar este cargo?')">
                                                    <i class="fas fa-trash"></i> Deletar
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Não há cargos 😢</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {!! $roles->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div>
@endsection