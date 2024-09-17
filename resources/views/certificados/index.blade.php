@extends('layouts.admin')

<!-- Título -->
@section('title')
Certificados - Lista
@endsection
<!-- Título -->

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Certificados - Lista</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Certificados - Lista
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
        <div class="d-flex justify-content-center mb-4">
            <form class="d-flex" method="GET" action="{{ route('certificados.index') }}">
                <input class="form-control me-2" type="search" name="search" placeholder="Buscar Certificados"
                    aria-label="Search">
                <button class="btn btn-outline-success" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <table class="table table-bordered table-striped mt-4" id="certificados-table">
            <thead>
                <tr>
                    <th>Membro - Nome</th>
                    <th>Descrição</th>
                    <th>Horas</th>
                    <th>Data Certificado</th>
                    <th>Token</th>
                    <th>Ação</th>
                </tr>
            </thead>

            <tbody>
                @forelse($certificados as $certificado)
                    <tr>
                        <td>{{ $certificado->membro->nome }}</td>
                        <td>{{ mb_strimwidth("$certificado->descricao", 0, 250, "...") }}
                        </td>
                        <td>{{ $certificado->horas }} </td>
                        <td>{{ \Carbon\Carbon::parse($certificado->data)->format('d/m/Y') }}
                        </td>
                        <td>{{ $certificado->token }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $certificado->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-gear"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $certificado->id }}">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('certificados.view', $certificado->id) }}">
                                            <i class="bi bi-eye text-secondary me-2"></i> Visualizar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('certificados.edit', $certificado->id) }}">
                                            <i class="bi bi-pencil-square text-warning me-2"></i> Editar
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item d-flex align-items-center btn-delete"
                                            data-url="{{ route('certificados.destroy', $certificado->id) }}"
                                            data-nome="{{ $certificado->membro->nome }}"
                                            data-descricao="{{ $certificado->descricao }}"
                                            data-horas="{{ $certificado->horas }}"
                                            data-data="{{ \Carbon\Carbon::parse($certificado->data)->format('d/m/Y') }}"
                                            data-token="{{ $certificado->token }}">
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
                                    href="{{ route('certificados.create') }}">
                                    <i class="fa fa-plus"></i> Adicionar Certificado
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {!! $certificados->withQueryString()->links('pagination::bootstrap-5') !!}

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
                    $('#certificados-table').html(response.table);
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
