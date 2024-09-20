@extends('layouts.admin')

<!-- Título -->
@section('title')
Membros - Lista
@endsection
<!-- Título -->

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Membros - Lista</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Membros - Lista
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end" style="margin-right: 10px;">
            <a class="btn btn-outline-success btn-sm" href="{{ route('membros.create') }}">
                <i class="fa fa-plus"></i> Adicionar Membro
            </a>
        </div>

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
        <div class="d-flex justify-content-center mb-4">
            <form id="search-form" class="d-flex" method="GET" action="{{ route('membros.index') }}">
            <input id="search-input" class="form-control me-2" type="search" name="search" placeholder="Buscar Membros"
                aria-label="Search">
            <button class="btn btn-outline-success" type="submit">
                <i class="bi bi-search"></i>
            </button>
            </form>
        </div>

        <div class="card-body">
            <div id="membros-table-container">
                @include('membros.table', ['membros' => $membros])
            </div>
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
                <p>Tem certeza de que deseja excluir este membro? Esta ação não pode ser desfeita.</p>
                <div id="membro-info">
                    <img id="membro-imagem" src="" alt="Imagem do Membro" width="100px">
                    <p><strong>Nome:</strong> <span id="membro-nome"></span></p>
                    <p><strong>Cpf:</strong> <span id="membro-cpf"></span></p>
                    <p><strong>Cargo:</strong> <span id="membro-cargo"></span></p>
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
                url: "{{ route('membros.index') }}",
                type: 'GET',
                data: { search: query },
                success: function (response) {
                    $('#membros-table-container').html(response.table);
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
            var nome = $(this).data('nome');
            var cpf = $(this).data('cpf');
            var cargo = $(this).data('cargo');
            var imagem = $(this).data('imagem');
            var alt = $(this).data('alt');

            $('#membro-nome').text(nome);
            $('#membro-cpf').text(cpf);
            $('#membro-cargo').text(cargo);
            $('#membro-imagem').attr('src', imagem);
            $('#membro-imagem').attr('alt', alt);

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
                        $('#membros-table-container').html(response.table);
                        $('#confirmDeleteModal').modal('hide');
                    } else {
                        location.reload();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Ocorreu um erro ao tentar excluir o membro.');
                }
            });
        });
    });
</script>
@endsection