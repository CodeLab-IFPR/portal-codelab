@extends('layouts.admin')

@section('title', 'Certificados')

@section('content')
<div class="admin-ui-page admin-ui-page-fluid">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Certificados</h1>
            <p class="admin-ui-subtitle">Todos os certificados emitidos.</p>
        </div>
        @can('Criar Certificado')
            <a class="admin-ui-btn admin-ui-btn-primary" href="{{ route('certificados.create') }}" aria-label="Novo certificado">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <span class="admin-ui-mobile-hide">Novo certificado</span>
            </a>
        @endcan
    </div>
    <hr class="admin-ui-divider">

    @if(session('success'))
        <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="alert-content"><strong>{{ session('success') }}</strong></div>
            <div class="progress-bar-container"><div id="progress-bar" class="progress-bar"></div></div>
        </div>
    @endif

    <div class="admin-ui-searchbar">
        <form id="search-form" class="admin-ui-search-form" method="GET" action="{{ route('certificados.index') }}">
            <input id="search-input" class="admin-ui-search-input" type="search" name="search"
                placeholder="Buscar certificados" aria-label="Buscar certificados" value="{{ request('search') }}">
            <button class="admin-ui-btn admin-ui-btn-secondary" type="submit" aria-label="Buscar">
                <i class="bi bi-search" aria-hidden="true"></i>
            </button>
        </form>
    </div>
    <div id="certificados-table-container">
        @include('certificados.table', ['certificados' => $certificados])
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza de que deseja excluir este certificado? Esta ação não pode ser desfeita.</p>
                <div id="certificado-info">
                    <p><strong>Nome:</strong> <span id="certificado-nome"></span></p>
                    <p><strong>Descrição:</strong> <span id="certificado-descricao"></span></p>
                    <p><strong>Horas:</strong> <span id="certificado-horas"></span></p>
                    <p><strong>Data:</strong> <span id="certificado-data"></span></p>
                    <p><strong>Token:</strong> <span id="certificado-token"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button type="button" id="confirmDeleteButton" class="btn btn-danger">Excluir</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            var query = $('input[name="search"]').val();
            $.ajax({
                url: "{{ route('certificados.index') }}",
                type: 'GET',
                data: { search: query },
                success: function (response) {
                    $('#certificados-table-container').html(response.table);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Ocorreu um erro ao tentar buscar os certificados.');
                }
            });
        });

        $('body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            var nome = $(this).data('nome');
            var descricao = $(this).data('descricao');
            var horas = $(this).data('horas');
            var data = $(this).data('data');
            var token = $(this).data('token');

            $('#certificado-nome').text(nome);
            $('#certificado-descricao').text(descricao);
            $('#certificado-horas').text(horas);
            $('#certificado-data').text(data);
            $('#certificado-token').text(token);

            $('#confirmDeleteButton').data('url', url);
            $('#confirmDeleteModal').modal('show');
        });

        $('#confirmDeleteButton').on('click', function () {
            var url = $(this).data('url');
            $.ajax({
                url: url,
                method: 'DELETE',
                success: function (response) {
                    $('#certificados-table-container').html(response.table);
                    $('#confirmDeleteModal').modal('hide');
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Ocorreu um erro ao tentar excluir o certificado.');
                }
            });
        });
    });
</script>
@endsection
