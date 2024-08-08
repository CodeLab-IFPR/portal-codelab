@extends('noticias.layout')

@section('content')
<div class="card mt-5">
    <h2 class="card-header">Noticias</h2>
    <div class="card-body">

        @session('success')
            <div class="alert alert-success" role="alert"> {{ $value }} </div>
        @endsession

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('noticias.create') }}"> <i
                    class="fa fa-plus"></i> Adicionar Noticia</a>
        </div>

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Conteudo</th>
                    <th>Autor</th>
                    <th>Categoria</th>
                    <th>Capa</th>
                    <th width="250px">Ação</th>
                </tr>
            </thead>

            <tbody>
                @forelse($noticias as $noticia)
                    <tr>
                        <td>{{$noticia->titulo}}</td>
                        <td>{{ Str::limit(html_entity_decode(strip_tags($noticia->conteudo)), 500) }}</td>
                        <td>{{ $noticia->autor }}</td>
                        <td>{{ $noticia->categoria }}</td>
                        <td><img src="/imagens/{{ $noticia->imagem }}" alt="{{ $noticia->alt }}" width="100px"></td>
                        <td>
                            <form action="{{ route('noticias.destroy',$noticia->slug) }}"
                                method="POST">

                                <a class="btn btn-info btn-sm"
                                    href="{{ route('noticias.show', $noticia->slug) }}"><i
                                        class="fa-solid fa-list"></i> View</a>

                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('noticias.edit', $noticia->slug) }}"><i
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
                        <td colspan="5" class="text-center">Não há noticias 😢</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        {!! $noticias->withQueryString()->links('pagination::bootstrap-5') !!}

    </div>
</div>
@endsection