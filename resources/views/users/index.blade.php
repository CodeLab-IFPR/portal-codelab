@extends('layouts.admin')

@section('title')
Membros
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Membros</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="admin-ui-page admin-ui-page-fluid">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Membros</h1>
        </div>
        <a class="admin-ui-btn admin-ui-btn-primary" href="{{ route('users.create') }}">
            <i class="fa fa-plus"></i>
            <span class="admin-ui-mobile-hide">Novo membro</span>
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
        <form id="search-form" class="admin-ui-search-form" method="GET" action="{{ route('users.index') }}">
            <input id="search-input" class="admin-ui-search-input" type="search" name="search" placeholder="Buscar membros" aria-label="Buscar membros">
            <button class="admin-ui-btn admin-ui-btn-secondary" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <div class="admin-ui-table-card admin-ui-card">
        <div id="users-table-container">
            @include('users.table', ['users' => $users])
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
                <p>Tem certeza de que deseja excluir este user? Esta ação não pode ser desfeita.</p>
                <div id="user-info">
                    <img id="user-imagem" src="" alt="Imagem do User" width="100px">
                    <p><strong>Name:</strong> <span id="user-name"></span></p>
                    <p><strong>Cpf:</strong> <span id="user-cpf"></span></p>
                    <p><strong>Cargo:</strong> <span id="user-cargo"></span></p>
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
                url: "{{ route('users.index') }}",
                type: 'GET',
                data: { search: query },
                success: function (response) {
                    $('#users-table-container').html(response.table);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Ocorreu um erro ao tentar buscar os membros.');
                }
            });
        });

        $('body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            var name = $(this).data('name');
            var cpf = $(this).data('cpf');
            var cargo = $(this).data('cargo');
            var imagem = $(this).data('imagem');
            var alt = $(this).data('alt');

            $('#user-name').text(name);
            $('#user-cpf').text(cpf);
            $('#user-cargo').text(cargo);
            $('#user-imagem').attr('src', imagem);
            $('#user-imagem').attr('alt', alt);

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
                        $('#users-table-container').html(response.table);
                        $('#confirmDeleteModal').modal('hide');
                    } else {
                        location.reload();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Ocorreu um erro ao tentar excluir o user.');
                }
            });
        });
    });
</script>
@endsection
