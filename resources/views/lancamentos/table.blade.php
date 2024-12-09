
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
                                    <button type="button" class="dropdown-item btn-delete"
                                        data-url="{{ route('lancamentos.destroy', $lancamento->id) }}"
                                        data-projeto="{{ $lancamento->projeto->nome }}"
                                        data-servico="{{ $lancamento->servico->descricao }}"
                                        data-nome="{{ $lancamento->user->name }}">
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

{!! $lancamentos->withQueryString()->links('pagination::bootstrap-5') !!}