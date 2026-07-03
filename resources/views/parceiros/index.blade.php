@extends('layouts.admin')

<!-- Título -->
@section('title')
Parceiros
@endsection
<!-- Título -->

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Parceiros
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="admin-ui-page admin-ui-page-fluid">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Parceiros</h1>
        </div>
        <a class="admin-ui-btn admin-ui-btn-primary" href="{{ route('parceiros.create') }}">
            <i class="fa fa-plus"></i>
            <span class="admin-ui-mobile-hide">Novo parceiro</span>
        </a>
    </div>

    <hr class="admin-ui-divider">

    @if(session('success'))
        <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="alert-content">
                <strong>{{ session('success') }}</strong>
            </div>
            <div class="progress-bar-container">
                <div id="progress-bar" class="progress-bar"></div>
            </div>
        </div>
    @endif

    <div class="admin-ui-searchbar">
        <form id="search-form" class="admin-ui-search-form" method="GET" action="{{ route('parceiros.index') }}">
            <input id="search-input" class="admin-ui-search-input" type="search" name="search" placeholder="Buscar parceiros" aria-label="Buscar parceiros">
            <button class="admin-ui-btn admin-ui-btn-secondary" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <div class="admin-ui-table-card admin-ui-card">
        <div id="parceiros-table-container">
            @include('parceiros.table', ['parceiros' => $parceiros])
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza de que deseja excluir este parceiro? Esta ação não pode ser desfeita.</p>
                <div id="parceiro-info">
                    <p><strong>Nome:</strong> <span id="parceiro-nome"></span></p>
                    <p><strong>Email:</strong> <span id="parceiro-email"></span></p>
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
            var query = $('#search-input').val();
            $.ajax({
                url: "{{ route('parceiros.index') }}",
                type: 'GET',
                data: { search: query },
                success: function (response) {
                    $('#parceiros-table-container').html(response.table);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Ocorreu um erro ao tentar buscar os parceiros.');
                }
            });
        });

        $('body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            var nome = $(this).data('nome');
            var email = $(this).data('email');

            $('#parceiro-nome').text(nome);
            $('#parceiro-email').text(email);

            $('#confirmDeleteButton').data('url', url);
            $('#confirmDeleteModal').modal('show');
        });

        $('#confirmDeleteButton').on('click', function () {
            var url = $(this).data('url');
            $.ajax({
                url: url,
                method: 'DELETE',
                success: function (response) {
                    if (response.table) {
                        $('#parceiros-table-container').html(response.table);
                        $('#confirmDeleteModal').modal('hide');
                    } else {
                        location.reload();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Ocorreu um erro ao tentar excluir o parceiro.');
                }
            });
        });
    });
</script>
@endsection
