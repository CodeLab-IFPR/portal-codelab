@extends('layouts.admin')

@section('title', 'Novo Certificado')

@section('content')
<div class="admin-ui-page admin-ui-page-narrow">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Novo Certificado</h1>
            <p class="admin-ui-subtitle">Emitir um novo certificado.</p>
        </div>
        <a href="{{ route('certificados.index') }}" class="admin-ui-btn admin-ui-btn-secondary" aria-label="Voltar para certificados">
            <i class="bi bi-arrow-left" aria-hidden="true"></i>
            <span class="admin-ui-mobile-hide">Voltar</span>
        </a>
    </div>
    <hr class="admin-ui-divider">

    @php
        $certificadosLote = old('certificados', $certificadosData ?? []);
        $emLote = !empty($certificadosLote);
        $formularios = $emLote ? $certificadosLote : [old('manual_certificado', [])];
    @endphp
    <form method="POST" action="{{ route('certificados.store') }}" novalidate>
        @csrf
        @foreach ($formularios as $index => $data)
            @php
                $prefix = $emLote ? "certificados.$index" : 'manual_certificado';
                $inputName = $emLote ? "certificados[$index]" : 'manual_certificado';
                $inputId = $emLote ? "certificado-$index" : 'manual-certificado';
            @endphp
            <section class="admin-ui-card admin-ui-card-form mb-4" aria-labelledby="{{ $inputId }}-title">
                <h2 class="admin-ui-card-title" id="{{ $inputId }}-title">Dados do certificado @if($emLote) — {{ $loop->iteration }} @endif</h2>
                <div class="admin-ui-grid">
                    <div class="admin-ui-field">
                        <label for="{{ $inputId }}-user" class="admin-ui-label">Membro *</label>
                        <select id="{{ $inputId }}-user" name="{{ $inputName }}[user_id]"
                            class="admin-ui-input @error($prefix.'.user_id') is-invalid @enderror" required
                            @error($prefix.'.user_id') aria-invalid="true" aria-describedby="{{ $inputId }}-user-error" @enderror>
                            <option value="">Selecione um membro</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected((string) $user->id === (string) ($data['user_id'] ?? ''))>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error($prefix.'.user_id')
                            <p class="admin-ui-error" id="{{ $inputId }}-user-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="admin-ui-field">
                        <label for="{{ $inputId }}-horas" class="admin-ui-label">Horas *</label>
                        <input type="number" step="1" class="admin-ui-input @error($prefix.'.horas') is-invalid @enderror"
                            id="{{ $inputId }}-horas" name="{{ $inputName }}[horas]" value="{{ $data['horas'] ?? '' }}" required
                            @error($prefix.'.horas') aria-invalid="true" aria-describedby="{{ $inputId }}-horas-error" @enderror>
                        @error($prefix.'.horas')
                            <p class="admin-ui-error" id="{{ $inputId }}-horas-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="admin-ui-field">
                        <label for="{{ $inputId }}-data" class="admin-ui-label">Data *</label>
                        <input type="date" class="admin-ui-input @error($prefix.'.data') is-invalid @enderror"
                            id="{{ $inputId }}-data" name="{{ $inputName }}[data]" value="{{ $data['data'] ?? '' }}" required
                            @error($prefix.'.data') aria-invalid="true" aria-describedby="{{ $inputId }}-data-error" @enderror>
                        @error($prefix.'.data')
                            <p class="admin-ui-error" id="{{ $inputId }}-data-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="admin-ui-field">
                        <label for="{{ $inputId }}-descricao" class="admin-ui-label">Descrição *</label>
                        <textarea class="admin-ui-textarea @error($prefix.'.descricao') is-invalid @enderror"
                            id="{{ $inputId }}-descricao" name="{{ $inputName }}[descricao]" maxlength="520" required
                            @error($prefix.'.descricao') aria-invalid="true" aria-describedby="{{ $inputId }}-descricao-error" @enderror>{{ $data['descricao'] ?? '' }}</textarea>
                        @error($prefix.'.descricao')
                            <p class="admin-ui-error" id="{{ $inputId }}-descricao-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @if ($emLote && isset($data['servico_id']))
                    <input type="hidden" name="{{ $inputName }}[servico_id]" value="{{ $data['servico_id'] }}">
                @endif
            </section>
        @endforeach
        <div class="admin-ui-actions">
            <a href="{{ route('certificados.index') }}" class="admin-ui-btn admin-ui-btn-secondary">Cancelar</a>
            <button type="submit" class="admin-ui-btn admin-ui-btn-primary">
                <i class="fa fa-plus" aria-hidden="true"></i> {{ $emLote ? 'Criar certificados' : 'Criar certificado' }}
            </button>
        </div>
    </form>
</div>
@endsection
