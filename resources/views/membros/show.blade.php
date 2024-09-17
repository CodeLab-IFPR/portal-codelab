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
<div class="container">
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nome:</strong> <br />
                    {{ $membro->nome }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Cargo:</strong> <br />
                    {{ $membro->cargo }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Biografia:</strong> <br />
                    {{ $membro->biografia }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <p><strong>LinkedIn:</strong> <a href="{{ $membro->linkedin }}" target="_blank">{{ $membro->linkedin }}</a></p>
            <p><strong>GitHub:</strong> <a href="{{ $membro->github }}" target="_blank">{{ $membro->github }}</a></p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>CPF:</strong> <br />
                    {{ $membro->cpf }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Ativo:</strong> <br />
                    {{ $membro->ativo ? 'Sim' : 'Não' }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Imagem:</strong><br />
                    <img src="/imagens/{{ $membro->imagem }}" alt="{{ $membro->alt }}" width="500px">
                </div>
            </div>
        </div>

    </div>
</div>
@endsection