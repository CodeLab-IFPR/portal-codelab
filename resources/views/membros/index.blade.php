@extends('layouts.admin')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Membro - Lista</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Membro - Lista
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="card-body">

        @session('success')
            <div class="alert alert-success" role="alert"> {{ $value }} </div>
        @endsession

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Ativo</th>
                    <th>Cargo</th>
                    <th>Biografia</th>
                    <th>Links</th>
                    <th width="183px">Ação</th>
                </tr>
            </thead>

            <tbody>
                @forelse($membros as $membro)
                    <tr>

                        <td><img src="/imagens/{{ $membro->imagem }}" alt="{{ $membro->alt }}" width="100px"></td>
                        <td>{{ $membro->nome }}</td>
                        <td>{{ $membro->ativo ? 'Sim' : 'Não' }}</td>
                        <td>{{ $membro->cargo }}</td>
                        <td>{{ mb_strimwidth("$membro->biografia", 0, 250, "...") }}
                        </td>
                        <td>
                        <a href="{{ $membro->linkedin }}" target="_blank">LinkedIn</a>
                        <a href="{{ $membro->github }}" target="_blank">GitHub</a>
                        </td>
                        <td>
                            <form action="{{ route('membros.destroy',$membro->id) }}"
                                method="POST">

                                <a class="btn btn-info btn-sm"
                                    href="{{ route('membros.show',$membro->id) }}"><i
                                        class="fa-solid fa-list"></i> View</a>

                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('membros.edit',$membro->id) }}"><i
                                        class="fa-solid fa-pen-to-square"></i> Editar</a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>
                                    Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a class="btn btn-outline-success btn-sm"
                                    href="{{ route('membros.create') }}"> <i class="fa fa-plus"></i>
                                    Adicionar membro</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        {!! $membros->withQueryString()->links('pagination::bootstrap-5') !!}

    </div>
</div>
@endsection
