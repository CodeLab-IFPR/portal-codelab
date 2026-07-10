<table class="table admin-ui-table" id="users-table">
    <thead>
        <tr>
            <th>Foto</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Contato</th>
            <th>Status</th>
            <th>Cargo</th>
            <th>Função</th>
            <th class="admin-ui-actions-cell">Ações</th>
        </tr>
    </thead>

    <tbody>
        @forelse($users as $user)
            <tr>
                <td>
                    <div class="admin-ui-avatar">
                        <img src="/imagens/users/{{ $user->imagem }}" alt="{{ $user->alt }}">
                    </div>
                </td>
                <td><p class="admin-ui-media-title mb-0">{{ $user->name }}</p></td>
                <td><span class="admin-ui-meta">{{ $user->cpf }}</span></td>
                <td>
                    <div class="admin-ui-media-copy">
                        <div>{{ $user->email }}</div>
                        @if ($user->whatsapp)
                            <div class="mt-1">
                                <a href="https://wa.me/55{{ $user->whatsapp }}" target="_blank" class="admin-ui-link">
                                    <i class="bi bi-whatsapp text-success me-1"></i>{{ preg_replace('/^(\d{2})(\d{5})(\d{4})$/', '($1) $2-$3', $user->whatsapp) }}
                                </a>
                            </div>
                        @endif
                    </div>
                </td>
                <td>
                    @if ($user->ativo)
                        <span class="admin-ui-badge admin-ui-badge-success">Ativo</span>
                    @else
                        <span class="admin-ui-badge admin-ui-badge-danger">Inativo</span>
                    @endif
                </td>
                <td>{{ $user->cargo }}</td>
                <td>
                    <div class="admin-ui-role-list">
                        @if (!empty($user->getRoleNames()))
                            @foreach ($user->getRoleNames() as $role)
                                <span class="admin-ui-badge {{ $role === 'Admin' ? 'admin-ui-badge-primary' : 'admin-ui-badge-neutral' }}">{{ $role }}</span>
                            @endforeach
                        @endif
                    </div>
                </td>
                <td class="admin-ui-actions-cell">
                    <div class="dropdown">
                        <button class="admin-ui-dropdown-toggle" type="button"
                            id="dropdownMenuButton{{ $user->id }}" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-sliders2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end admin-ui-actions-menu" aria-labelledby="dropdownMenuButton{{ $user->id }}">
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('users.show', $user->id) }}">
                                    <i class="bi bi-eye admin-ui-action-icon-primary me-2"></i> Visualizar
                                </a>
                            </li>
                            <li>
                                @can('Editar Membro')
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('users.edit', $user->id) }}">
                                    <i class="bi bi-pencil-square admin-ui-action-icon-primary me-2"></i> Editar
                                </a>
                                @endcan
                            </li>
                            <li>
                                @can('Deletar Membro')
                                <a href="#" class="dropdown-item d-flex align-items-center btn-delete"
                                    data-url="{{ route('users.destroy', $user->id) }}"
                                    data-name="{{ $user->name }}"
                                    data-cpf="{{ $user->cpf }}"
                                    data-cargo="{{ $user->cargo }}"
                                    data-imagem="/imagens/users/{{ $user->imagem }}"
                                    data-alt="{{ $user->alt }}">
                                    <i class="bi bi-trash admin-ui-action-icon-danger me-2"></i> Deletar
                                </a>
                                @endcan
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="admin-ui-table-empty">Não há membros cadastrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>
