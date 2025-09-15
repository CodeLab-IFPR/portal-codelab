@extends('layouts.portal')

<!-- Titulo -->
@section('title')
Sobre Nós
@endsection
<!-- Titulo -->

@section('content')
<header class="pt-10">
    <div class="container">
        <div class="text-center col-12 col-sm-9 col-lg-7 col-xl-6 mx-auto position-relative z-index-20">
            <h1 class="display-3 fw-bold mb-3">Sobre Nós</h1>
            @php
                $fraseSobre = \App\Models\FraseInicio::find(2)->frase ?? 'Frase não encontrada';
            @endphp
            <p class="text-muted lead mb-0">{{ $fraseSobre }}</p>
        </div>
    </div>
</header>
<div class="container position-relative z-index-20 py-7">
    <div class="row g-3">
        
<div class="py-8">
    <h2 class="display-5 fw-bold mb-6 text-center">Nossa equipe</h2>

    <h3 class="fw-bold mb-4 text-center">Membros Atuais</h3>
    <div class="row g-6 mb-6">
        @foreach ($users->where('ativo', true) as $user)
            <div class="col-12 col-md-4">
                <div class="shadow-lg hover-lift" style="position:relative; display:flex; flex-direction:column; min-width:0; word-wrap:break-word; background-color:#fff; background-clip:border-box; border-radius:0.25rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075); height:100%;">
                    <div style="flex:1 1 auto; padding:1rem; text-align:center; display:flex; flex-direction:column;">
                        <div style="margin-bottom:1rem;">
                            @if($user->imagem)
                                <img style="width:80px; height:80px; border-radius:50%;" src="{{ asset('imagens/users/' . $user->imagem) }}" alt="{{ $user->alt ?? $user->name }}">
                            @else
                                <img style="width:80px; height:80px; border-radius:50%;" src="{{ asset('imagens/users/default.png') }}" alt="{{ $user->alt ?? $user->name }}">
                            @endif
                        </div>
                        <p style="font-weight:bold; margin-bottom:0.5rem; margin-top:1rem;">{{ $user->name }}</p>
                        <p style="color:#007bff; font-weight:bold; margin-bottom:1rem; font-size:small;">{{ $user->cargo }}</p>
                        <p style="color:#6c757d; margin-bottom:1rem; line-height:1.5; word-wrap:break-word; overflow-wrap:break-word; white-space:normal;">{{ $user->biografia }}</p>
                        <ul style="list-style:none; padding-left:0; display:flex; align-items:center; justify-content:center; margin-top:auto; margin-bottom:0;">
                            @if ($user->linkedin)
                                <li style="margin:0 0.5rem;"><a href="{{ $user->linkedin }}" style="text-decoration:none;" target="_blank"><i class="ri-linkedin-box-fill ri-2x"></i></a></li>
                            @endif
                            @if ($user->github)
                                <li style="margin:0 0.5rem;"><a href="{{ $user->github }}" style="text-decoration:none;" target="_blank"><i class="ri-github-fill ri-2x"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if ($users->where('ativo', false)->count() > 0)
        <h3 class="fw-bold mb-4 text-center">Membros Anteriores</h3>
        <div class="row g-6 mb-6">
            @foreach ($users->where('ativo', false) as $user)
            <div class="col-12 col-md-4">
                <div class="shadow-lg hover-lift" style="position:relative; display:flex; flex-direction:column; min-width:0; word-wrap:break-word; background-color:#fff; background-clip:border-box; border-radius:0.25rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075); height:100%;">
                    <div style="flex:1 1 auto; padding:1rem; text-align:center; display:flex; flex-direction:column;">
                        <div style="margin-bottom:1rem;">
                            <img style="width:80px; height:80px; border-radius:50%;" src="{{ asset('imagens/users/' . $user->imagem) }}" alt="{{ $user->alt ?? $user->name }}">
                        </div>
                        <p style="font-weight:bold; margin-bottom:0.5rem; margin-top:1rem;">{{ $user->name }}</p>
                        <p style="color:#007bff; font-weight:bold; margin-bottom:1rem; font-size:small;">{{ $user->cargo }}</p>
                        <p style="color:#6c757d; margin-bottom:1rem; line-height:1.5; word-wrap:break-word; overflow-wrap:break-word; white-space:normal;">{{ $user->biografia }}</p>
                        <ul style="list-style:none; padding-left:0; display:flex; align-items:center; justify-content:center; margin-top:auto; margin-bottom:0;">
                            @if ($user->linkedin)
                                <li style="margin:0 0.5rem;"><a href="{{ $user->linkedin }}" style="text-decoration:none;" target="_blank"><i class="ri-linkedin-box-fill ri-2x"></i></a></li>
                            @endif
                            @if ($user->github)
                                <li style="margin:0 0.5rem;"><a href="{{ $user->github }}" style="text-decoration:none;" target="_blank"><i class="ri-github-fill ri-2x"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    @endif

    <div class="d-flex justify-content-center my-5">
        <div class="rounded-pill border px-5 py-3 text-muted d-flex align-items-center">
            Quer se juntar ao nosso time? <a href="{{ route('submission') }}" class="fw-bold d-flex align-items-center ms-2">Estamos esperando <i
                    class="ri-arrow-right-line ms-1"></i></a>
        </div>
    </div>
</div>
@endsection
