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
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        @hasrole('Admin')
                        <th scope="col"><input type="checkbox" class="form-check-input" id="select-all" aria-label="Selecionar todos"></th>
                        @endhasrole
                        <th scope="col">Projeto</th>
                        <th scope="col">Serviço</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Data Início</th>
                        <th scope="col">Data Final</th>
                        <th scope="col">Horas Trabalhadas</th>
                        @hasrole('Admin')
                        <th scope="col">Status Certificado</th>
                        @endhasrole
                        <th scope="col">Link</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lancamentos as $lancamento)
                        <tr>
                            @can('Criar Certificado')
                            <td>
                                <input type="checkbox" class="form-check-input" name="lancamentos[]" value="{{ $lancamento->id }}"
                                    {{ $lancamento->certificado_gerado ? 'checked disabled' : '' }} aria-label="Selecionar lançamento">
                            </td>
                            @endcan
                            <td>{{ $lancamento->projeto->nome }}</td>
                            <td>{{ $lancamento->servico->descricao }}</td>
                            <td>{{ $lancamento->user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($lancamento->data_inicio)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($lancamento->data_final)->format('d/m/Y') }}</td>
                            <td>{{ $lancamento->horas_trabalhadas }}</td>
                            @can('Visualizar Certificado')         
                            <td>
                                <span class="badge {{ $lancamento->certificado_gerado ? 'bg-success' : 'bg-warning' }}">
                                    {{ $lancamento->certificado_gerado ? 'Gerado' : 'Pendente' }}
                                </span>
                            </td>
                            @endcan
                            <td><a href="{{ $lancamento->link }}" target="_blank" class="btn btn-link">Commit</a></td>
                            <td>
                                <div class="dropdown text-center">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            @can('Editar Lançamento')
                                                <a class="dropdown-item"
                                                    href="{{ route('lancamentos.edit', $lancamento->id) }}"><i
                                                        class="fa-solid fa-pen-to-square"></i> Editar</a>
                                            @endcan
                                        </li>
                                        <li>
                                            @can('Deletar Lançamento')
                                                <button type="button" class="dropdown-item"
                                                    onclick="deleteLancamento({{ $lancamento->id }})">
                                                    <i class="fa-solid fa-trash"></i> Deletar
                                                </button>
                                            @endcan
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Nenhum lançamento encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @hasrole('Admin')
            <button type="submit" class="btn btn-outline-success">Gerar Certificados</button>
            @endhasrole
        </form>
    </div>
    {!! $lancamentos->withQueryString()->links('pagination::bootstrap-5') !!}
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

    function deleteLancamento(id) {
        if (confirm('Tem certeza que deseja deletar este lançamento?')) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/lancamentos/' + id;
            form.style.display = 'none';

            var csrfInput = document.createElement('input');
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            var methodInput = document.createElement('input');
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection