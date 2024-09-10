@extends('parceiros.layout')

@section('content')
<div class="card mt-5">
    <h2 class="card-header">Parceiro - {{ $parceiro->nome }}</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('parceiros.index') }}"><i
                    class="fa fa-arrow-left"></i> Voltar</a>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nome:</strong> <br />
                    {{ $parceiro->nome }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>E-mail:</strong> <br />
                    {{ $parceiro->email }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>URL:</strong> <br />
                    {{ $parceiro->link }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Imagem:</strong><br />
                    <img src="/imagens/{{ $parceiro->imagem }}" alt="{{ $parceiro->alt }}" width="500px">
                </div>
            </div>
        </div>

    </div>
</div>
@endsection