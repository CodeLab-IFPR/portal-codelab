@extends('layouts.admin')
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
            <div class="alert alert-success" role="alert"> {{ session('success') }} </div>
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
                        <td>{{ \Carbon\Carbon::parse($certificado->data)->format('d/m/Y') }}</td>
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
                                            href="{{ route('certificados.view',$certificado->id) }}">
                                            <i class="bi bi-eye text-secondary me-2"></i> Visualizar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('certificados.edit',$certificado->id) }}">
                                            <i class="bi bi-pencil-square text-warning me-2"></i> Editar
                                        </a>
                                    </li>
                                    <li>
                                        <form
                                            action="{{ route('certificados.destroy',$certificado->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item d-flex align-items-center">
                                                <i class="bi bi-trash text-danger me-2"></i> Deletar
                                            </button>
                                        </form>
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
                                    href="{{ route('certificados.create') }}"> <i
                                        class="fa fa-plus"></i> Adicionar Certificado</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {!! $certificados->withQueryString()->links('pagination::bootstrap-5') !!}

    </div>
</div>
<script>
    $(document).ready(function () {
        $('form').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function (response) {
                    $('#certificados-table').html(response);
                }
            });
        });
    });
</script>
@endsection
