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

    <div class="card-body">

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

        <table class="table table-bordered table-striped mt-4" id="membros-table">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Cpf</th>
                    <th>Ativo</th>
                    <th>Cargo</th>
                    <th>Ação</th>
                </tr>
            </thead>

            <tbody>
                @forelse($membros as $membro)
                    <tr>
                        <td><img src="/imagens/{{ $membro->imagem }}" alt="{{ $membro->alt }}" width="100px"></td>
                        <td>{{ $membro->nome }}</td>
                        <td>{{ $membro->cpf }}</td>
                        <td>{{ $membro->ativo ? 'Sim' : 'Não' }}</td>
                        <td>{{ $membro->cargo }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $membro->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-gear"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $membro->id }}">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('membros.view', $membro->id) }}">
                                            <i class="bi bi-eye text-secondary me-2"></i> Visualizar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('membros.edit', $membro->id) }}">
                                            <i class="bi bi-pencil-square text-warning me-2"></i> Editar
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item d-flex align-items-center btn-delete"
                                            data-url="{{ route('membros.destroy', $membro->id) }}"
                                            data-nome="{{ $membro->nome }}"
                                            data-cpf="{{ $membro->cpf }}"
                                            data-cargo="{{ $membro->cargo }}">
                                            <i class="bi bi-trash text-danger me-2"></i> Deletar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a class="btn btn-outline-success btn-sm"
                                    href="{{ route('membros.create') }}">
                                    <i class="fa fa-plus"></i> Adicionar Membro
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {!! $membros->withQueryString()->links('pagination::bootstrap-5') !!}

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
                    <p><strong><img src="/imagens/{{ $membro->imagem }}" alt="{{ $membro->alt }}" width="100px"></p>
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
        $('body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            var nome = $(this).data('nome');
            var cpf = $(this).data('cpf');
            var cargo = $(this).data('cargo');

            $('#membro-nome').text(nome);
            $('#membro-cpf').text(cpf);
            $('#membro-cargo').text(cargo);

            $('#confirmDeleteButton').data('url', url);
            $('#confirmDeleteModal').modal('show');
        });

        $('#confirmDeleteButton').on('click', function () {
            var url = $(this).data('url');
            $.ajax({
                url: url,
                method: 'DELETE',
                success: function (response) {
                    $('#membros-table').html(response.table);
                    $('#confirmDeleteModal').modal('hide');
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