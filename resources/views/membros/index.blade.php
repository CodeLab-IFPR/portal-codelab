@extends('membros.layout')

@section('content')
<div class="card mt-5">
    <h2 class="card-header">Membros</h2>
    <div class="card-body">

        @session('success')
            <div class="alert alert-success" role="alert"> {{ $value }} </div>
        @endsession

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('membros.create') }}"> <i
                    class="fa fa-plus"></i> Adicionar um novo membro</a>
        </div>

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Biografia</th>
                    <th width="250px">Ação</th>
                </tr>
            </thead>

            <tbody>
                @forelse($membros as $membro)
                    <tr>
                        
                        <td><img src="/imagens/{{ $membro->imagem }}" alt="{{ $membro->alt }}" width="100px"></td>
                        <td>{{ $membro->nome }}</td>
                        <td>{{ $membro->cargo }}</td>
                        <td>{{ mb_strimwidth("$membro->biografia", 0, 250, "...");}}</td>
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
                        <td colspan="5" class="text-center">Não há membros.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        {!! $membros->withQueryString()->links('pagination::bootstrap-5') !!}

    </div>
</div>
@endsection