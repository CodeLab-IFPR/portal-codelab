@extends('noticias.layout')

@section('content')
<div class="card mt-5">
    <h1 class="text-center">{{ $noticia->titulo }}</h1>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <br>
                    {!! html_entity_decode($noticia->conteudo) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <label for="Categoria"><strong>Tags relacionadas:</strong></label>
                    <strong class="badge text-bg-primary">{{ $noticia->categoria }}</strong>
                </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-primary btn-sm" href="{{ route('noticias.index') }}"><i
                        class="fa fa-arrow-left"></i> Voltar</a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <small><span><strong>Por</strong> {{$noticia->autor}}</span></small>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <small><strong>Publicado em: </strong>{{ $noticia->created_at->format('d/m/Y H:i') }} <strong>. Atualizado</strong> {{ $noticia->updated_at->diffForHumans() }}</small>
                </div>
            </div>

        </div>
    </div>
    @endsection