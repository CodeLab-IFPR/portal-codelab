<table class="table table-bordered table-striped mt-4" id="users-table">
    <thead>
        <tr>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Cpf</th>
            <th>Contato</th>
            <th>Ativo</th>
            <th>Cargo</th>
            <th>Função</th>
            <th>Ação</th>
        </tr>
    </thead>

    <tbody>
        @forelse($users as $user)
            <tr>
                <td><img src="/imagens/users/{{ $user->imagem }}" alt="{{ $user->alt }}" width="80px"></td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->cpf }}</td>
                <td>
                    <div>{{ $user->email }}</div>
                    @if ($user->whatsapp)
                        <div>
                            <a href="https://wa.me/55{{ $user->whatsapp }}" target="_blank" class="text-decoration-none">
                                <i class="bi bi-whatsapp text-success me-1"></i>{{ preg_replace('/^(\d{2})(\d{5})(\d{4})$/', '($1) $2-$3', $user->whatsapp) }}
                            </a>
                        </div>
                    @endif
                </td>
                <td>{{ $user->ativo ? 'Sim' : 'Não' }}</td>
                <td>{{ $user->cargo }}</td>
                <td>
                    @if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $role)
                            <span class="badge bg-primary mx-1">{{ $role }}</span>
                        @endforeach
                        
                    @endif
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                            id="dropdownMenuButton{{ $user->id }}" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-gear"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $user->id }}">
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('users.show', $user->id) }}">
                                    <i class="bi bi-eye text-secondary me-2"></i> Visualizar
                                </a>
                            </li>
                            <li>
                                @can('Editar Membro')
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('users.edit', $user->id) }}">
                                    <i class="bi bi-pencil-square text-warning me-2"></i> Editar
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
                                    <i class="bi bi-trash text-danger me-2"></i> Deletar
                                </a>
                                @endcan
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a class="btn btn-outline-success btn-sm"
                            href="{{ route('users.create') }}">
                            <i class="fa fa-plus"></i> Adicionar Membro
                        </a>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

{!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
