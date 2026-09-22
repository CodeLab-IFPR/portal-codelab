@extends('layouts.admin')

@section('title', 'Editar Certificado')

@section('content')
<div class="admin-ui-page admin-ui-page-narrow">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Editar Certificado</h1>
        </div>
        <a href="{{ route('certificados.index') }}" class="admin-ui-btn admin-ui-btn-secondary" aria-label="Voltar para certificados">
            <i class="bi bi-arrow-left" aria-hidden="true"></i>
            <span class="admin-ui-mobile-hide">Voltar</span>
        </a>
    </div>
    <hr class="admin-ui-divider">

    <form method="POST" action="{{ route('certificados.update', $certificado->id) }}" novalidate>
        @csrf
        @method('PUT')
        <section class="admin-ui-card admin-ui-card-form mb-4" aria-label="Dados do certificado">
            <div class="admin-ui-grid">
                <div class="admin-ui-field admin-ui-member-field">
                    <label for="editar-certificado-user" id="editar-certificado-user-label" class="admin-ui-label">Membro *</label>
                    <select id="editar-certificado-user" name="user_id"
                        class="admin-ui-input @error('user_id') is-invalid @enderror" required
                        @error('user_id') aria-invalid="true" aria-describedby="editar-certificado-user-error" @enderror>
                        <option value="">Selecione um membro</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected((string) $user->id === (string) (old('user_id', $certificado->user_id)))>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="admin-ui-error" id="editar-certificado-user-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="admin-ui-field">
                    <label for="editar-certificado-horas" class="admin-ui-label">Horas *</label>
                    <input type="number" step="1" class="admin-ui-input @error('horas') is-invalid @enderror"
                        id="editar-certificado-horas" name="horas" value="{{ old('horas', $certificado->horas) }}" required
                        @error('horas') aria-invalid="true" aria-describedby="editar-certificado-horas-error" @enderror>
                    @error('horas')
                        <p class="admin-ui-error" id="editar-certificado-horas-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="admin-ui-field">
                    <label for="editar-certificado-data" class="admin-ui-label">Data *</label>
                    <input type="date" class="admin-ui-input @error('data') is-invalid @enderror"
                        id="editar-certificado-data" name="data" value="{{ old('data', $certificado->data) }}" required
                        @error('data') aria-invalid="true" aria-describedby="editar-certificado-data-error" @enderror>
                    @error('data')
                        <p class="admin-ui-error" id="editar-certificado-data-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="admin-ui-field">
                    <label for="editar-certificado-descricao" class="admin-ui-label">Descrição *</label>
                    <textarea class="admin-ui-textarea @error('descricao') is-invalid @enderror"
                        id="editar-certificado-descricao" name="descricao" maxlength="520" required
                        @error('descricao') aria-invalid="true" aria-describedby="editar-certificado-descricao-error" @enderror>{{ old('descricao', $certificado->descricao) }}</textarea>
                    @error('descricao')
                        <p class="admin-ui-error" id="editar-certificado-descricao-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>
        <div class="admin-ui-actions">
            <a href="{{ route('certificados.index') }}" class="admin-ui-btn admin-ui-btn-secondary">Cancelar</a>
            <button type="submit" class="admin-ui-btn admin-ui-btn-primary">
                <i class="fa-regular fa-floppy-disk" aria-hidden="true"></i> Salvar certificado
            </button>
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!$.fn.select2) return;

        $('.admin-ui-member-field select').each(function () {
            const field = $(this);
            field.select2({
                width: '100%',
                placeholder: 'Selecione um membro',
                minimumResultsForSearch: Infinity,
                dropdownParent: field.closest('.admin-ui-member-field'),
            });

            const selection = field.next('.select2-container').find('.select2-selection');
            selection.attr('aria-labelledby', field.attr('id') + '-label ' + selection.attr('aria-labelledby'));
            selection.attr('aria-required', 'true');
            if (field.attr('aria-invalid')) {
                selection.attr('aria-invalid', field.attr('aria-invalid'));
                selection.attr('aria-describedby', field.attr('aria-describedby'));
            }
        });
    });
</script>
@endsection
