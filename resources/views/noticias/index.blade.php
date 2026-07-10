@extends('layouts.admin')

@section('title')
Notícias
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Notícias</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="admin-ui-page admin-ui-page-fluid">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Notícias</h1>
        </div>
        <a class="admin-ui-btn admin-ui-btn-primary" href="{{ route('noticias.create') }}">
            <i class="fa fa-plus"></i>
            <span class="admin-ui-mobile-hide">Nova notícia</span>
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
        <form id="search-form" class="admin-ui-search-form" method="GET" action="{{ route('noticias.index') }}">
            <input id="search-input" class="admin-ui-search-input" type="search" name="search"
                placeholder="Buscar notícias" aria-label="Buscar notícias" value="{{ request('search') }}">
            <button class="admin-ui-btn admin-ui-btn-secondary" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <div class="admin-ui-table-card admin-ui-card">
        <div id="noticias-table-container">
            @include('noticias.table', ['noticias' => $noticias])
        </div>
    </div>

    <div id="noticias-pagination-container">
        <x-admin.paginator :paginator="$noticias" />
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
                <p>Tem certeza de que deseja excluir esta notícia? Esta ação não pode ser desfeita.</p>
                <div id="noticia-info">
                    <p><strong>Título:</strong> <span id="noticia-titulo"></span></p>
                    <p><strong>Autor:</strong> <span id="noticia-autor"></span></p>
                    <p><strong>Categoria:</strong> <span id="noticia-categoria"></span></p>
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
        const updateNoticiasList = function (url, query) {
            $.ajax({
                url: url,
                type: 'GET',
                data: query,
                success: function (response) {
                    $('#noticias-table-container').html(response.table);
                    $('#noticias-pagination-container').html(response.pagination);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Ocorreu um erro ao atualizar as notícias.');
                }
            });
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            var query = $('#search-input').val();
            updateNoticiasList("{{ route('noticias.index') }}", { search: query });
        });

        $('body').on('click', '.admin-ui-pagination a', function (e) {
            e.preventDefault();

            if ($(this).attr('aria-disabled') === 'true') {
                return;
            }

            var url = $(this).attr('href');
            var query = { search: $('#search-input').val() };

            updateNoticiasList(url, query);
        });

        $('body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            var titulo = $(this).data('titulo');
            var autor = $(this).data('autor');
            var categoria = $(this).data('categoria');

            $('#noticia-titulo').text(titulo);
            $('#noticia-autor').text(autor);
            $('#noticia-categoria').text(categoria);

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
                        $('#noticias-table-container').html(response.table);
                        $('#noticias-pagination-container').html(response.pagination);
                        $('#confirmDeleteModal').modal('hide');
                    } else {
                        location.reload();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Ocorreu um erro ao tentar excluir a notícia.');
                }
            });
        });
    });
</script>
@endsection
