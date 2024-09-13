@extends('layouts.portal')

<!-- Titulo -->
@section('title')
Noticias
@endsection
<!-- Titulo -->

@section('content')
<div class="container">   
    <div class="card mt-5">
        <h2 class="card-header text-center">Notícias</h2>
        <div class="card-body">
            
            @session('success')
            <div class="alert alert-success" role="alert"> {{ $value }} </div>
            @endsession
            @forelse($noticias as $noticia)
            <div class="col-12 col-sm-6 col-lg-4">
                <div
                class="d-flex h-100 bg-white rounded card overflow-hidden shadow-lg position-relative hover-lift">
                <picture>
                    <img class="img-fluid"
                    src="{{ asset('imagens/' . $noticia->imagem) }}"
                    alt="{{ $noticia->alt }}">
                </picture>
                
                <div class="card-body p-4 p-lg-5">
                    <p class="card-title fw-medium mb-4">{{ $noticia->titulo }}</p>
                    <a href="{{ route('noticias.show', $noticia->slug) }}"
                    class="fw-medium fs-7 text-decoration-none link-cover">Leia mais &rarr;</a>
                </div>
            </div>
        </div>
        @empty
        <div>
            <h2>Não há noticias</h2>
        </div>
        @endforelse
        {!! $noticias->withQueryString()->links('pagination::bootstrap-5') !!}
        
    </div>
</div>
</div>
@endsection