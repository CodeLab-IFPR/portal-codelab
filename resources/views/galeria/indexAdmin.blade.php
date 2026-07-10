@extends('layouts.admin')

@section('title')
Galeria
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Galeria</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="admin-ui-page admin-ui-page-fluid">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Galeria</h1>
        </div>
        <a class="admin-ui-btn admin-ui-btn-primary" href="{{ route('galeria.create') }}">
            <i class="fa fa-plus"></i>
            <span class="admin-ui-mobile-hide">Nova mídia</span>
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

    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif

    <div class="admin-ui-table-card admin-ui-card">
        <div id="galeria-table-container">
            @include('galeria.table', ['midias' => $midias])
        </div>
    </div>

    <div id="galeria-pagination-container">
        <x-admin.paginator :paginator="$midias" />
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza de que deseja excluir esta mídia? Esta ação não pode ser desfeita.</p>
                <div id="midia-info">
                    <p><strong>Título:</strong> <span id="midia-titulo"></span></p>
                    <div class="admin-ui-thumbnail admin-ui-thumbnail-modal">
                        <img id="midia-imagem" src="" alt="Preview da mídia">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" class="d-none">
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

        $('body').on('click', '.btn-delete', function (e) {
            e.preventDefault();

            $('#midia-titulo').text($(this).data('titulo'));
            $('#midia-imagem').attr('src', $(this).data('preview'));
            $('#confirmDeleteButton').data('url', $(this).data('url'));
            $('#confirmDeleteModal').modal('show');
        });

        $('#confirmDeleteButton').on('click', function () {
            $.ajax({
                url: $(this).data('url'),
                method: 'DELETE',
                success: function () {
                    window.location.reload();
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Ocorreu um erro ao tentar excluir a mídia.');
                }
            });
        });
    });
</script>
@endsection
