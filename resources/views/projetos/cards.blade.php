
@extends('layouts.portal')

@section('title')
    Projetos
@endsection

@section('content')
<div id="projetos">
    <div class="container">
        <h4 class="fs-1 fw-bold mb-6 text-black text-center">Projetos
        </h4>

        <div class="row g-5">
            @foreach($projetos as $projeto)
            <div class="col-12 col-sm-6 col-lg-4">
                <a href="{{ route('projetos.show', ['projeto' => $projeto->id]) }}" class="text-decoration-none">
                    <div class="d-flex h-100 bg-white rounded-4 card overflow-hidden shadow-lg position-relative hover-lift">
                        <div class="card-body p-4 p-lg-5">
                            <p class="card-title fw-medium mb-4">{{ $projeto->nome }}</p>
                            <p class="fw-medium fs-7 text-decoration-none link-cover">{{ $projeto->status }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            <nav>
                <ul class="pagination">
                    {{ $projetos->links('pagination::bootstrap-4') }}
                </ul>
            </nav>
    </div>
</div>
@endsection