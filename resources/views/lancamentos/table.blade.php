
@php
    $totalHoras = isset($horasTotais) ? $horasTotais['total'] : $lancamentos->sum('horas_trabalhadas');
    $horasGeradas = isset($horasTotais) ? $horasTotais['geradas'] : $lancamentos->where('certificado_gerado', true)->sum('horas_trabalhadas');
    $horasPendentes = isset($horasTotais) ? $horasTotais['pendentes'] : $totalHoras - $horasGeradas;
    $percentualGeradas = isset($horasTotais) ? $horasTotais['percentual'] : ($totalHoras > 0 ? ($horasGeradas / $totalHoras) * 100 : 0);
@endphp

<div class="border-1 bg-white mb-4 card shadow-sm">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h6 class="fw-bold mb-2">
                    Totalizador de horas
                </h6>
                <div class="progress mb-2" style="height: 12px;">
                    <div class="progress-bar bg-success" role="progressbar" 
                         style="width: {{ $percentualGeradas }}%" 
                         aria-valuenow="{{ $percentualGeradas }}" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="d-flex flex-column">
                            <span class="h5 mb-0 text-primary fw-bold">{{ $totalHoras }}h</span>
                            <small class="text-muted">Total</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex flex-column">
                            <span class="h5 mb-0 text-success fw-bold">{{ $horasGeradas }}h</span>
                            <small class="text-muted">Certificadas</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex flex-column">
                            <span class="h5 mb-0 text-warning fw-bold">{{ $horasPendentes }}h</span>
                            <small class="text-muted">Pendentes</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            @hasrole('Admin')
            <th scope="col"><input type="checkbox" class="form-check-input" id="select-all" aria-label="Selecionar todos"></th>
            @endhasrole
            <th scope="col">Projeto</th>
            <th scope="col">Serviço</th>
            <th scope="col">Nome</th>
            <th scope="col">Descrição</th>
            <th scope="col">Data</th>
            <th scope="col">Horas</th>
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
                <td>
                    @if($lancamento->descricao)
                        {{ $lancamento->descricao }}
                    @else
                        <em>Sem descrição</em>
                    @endif
                </td>
                <td style="min-width: 110px;">
                    {{ \Carbon\Carbon::parse($lancamento->data_inicio)->format('d/m/Y') }} à <br>
                    {{ \Carbon\Carbon::parse($lancamento->data_final)->format('d/m/Y') }}
                </td>
                <td>{{ $lancamento->horas_trabalhadas }}</td>
                @can('Visualizar Certificado')         
                <td>
                    <span class="badge {{ $lancamento->certificado_gerado ? 'bg-success' : 'bg-warning' }}">
                        {{ $lancamento->certificado_gerado ? 'Gerado' : 'Pendente' }}
                    </span>
                </td>
                @endcan
                <td><a href="{{ $lancamento->link }}" target="_blank" class="btn btn-link">Link</a></td>
                <td>
                    <div class="dropdown text-center">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-cog"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                @can('Editar Lançamento')
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route('lancamentos.edit', $lancamento->id) }}"><i
                                        class="bi bi-pencil-square text-warning me-2"></i> Editar</a>
                                @endcan
                            </li>
                            <li>
                                @can('Deletar Lançamento')
                                    <button type="button" class="dropdown-item d-flex align-items-center btn-delete"
                                        data-url="{{ route('lancamentos.destroy', $lancamento->id) }}"
                                        data-projeto="{{ $lancamento->projeto->nome }}"
                                        data-servico="{{ $lancamento->servico->descricao }}"
                                        data-nome="{{ $lancamento->user->name }}">
                                        <i class="bi bi-trash text-danger me-2"></i> Deletar
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