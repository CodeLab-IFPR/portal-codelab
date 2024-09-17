@extends('layouts.admin')

@section('content')
<div class="card mt-5">
    <h2 class="card-header">Parceiros</h2>
    <div class="card-body">

        @session('success')
            <div class="alert alert-success" role="alert"> {{ $value }} </div>
        @endsession

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('parceiros.create') }}"> <i
                    class="fa fa-plus"></i> Adicionar um novo parceiro</a>
        </div>

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th width="250px">Ação</th>
                </tr>
            </thead>

            <tbody>
                @forelse($parceiros as $parceiro)
                    <tr>
                        
                        <td><a href="{{$parceiro->link}}"><img src="/imagens/{{ $parceiro->imagem }}" alt="{{ $parceiro->alt }}" width="100px"></a></td>
                        <td>{{ $parceiro->nome }}</td>
                        <td>{{ $parceiro->email }}</td>
                        <td>
                            <form action="{{ route('parceiros.destroy',$parceiro->id) }}"
                                method="POST">

                                <a class="btn btn-info btn-sm"
                                    href="{{ route('parceiros.show',$parceiro->id) }}"><i
                                        class="fa-solid fa-list"></i> View</a>

                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('parceiros.edit',$parceiro->id) }}"><i
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
                        <td colspan="5" class="text-center">Não há parceiros 😢</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        {!! $parceiros->withQueryString()->links('pagination::bootstrap-5') !!}

    </div>
</div>
@endsection