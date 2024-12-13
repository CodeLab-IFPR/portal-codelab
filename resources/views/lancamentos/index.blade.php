@extends('layouts.admin')

@section('title')
Lançamentos
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Lançamentos</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lançamentos</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container d-flex justify-content-center">
    <div class="w-75">
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

        <form method="POST" action="{{ route('lancamentos.generateCertificates') }}">
            @csrf
            <div id="lancamentos-table-container">
                @include('lancamentos.table', ['lancamentos' => $lancamentos])
            </div>
            @hasrole('Admin')
            <button type="submit" class="btn btn-outline-success">Gerar Certificados</button>
            @endhasrole
        </form>
    </div>
    {!! $lancamentos->withQueryString()->links('pagination::bootstrap-5') !!}
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza de que deseja excluir este lançamento? Esta ação não pode ser desfeita.</p>
                <div id="lancamento-info">
                    <p><strong>Projeto:</strong> <span id="lancamento-projeto"></span></p>
                    <p><strong>Serviço:</strong> <span id="lancamento-servico"></span></p>
                    <p><strong>Nome:</strong> <span id="lancamento-nome"></span></p>
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
    document.getElementById('select-all').onclick = function () {
        var checkboxes = document.getElementsByName('lancamentos[]');
        for (var checkbox of checkboxes) {
            if (!checkbox.disabled) {
                checkbox.checked = this.checked;
            }
        }
    }

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            var projeto = $(this).data('projeto');
            var servico = $(this).data('servico');
            var nome = $(this).data('nome');

            $('#lancamento-projeto').text(projeto);
            $('#lancamento-servico').text(servico);
            $('#lancamento-nome').text(nome);

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
                        $('#lancamentos-table-container').html(response.table);
                        $('#confirmDeleteModal').modal('hide');
                    } else {
                        location.reload();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Ocorreu um erro ao tentar excluir o lançamento.');
                }
            });
        });
    });
</script>
@endsection