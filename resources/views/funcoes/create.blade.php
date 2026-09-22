@extends('layouts.admin')

@section('title', 'Nova Função')

@section('breadcrumb')
<x-admin.breadcrumb :items="[
    ['label' => 'Início', 'url' => route('admin')],
    ['label' => 'Funções', 'url' => route('funcoes.index')],
    ['label' => 'Nova função'],
]" />
@endsection

@section('content')
<div class="admin-ui-page">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Nova função</h1>
            <p class="admin-ui-subtitle">Defina um nome e selecione as permissões desta função.</p>
        </div>
        <a href="{{ route('funcoes.index') }}" class="admin-ui-btn admin-ui-btn-secondary" aria-label="Voltar para funções">
            <i class="bi bi-arrow-left" aria-hidden="true"></i>
            <span class="admin-ui-mobile-hide">Voltar</span>
        </a>
    </div>

    <form action="{{ route('funcoes.store') }}" method="POST" id="role-form">
        @csrf
        <div class="admin-ui-card admin-ui-card-form mb-4">
            <h2 class="admin-ui-card-title">Identificação</h2>
            <div class="admin-ui-field">
                <label for="inputNomeCargo" class="admin-ui-label">Nome da função *</label>
                <input type="text" name="name" class="admin-ui-input @error('name') is-invalid @enderror"
                    id="inputNomeCargo" placeholder="Nome da função" value="{{ old('name') }}" required
                    @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
                @error('name')
                    <p class="admin-ui-error" id="name-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <section class="admin-ui-card admin-ui-card-form" aria-labelledby="permissions-title">
            <div class="admin-ui-permission-heading">
                <div>
                    <h2 class="admin-ui-card-title mb-2" id="permissions-title">Permissões</h2>
                    <p class="admin-ui-helper">Selecione as permissões individualmente ou por recurso.</p>
                </div>
                <span class="admin-ui-badge admin-ui-badge-neutral" id="permission-count" role="status" aria-live="polite"></span>
            </div>

            <div class="admin-ui-permission-toolbar">
                <input type="search" id="permission-search" class="admin-ui-search-input" placeholder="Buscar permissão" aria-label="Buscar permissão">
                <button type="button" class="admin-ui-btn admin-ui-btn-secondary" id="select-all-permissions">Selecionar tudo</button>
                <button type="button" class="admin-ui-btn admin-ui-btn-secondary" id="clear-permissions">Limpar seleção</button>
            </div>

            <div class="admin-ui-permission-grid">
                @foreach ($gruposPermissoes as $recurso => $grupo)
                    <section class="admin-ui-permission-group" data-permission-group>
                        <div class="admin-ui-permission-heading">
                            <label class="admin-ui-inline-option">
                                <input type="checkbox" class="admin-ui-check" data-group-toggle aria-label="Selecionar grupo {{ $recurso }}">
                                <strong>{{ $recurso }}</strong>
                            </label>
                            <span class="admin-ui-helper" data-group-count></span>
                        </div>
                        @foreach ($grupo as $permissao)
                            <label class="admin-ui-permission-option" for="permissao-{{ $permissao->id }}" data-permission-option>
                                <input type="checkbox" name="permissao[]" id="permissao-{{ $permissao->id }}" class="admin-ui-check" value="{{ $permissao->name }}"
                                    @checked(in_array($permissao->name, old('permissao', [])))>
                                <span>{{ $permissao->name }}</span>
                            </label>
                        @endforeach
                    </section>
                @endforeach
            </div>
            <p class="admin-ui-helper" id="permissions-empty" @if($permissoes->isNotEmpty()) hidden @endif>Nenhuma permissão encontrada.</p>
        </section>

        <div class="admin-ui-actions">
            <a href="{{ route('funcoes.index') }}" class="admin-ui-btn admin-ui-btn-secondary">Cancelar</a>
            <button type="submit" class="admin-ui-btn admin-ui-btn-primary">
                <i class="fa-regular fa-floppy-disk" aria-hidden="true"></i> Salvar função
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('role-form');
        const permissions = Array.from(form.querySelectorAll('input[name="permissao[]"]'));
        const groups = Array.from(form.querySelectorAll('[data-permission-group]'));
        const updateSelection = () => {
            const selected = permissions.filter(input => input.checked).length;
            document.getElementById('permission-count').textContent = `${selected} / ${permissions.length} selecionadas`;
            groups.forEach(group => {
                const inputs = Array.from(group.querySelectorAll('input[name="permissao[]"]'));
                const count = inputs.filter(input => input.checked).length;
                const toggle = group.querySelector('[data-group-toggle]');
                toggle.checked = count === inputs.length;
                toggle.indeterminate = count > 0 && count < inputs.length;
                group.querySelector('[data-group-count]').textContent = `${count}/${inputs.length}`;
            });
        };
        form.addEventListener('change', event => {
            if (event.target.matches('[data-group-toggle]')) {
                event.target.closest('[data-permission-group]').querySelectorAll('input[name="permissao[]"]').forEach(input => {
                    input.checked = event.target.checked;
                });
            }
            updateSelection();
        });
        document.getElementById('select-all-permissions').addEventListener('click', () => {
            permissions.forEach(input => input.checked = true);
            updateSelection();
        });
        document.getElementById('clear-permissions').addEventListener('click', () => {
            permissions.forEach(input => input.checked = false);
            updateSelection();
        });
        const normalize = value => value.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLocaleLowerCase('pt-BR');
        document.getElementById('permission-search').addEventListener('input', event => {
            const query = normalize(event.target.value.trim());
            groups.forEach(group => {
                const options = Array.from(group.querySelectorAll('[data-permission-option]'));
                options.forEach(option => option.hidden = !normalize(option.textContent).includes(query));
                group.hidden = options.every(option => option.hidden);
            });
            document.getElementById('permissions-empty').hidden = groups.some(group => !group.hidden);
        });
        updateSelection();
    });
</script>
@endsection
