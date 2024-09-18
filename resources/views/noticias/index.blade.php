@extends('layouts.admin')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Notícias - Lista</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Notícias - Lista
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
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Categoria</th>
                    <th width="183px">Ação</th>
                </tr>
            </thead>

            <tbody>
                @forelse($noticias as $noticia)
                    <tr>
                        <td><img src="/imagens/{{ $noticia->imagem }}" alt="{{ $noticia->alt }}" width="100px"></td>
                        <td>{{ $noticia->titulo }}</td>
                        <td>{{ $noticia->autor }}</td>
                        <td>{{ $noticia->categoria }}</td>
                        <td>
                            <form action="{{ route('noticias.destroy', $noticia->slug) }}" method="POST">
                                <a class="btn btn-info btn-sm" href="{{ route('noticias.show', $noticia->slug) }}"><i class="fa-solid fa-list"></i> View</a>
                                <a class="btn btn-primary btn-sm" href="{{ route('noticias.edit', $noticia->slug) }}"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a class="btn btn-outline-success btn-sm" href="{{ route('noticias.create') }}"> <i class="fa fa-plus"></i> Adicionar notícia</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {!! $noticias->withQueryString()->links('pagination::bootstrap-5') !!}

    </div>
</div>
@endsection