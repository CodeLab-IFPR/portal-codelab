<div class="admin-ui-table-card admin-ui-card">
    <table class="table admin-ui-table" id="certificados-table">
        <thead>
            <tr>
                <th>Membro - Nome</th>
                <th>Descrição</th>
                <th>Horas</th>
                <th>Data do certificado</th>
                <th>Token</th>
                <th class="admin-ui-actions-cell">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($certificados as $certificado)
                <tr>
                    <td><p class="admin-ui-media-title">{{ $certificado->user->name }}</p></td>
                    <td class="admin-ui-certificate-description">
                        <span class="admin-ui-meta" title="{{ $certificado->descricao }}">{{ \Illuminate\Support\Str::limit($certificado->descricao, 60, '...') }}</span>
                    </td>
                    <td><span class="admin-ui-meta">{{ $certificado->horas }}</span></td>
                    <td><span class="admin-ui-meta">{{ \Carbon\Carbon::parse($certificado->data)->format('d/m/Y') }}</span></td>
                    <td><span class="admin-ui-meta">{{ $certificado->token }}</span></td>
                    <td class="admin-ui-actions-cell">
                        <div class="dropdown">
                            <button class="admin-ui-dropdown-toggle" type="button" id="dropdownMenuButton{{ $certificado->id }}"
                                data-bs-toggle="dropdown" aria-expanded="false" aria-label="Ações do certificado de {{ $certificado->user->name }}">
                                <i class="bi bi-sliders2" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end admin-ui-actions-menu" aria-labelledby="dropdownMenuButton{{ $certificado->id }}">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center external-link" href="{{ route('certificados.view', $certificado->id) }}">
                                        <i class="bi bi-eye admin-ui-action-icon-primary me-2"></i> Visualizar
                                    </a>
                                </li>
                                @can('Editar Certificado')
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('certificados.edit', $certificado->id) }}">
                                        <i class="bi bi-pencil-square admin-ui-action-icon-primary me-2"></i> Editar
                                    </a></li>
                                @endcan
                                @can('Deletar Certificado')
                                    <li><a href="#" class="dropdown-item d-flex align-items-center btn-delete"
                                        data-url="{{ route('certificados.destroy', $certificado->id) }}"
                                        data-nome="{{ $certificado->user->name }}" data-descricao="{{ $certificado->descricao }}"
                                        data-horas="{{ $certificado->horas }}" data-data="{{ \Carbon\Carbon::parse($certificado->data)->format('d/m/Y') }}"
                                        data-token="{{ $certificado->token }}">
                                        <i class="bi bi-trash admin-ui-action-icon-danger me-2"></i> Deletar
                                    </a></li>
                                @endcan
                            </ul>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="admin-ui-table-empty">Não há certificados cadastrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<x-admin.paginator :paginator="$certificados->withQueryString()" />
