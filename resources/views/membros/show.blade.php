@extends('layouts.admin')

<!-- Titulo -->
@section('title')
{{ $membro->nome }}
@endsection
<!-- Titulo -->

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Membro - Visualização</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Membro - Visualização
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <img src="/imagens/membros/{{ $membro->imagem }}" alt="{{ $membro->alt }}" class="img-fluid rounded me-3" width="80px">
                <h4 class="mb-0">{{ $membro->nome }}</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Nome:</strong>
                        <p>{{ $membro->nome }}</p>
                    </div>
                    <div class="form-group">
                        <strong>Cargo:</strong>
                        <p>{{ $membro->cargo }}</p>
                    </div>
                    <div class="form-group">
                        <strong>Biografia:</strong>
                        <p>{{ $membro->biografia }}</p>
                    </div>
                    <div class="form-group">
                        <strong>LinkedIn:</strong>
                        <p><a href="{{ $membro->linkedin }}" target="_blank">{{ $membro->linkedin }}</a></p>
                    </div>
                    <div class="form-group">
                        <strong>GitHub:</strong>
                        <p><a href="{{ $membro->github }}" target="_blank">{{ $membro->github }}</a></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>CPF:</strong>
                        <p>{{ $membro->cpf }}</p>
                    </div>
                    <div class="form-group">
                        <strong>Ativo:</strong>
                        <p>{{ $membro->ativo ? 'Sim' : 'Não' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection