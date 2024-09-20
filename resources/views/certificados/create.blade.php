@extends('layouts.admin')

<!-- Titulo -->
@section('title')
Certicados
@endsection
<!-- Titulo -->

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Certificado - Cadastro</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                    Certificado - Cadastro
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container d-flex justify-content-center">
    <div class="card-body" style="max-width: 600px;">
        <form method="POST" action="{{ route('certificados.store') }}">
            @csrf

            <div class="mb-3">
                <label for="membros_id" class="form-label"><strong>Membro*</strong></label>
                <select id="membros_id" name="membros_id" class="form-select" required>
                    <option value="" disabled selected class="text-disable">Selecione</option>
                    @foreach($membros as $membro)
                        <option value="{{ $membro->id }}"> {{ $membro->nome }} </option>
                    @endforeach
                </select>

                @error('nome')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label"><strong>Descrição</strong></label>
                <textarea class="form-control @error('descricao') inválido @enderror" id="descricao" name="descricao"
                    required placeholder="Descrição..." minlength="20" maxlength="520" rows="4"
                    oninput="updateCharacterCount()">{{ old('descricao') }}</textarea>
                <div id="charCount">0/520</div>
                @error('descricao')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="horas" class="form-label"><strong>Horas:*</strong></label>
                <input type="text" class="form-control @error('horas') inválido @enderror" id="horas" name="horas"
                    placeholder="Horas..." value="{{ old('horas') }}" required>
                @error('horas')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="data" class="form-label"><strong>Data Certificado:*</strong></label>
                <input type="date" id="data" name="data" class="form-control @error('data') inválida @enderror"
                  value="{{ old('data') }}"  required>
                @error('data')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-outline-success">
                    <i class="fas fa-plus"></i> Criar Certificado
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
