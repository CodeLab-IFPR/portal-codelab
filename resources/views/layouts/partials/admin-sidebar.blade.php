@php
    $brandName = \App\Models\FraseInicio::getParametro(PARAM_NOME_ORGANIZACAO) ?: config('app.name', 'CodeLab');
    $brandIconPath = \App\Models\FraseInicio::getParametro(PARAM_ICON_LOGO) ?: 'img/codelab-logo-ico.png';

    $activeGroup = match (true) {
        request()->routeIs('funcoes.*') || request()->routeIs('permissoes.*') => 'acesso',
        request()->routeIs('noticias.*') || request()->routeIs('galeria.*') => 'conteudo',
        request()->routeIs('users.*') || request()->routeIs('parceiros.*') => 'pessoas',
        request()->routeIs('certificados.*') => 'certificados',
        request()->routeIs('admin.frase_inicio.editar') || request()->routeIs('mensagens.*') || request()->routeIs('submissions.*') => 'site',
        request()->routeIs('projetos.*') || request()->routeIs('tags.*') => 'projetos',
        request()->routeIs('servicos.*') || request()->routeIs('lancamentos.*') => 'servicos_lancamentos',
        default => 'geral',
    };
@endphp

<aside class="app-sidebar admin-sidebar" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('admin') }}" class="brand-link">
            <span class="admin-brand-mark">
                <img src="{{ asset($brandIconPath) }}" alt="{{ $brandName }}">
            </span>
            <span class="admin-brand-copy">
                <span class="admin-brand-title">{{ $brandName }}</span>
                <span class="admin-brand-subtitle">Admin</span>
            </span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="admin-sidebar-nav" aria-label="Navegação administrativa">
            <div class="admin-sidebar-accordion" data-admin-sidebar-accordion>
                <section class="admin-sidebar-group {{ $activeGroup === 'geral' ? 'is-open' : '' }}" data-admin-sidebar-group>
                    <button type="button" class="admin-sidebar-group-header" data-admin-sidebar-toggle aria-expanded="{{ $activeGroup === 'geral' ? 'true' : 'false' }}">
                        <span>Geral</span>
                        <i class="bi {{ $activeGroup === 'geral' ? 'bi-chevron-down' : 'bi-chevron-right' }}" aria-hidden="true"></i>
                    </button>
                    <div class="admin-sidebar-group-panel">
                        <a href="{{ route('admin') }}" class="admin-sidebar-item {{ request()->routeIs('admin') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-speedometer2" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                </section>

                @canany(['Criar Função', 'Visualizar Função', 'Criar Permissão', 'Visualizar Permissão'])
                <section class="admin-sidebar-group {{ $activeGroup === 'acesso' ? 'is-open' : '' }}" data-admin-sidebar-group>
                    <button type="button" class="admin-sidebar-group-header" data-admin-sidebar-toggle aria-expanded="{{ $activeGroup === 'acesso' ? 'true' : 'false' }}">
                        <span>Acesso</span>
                        <i class="bi {{ $activeGroup === 'acesso' ? 'bi-chevron-down' : 'bi-chevron-right' }}" aria-hidden="true"></i>
                    </button>
                    <div class="admin-sidebar-group-panel">
                        @can('Visualizar Função')
                        <a href="{{ route('funcoes.index') }}" class="admin-sidebar-item {{ request()->routeIs('funcoes.index') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-people" aria-hidden="true"></i>
                            <span>Funções</span>
                        </a>
                        @endcan
                        @can('Visualizar Permissão')
                        <a href="{{ route('permissoes.index') }}" class="admin-sidebar-item {{ request()->routeIs('permissoes.index') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-shield-check" aria-hidden="true"></i>
                            <span>Permissões</span>
                        </a>
                        @endcan
                    </div>
                </section>
                @endcanany

                @canany(['Criar Notícia', 'Visualizar Notícia', 'Visualizar Galeria'])
                <section class="admin-sidebar-group {{ $activeGroup === 'conteudo' ? 'is-open' : '' }}" data-admin-sidebar-group>
                    <button type="button" class="admin-sidebar-group-header" data-admin-sidebar-toggle aria-expanded="{{ $activeGroup === 'conteudo' ? 'true' : 'false' }}">
                        <span>Conteúdo</span>
                        <i class="bi {{ $activeGroup === 'conteudo' ? 'bi-chevron-down' : 'bi-chevron-right' }}" aria-hidden="true"></i>
                    </button>
                    <div class="admin-sidebar-group-panel">
                        @can('Visualizar Notícia')
                        <a href="{{ route('noticias.index') }}" class="admin-sidebar-item {{ request()->routeIs('noticias.index') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-newspaper" aria-hidden="true"></i>
                            <span>Notícias</span>
                        </a>
                        @endcan
                        @can('Visualizar Galeria')
                        <a href="{{ route('galeria.indexAdmin') }}" class="admin-sidebar-item {{ request()->routeIs('galeria.indexAdmin') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-images" aria-hidden="true"></i>
                            <span>Galeria</span>
                        </a>
                        @endcan
                    </div>
                </section>
                @endcanany

                @canany(['Criar Membro', 'Visualizar Membro', 'Criar Parceiro', 'Visualizar Parceiro'])
                <section class="admin-sidebar-group {{ $activeGroup === 'pessoas' ? 'is-open' : '' }}" data-admin-sidebar-group>
                    <button type="button" class="admin-sidebar-group-header" data-admin-sidebar-toggle aria-expanded="{{ $activeGroup === 'pessoas' ? 'true' : 'false' }}">
                        <span>Pessoas</span>
                        <i class="bi {{ $activeGroup === 'pessoas' ? 'bi-chevron-down' : 'bi-chevron-right' }}" aria-hidden="true"></i>
                    </button>
                    <div class="admin-sidebar-group-panel">
                        @can('Visualizar Membro')
                        <a href="{{ route('users.index') }}" class="admin-sidebar-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-person-lines-fill" aria-hidden="true"></i>
                            <span>Membros</span>
                        </a>
                        @endcan
                        @can('Visualizar Parceiro')
                        <a href="{{ route('parceiros.index') }}" class="admin-sidebar-item {{ request()->routeIs('parceiros.index') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-building" aria-hidden="true"></i>
                            <span>Parceiros</span>
                        </a>
                        @endcan
                    </div>
                </section>
                @endcanany

                @canany(['Criar Certificado', 'Visualizar Certificado'])
                <section class="admin-sidebar-group {{ $activeGroup === 'certificados' ? 'is-open' : '' }}" data-admin-sidebar-group>
                    <button type="button" class="admin-sidebar-group-header" data-admin-sidebar-toggle aria-expanded="{{ $activeGroup === 'certificados' ? 'true' : 'false' }}">
                        <span>Certificados</span>
                        <i class="bi {{ $activeGroup === 'certificados' ? 'bi-chevron-down' : 'bi-chevron-right' }}" aria-hidden="true"></i>
                    </button>
                    <div class="admin-sidebar-group-panel">
                        @can('Visualizar Certificado')
                        <a href="{{ route('certificados.index') }}" class="admin-sidebar-item {{ request()->routeIs('certificados.index') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-patch-check" aria-hidden="true"></i>
                            <span>Todos os certificados</span>
                        </a>
                        @endcan
                    </div>
                </section>
                @endcanany

                @canany(['Criar Frase', 'Visualizar Mensagem', 'Visualizar Submissão'])
                <section class="admin-sidebar-group {{ $activeGroup === 'site' ? 'is-open' : '' }}" data-admin-sidebar-group>
                    <button type="button" class="admin-sidebar-group-header" data-admin-sidebar-toggle aria-expanded="{{ $activeGroup === 'site' ? 'true' : 'false' }}">
                        <span>Site e Demandas</span>
                        <i class="bi {{ $activeGroup === 'site' ? 'bi-chevron-down' : 'bi-chevron-right' }}" aria-hidden="true"></i>
                    </button>
                    <div class="admin-sidebar-group-panel">
                        @can('Criar Frase')
                        <a href="{{ route('admin.frase_inicio.editar') }}" class="admin-sidebar-item {{ request()->routeIs('admin.frase_inicio.editar') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-pencil-square" aria-hidden="true"></i>
                            <span>Editar página</span>
                        </a>
                        @endcan
                        @can('Visualizar Mensagem')
                        <a href="{{ route('mensagens.index') }}" class="admin-sidebar-item {{ request()->routeIs('mensagens.index') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-envelope" aria-hidden="true"></i>
                            <span>Contato</span>
                        </a>
                        @endcan
                        @can('Visualizar Submissão')
                        <a href="{{ route('submissions.index') }}" class="admin-sidebar-item {{ request()->routeIs('submissions.index') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-inbox" aria-hidden="true"></i>
                            <span>Submissões</span>
                        </a>
                        @endcan
                    </div>
                </section>
                @endcanany

                @canany(['Criar Projeto', 'Visualizar Projeto'])
                <section class="admin-sidebar-group {{ $activeGroup === 'projetos' ? 'is-open' : '' }}" data-admin-sidebar-group>
                    <button type="button" class="admin-sidebar-group-header" data-admin-sidebar-toggle aria-expanded="{{ $activeGroup === 'projetos' ? 'true' : 'false' }}">
                        <span>Projetos</span>
                        <i class="bi {{ $activeGroup === 'projetos' ? 'bi-chevron-down' : 'bi-chevron-right' }}" aria-hidden="true"></i>
                    </button>
                    <div class="admin-sidebar-group-panel">
                        @can('Visualizar Projeto')
                        <a href="{{ route('projetos.index') }}" class="admin-sidebar-item {{ request()->routeIs('projetos.index') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-folder2-open" aria-hidden="true"></i>
                            <span>Projetos</span>
                        </a>
                        @endcan
                        @can('Criar Projeto')
                        <a href="{{ route('tags.index') }}" class="admin-sidebar-item {{ request()->routeIs('tags.index') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-tags" aria-hidden="true"></i>
                            <span>Tags</span>
                        </a>
                        @endcan
                    </div>
                </section>
                @endcanany

                @canany(['Criar Serviço', 'Visualizar Serviço', 'Criar Lançamento', 'Visualizar Lançamento'])
                <section class="admin-sidebar-group {{ $activeGroup === 'servicos_lancamentos' ? 'is-open' : '' }}" data-admin-sidebar-group>
                    <button type="button" class="admin-sidebar-group-header" data-admin-sidebar-toggle aria-expanded="{{ $activeGroup === 'servicos_lancamentos' ? 'true' : 'false' }}">
                        <span>Serviços e Lançamentos</span>
                        <i class="bi {{ $activeGroup === 'servicos_lancamentos' ? 'bi-chevron-down' : 'bi-chevron-right' }}" aria-hidden="true"></i>
                    </button>
                    <div class="admin-sidebar-group-panel">
                        @can('Visualizar Serviço')
                        <a href="{{ route('servicos.index') }}" class="admin-sidebar-item {{ request()->routeIs('servicos.index') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-list-check" aria-hidden="true"></i>
                            <span>Serviços</span>
                        </a>
                        @endcan
                        @can('Visualizar Lançamento')
                        <a href="{{ route('lancamentos.index') }}" class="admin-sidebar-item {{ request()->routeIs('lancamentos.index') ? 'active' : '' }}">
                            <i class="admin-sidebar-item-icon bi bi-calendar-event" aria-hidden="true"></i>
                            <span>Lançamentos</span>
                        </a>
                        @endcan
                    </div>
                </section>
                @endcanany
            </div>
        </nav>

        <div class="admin-sidebar-footer">
            <button type="button" class="admin-profile-link" data-admin-profile-toggle aria-expanded="false">
                @if(auth()->check() && auth()->user()->imagem)
                    <img src="/imagens/users/{{ auth()->user()->imagem }}" class="admin-profile-avatar" alt="{{ auth()->user()->alt }}">
                @else
                    <span class="admin-profile-avatar d-inline-flex align-items-center justify-content-center text-white fw-bold">
                        {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'CL' }}
                    </span>
                @endif
                <span class="admin-profile-copy">
                    <span class="admin-profile-name">{{ auth()->check() ? auth()->user()->name : 'CodeLab' }}</span>
                    <span class="admin-profile-email">{{ auth()->check() ? auth()->user()->email : 'admin@codelab.dev' }}</span>
                </span>
                <i class="admin-profile-chevron bi bi-three-dots"></i>
            </button>

            <div class="admin-profile-popover" data-admin-profile-popover hidden>
                <a href="{{ route('profile.edit') }}" class="admin-profile-popover-item">
                    <i class="bi bi-person-gear" aria-hidden="true"></i>
                    Editar perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="admin-profile-popover-item">
                        <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-admin-sidebar-accordion]').forEach((accordion) => {
            accordion.addEventListener('click', (event) => {
                const toggle = event.target.closest('[data-admin-sidebar-toggle]');

                if (!toggle || !accordion.contains(toggle)) {
                    return;
                }

                const currentGroup = toggle.closest('[data-admin-sidebar-group]');
                const shouldOpen = !currentGroup.classList.contains('is-open');

                accordion.querySelectorAll('[data-admin-sidebar-group]').forEach((group) => {
                    const groupToggle = group.querySelector('[data-admin-sidebar-toggle]');
                    const arrow = groupToggle.querySelector('.bi');
                    const isCurrent = group === currentGroup && shouldOpen;

                    if (group.hasAttribute('data-admin-sidebar-static-open')) {
                        group.classList.add('is-open');
                        groupToggle.setAttribute('aria-expanded', 'true');
                        arrow.classList.add('bi-chevron-down');
                        arrow.classList.remove('bi-chevron-right');
                        return;
                    }

                    group.classList.toggle('is-open', isCurrent);
                    groupToggle.setAttribute('aria-expanded', isCurrent ? 'true' : 'false');
                    arrow.classList.toggle('bi-chevron-down', isCurrent);
                    arrow.classList.toggle('bi-chevron-right', !isCurrent);
                });
            });
        });

        document.querySelectorAll('.admin-sidebar-footer').forEach((footer) => {
            const toggle = footer.querySelector('[data-admin-profile-toggle]');
            const popover = footer.querySelector('[data-admin-profile-popover]');

            if (!toggle || !popover) {
                return;
            }

            toggle.addEventListener('click', () => {
                const isOpen = popover.hidden;

                popover.hidden = !isOpen;
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                footer.classList.toggle('is-profile-open', isOpen);
            });

            document.addEventListener('click', (event) => {
                if (footer.contains(event.target)) {
                    return;
                }

                popover.hidden = true;
                toggle.setAttribute('aria-expanded', 'false');
                footer.classList.remove('is-profile-open');
            });
        });
    });
</script>
