<?php
$unreadMessagesCount = $unreadMessagesCount ?? 0;
$unreadSubmissionsCount = $unreadSubmissionsCount ?? 0;
$lastMessageTime = $lastMessageTime ?? 'Nenhuma mensagem';
$adminBrandName = $adminBrandName ?? (config('app.name', 'CodeLab'));
if (!isset($lastSubmissionTime)) {
    $lastSubmissionTime = 'Nenhuma submissão';
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE v4 | Dashboard">
    <meta name="author" content="ColorlibHQ">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard">
    @php
        $faviconPath = \App\Models\FraseInicio::getParametro(PARAM_FAV_ICON);
    @endphp
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset($faviconPath) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset($faviconPath) }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css"
        integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.tiny.cloud/1/i6174a4p21k3bvgofjdjglzvdfxrle8qza1n62srherxw93i/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    @vite('resources/css/adminlte.css')
    @vite('resources/css/admin-system.css')
    <style>
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        .spinner {
            width: 100px;
            height: 100px;
            position: relative;
            perspective: 800px;
        }
        
        .spinner:before, .spinner:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 10px solid transparent;
            border-top-color: #3498db;
            border-left-color: #3498db;
            animation: spin 2s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
        }
        
        .spinner:before {
            transform: rotateX(70deg);
        }
        
        .spinner:after {
            transform: rotateY(70deg);
            animation-delay: 0.4s;
        }
        
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        body {
            opacity: 0;
            transition: opacity 0.15s ease;
        }

        body.loaded {
            opacity: 1;
        }
    </style>
</head>

<body class="admin-shell layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div id="loading-screen">
        <div class="spinner"></div>
    </div>

    <div class="app-wrapper">
        <nav class="app-header navbar admin-topbar">
            <div class="container-fluid admin-topbar-main">
                <div class="admin-topbar-brand">
                    <a class="nav-link admin-topbar-toggle" data-lte-toggle="sidebar" href="#" role="button" aria-label="Alternar sidebar">
                        <i class="bi bi-layout-sidebar"></i>
                    </a>
                    <span class="admin-topbar-divider" aria-hidden="true"></span>
                    <span class="admin-topbar-title">{{ $adminBrandName }} Admin</span>
                </div>
                <ul class="navbar-nav admin-topbar-actions">
                    <li class="nav-item dropdown">
                        <a class="nav-link admin-topbar-notification" data-bs-toggle="dropdown" href="#" aria-label="Notificações">
                            <i class="bi bi-bell-fill"></i>
                            <span
                                class="navbar-badge badge text-bg-warning">{{ $unreadMessagesCount + $unreadSubmissionsCount }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end admin-topbar-notification-menu">
                            <span
                                class="dropdown-item dropdown-header">{{ $unreadMessagesCount + $unreadSubmissionsCount }}
                                Notificações</span>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('mensagens.index') }}" class="dropdown-item">
                                <i class="bi bi-envelope me-2"></i> {{ $unreadMessagesCount }} novas mensagens
                                <span class="float-end text-secondary fs-8">{{ $lastMessageTime }}</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('submissions.index') }}" class="dropdown-item">
                                <i class="bi bi-file-earmark-text me-2"></i> {{ $unreadSubmissionsCount }} novas
                                submissões
                                <span class="float-end text-secondary fs-8">{{ $lastSubmissionTime }}</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="container-fluid admin-topbar-breadcrumb-row">
                <div class="admin-topbar-breadcrumb" data-admin-header-breadcrumb></div>
            </div>
        </nav>
        @include('layouts.partials.admin-sidebar')
        {{--
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand"><a href="{{ route('admin') }}" class="brand-link"> <img
                        src="{{ asset('/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                        class="brand-image opacity-75 shadow"><span class="brand-text fw-light">AdminLTE 4</span></a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                        data-accordion="false">

                        <li
                            class="nav-item {{ request()->routeIs('funcoes.index') || request()->routeIs('funcoes.create') || request()->routeIs('permissoes.create') || request()->routeIs('permissoes.index') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon bi bi-shield-lock"></i>
                                <p>
                                    Funções e Permissões
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    @can('Criar Função')
                                    <a href="{{ route('funcoes.create') }}"
                                        class="nav-link {{ request()->routeIs('funcoes.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('funcoes.create') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Criar Função</p>
                                    </a>
                                    @endcan
                                </li>
                                <li class="nav-item">
                                    @can('Visualizar Função')
                                    <a href="{{ route('funcoes.index') }}"
                                        class="nav-link {{ request()->routeIs('funcoes.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('funcoes.index') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Listar Funções</p>
                                    </a>
                                    @endcan
                                </li>
                                <li class="nav-item">
                                    @can('Criar Permissão')
                                    <a href="{{ route('permissoes.create') }}"
                                        class="nav-link {{ request()->routeIs('permissoes.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('permissoes.create') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Criar Permissão</p>
                                    </a>
                                    @endcan
                                </li>
                                <li class="nav-item">
                                    @can('Visualizar Permissão')
                                    <a href="{{ route('permissoes.index') }}"
                                        class="nav-link {{ request()->routeIs('permissoes.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('permissoes.index') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Listar Permissões</p>
                                    </a>
                                    @endcan
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('noticias.create') || request()->routeIs('users.create') || request()->routeIs('parceiros.create') || request()->routeIs('galeria.create') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-journal-plus"></i>
                                <p>
                                    Cadastro
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    @can('Criar Notícia')
                                    <a href="{{ route('noticias.create') }}"
                                        class="nav-link {{ request()->routeIs('noticias.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('noticias.create') ? 'bi-play-fill' : 'bi-play' }}"></i>
                                        <p>Nova Notícia</p>
                                    </a>
                                    @endcan
                                </li>
                                <li class="nav-item">
                                    @can('Criar Membro')
                                    <a href="{{ route('users.create') }}"
                                        class="nav-link  {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('users.create') ? 'bi-play-fill' : 'bi-play' }}"></i>
                                        <p>Novo Membro</p>
                                    </a>
                                    @endcan
                                </li>
                                <li class="nav-item">
                                    @can('Criar Parceiro')
                                    <a href="{{ route('parceiros.create') }}"
                                        class="nav-link  {{ request()->routeIs('parceiros.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('parceiros.create') ? 'bi-play-fill' : 'bi-play' }}"></i>
                                        <p>Novo Parceiro</p>
                                    </a>
                                    @endcan
                                </li>
                                <li class="nav-item">
                                    @can('Criar Galeria')
                                    <a href="{{ route('galeria.create') }}"
                                        class="nav-link  {{ request()->routeIs('galeria.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('galeria.create') ? 'bi-play-fill' : 'bi-play' }}"></i>
                                        <p>Galeria - Nova Mídia</p>
                                    </a>
                                    @endcan
                                </li>
                            </ul>
                        </li>

                        <li
                            class="nav-item {{ request()->routeIs('noticias.index') || request()->routeIs('users.index') || request()->routeIs('parceiros.index') || request()->routeIs('galeria.indexAdmin') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-journal-text"></i>
                                <p>
                                    Lista
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    @can('Visualizar Notícia')
                                    <a href="{{ route('noticias.index') }}"
                                        class="nav-link {{ request()->routeIs('noticias.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('noticias.index') ? 'bi-play-fill' : 'bi-play' }}"></i>
                                        <p>Noticias</p>
                                    </a>
                                    @endcan
                                </li>
                                <li class="nav-item">
                                    @can('Visualizar Membro')
                                    <a href="{{ route('users.index') }}"
                                        class="nav-link  {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('users.index') ? 'bi-play-fill' : 'bi-play' }}"></i>
                                        <p>Membro</p>
                                    </a>
                                    @endcan
                                </li>
                                <li class="nav-item">
                                    @can('Visualizar Parceiro')
                                    <a href="{{ route('parceiros.index') }}"
                                        class="nav-link {{ request()->routeIs('parceiros.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('parceiros.index') ? 'bi-play-fill' : 'bi-play' }} "></i>
                                        <p>Parceiro</p>
                                    </a>
                                    @endcan
                                </li>
                                <li class="nav-item">
                                    @can('Visualizar Galeria')
                                    <a href="{{ route('galeria.indexAdmin') }}"
                                        class="nav-link {{ request()->routeIs('galeria.indexAdmin') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('galeria.indexAdmin') ? 'bi-play-fill' : 'bi-play' }} "></i>
                                        <p>Galeria</p>
                                    </a>
                                    @endcan
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('certificados.index') || request()->routeIs('certificados.create') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-award"></i>
                                <p>
                                    Certificado
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    @can('Criar Certificado')
                                    <a href="{{ route('certificados.create') }}"
                                        class="nav-link {{ request()->routeIs('certificados.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('certificados.create') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Novo Certificado</p>
                                    </a>
                                    @endcan
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    @can('Visualizar Certificado')
                                    <a href="{{ route('certificados.index') }}"
                                        class="nav-link {{ request()->routeIs('certificados.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('certificados.index') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Todos Certificados</p>
                                    </a>
                                    @endcan
                                </li>
                            </ul>
                        <li class="nav-item">
                            @can('Criar Frase')
                            <a href="{{ route('admin.frase_inicio.editar') }}"
                                class="nav-link {{ request()->routeIs('admin.frase_inicio.editar') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-pencil-square"></i>
                                <p>Editar Páginas</p>
                            </a>
                            @endcan
                        </li>
                        </li>
                        <li class="nav-item">
                            @can('Visualizar Mensagem')
                            <a href="{{ route('mensagens.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-envelope"></i>
                                <p>Contato</p>
                            </a>
                            @endcan
                        </li>
                        <li class="nav-item">
                            @can('Visualizar Submissão')
                            <a href="{{ route('submissions.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-file-earmark-text"></i>
                                <p>Submissões</p>
                            </a>
                            @endcan
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('projetos.index') || request()->routeIs('projetos.create') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-folder"></i>
                                <p>
                                    Projetos
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    @can('Criar Projeto')
                                    <a href="{{ route('projetos.create') }}"
                                        class="nav-link  {{ request()->routeIs('projetos.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('projetos.create') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Criar Projeto</p>
                                    </a>
                                    @endcan
                                </li>
                                <li class="nav-item">
                                    @can('Visualizar Projeto')
                                    <a href="{{ route('projetos.index') }}"
                                        class="nav-link {{ request()->routeIs('projetos.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('projetos.index') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Listar Projetos</p>
                                    </a>
                                    @endcan
                                </li>
                                <li class="nav-item">
                                    @can('Criar Projeto')
                                    <a href="{{ route('tags.index') }}"
                                        class="nav-link {{ request()->routeIs('tags.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('tags.index') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Tags</p>
                                    </a>
                                    @endcan
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('servicos.index') || request()->routeIs('servicos.create') ? 'menu-open' : '' }}">

                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-briefcase"></i>
                                <p>
                                    Serviços
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                @can('Criar Serviço')
                                <a href="{{ route('servicos.create') }}"
                                    class="nav-link {{ request()->routeIs('servicos.create') ? 'active' : '' }}">
                                    <i
                                        class="nav-icon bi {{ request()->routeIs('servicos.create') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                    <p>Criar Serviço</p>
                                </a>
                                @endcan
                                </li>
                                <li class="nav-item">
                                    @can('Visualizar Serviço')
                                    <a href="{{ route('servicos.index') }}"
                                        class="nav-link {{ request()->routeIs('servicos.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('servicos.index') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Listar Serviços</p>
                                    </a>
                                    @endcan
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('lancamentos.index') || request()->routeIs('lancamentos.create') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-calendar-event"></i>
                                <p>
                                    Lançamentos
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    @can('Criar Lançamento')
                                    <a href="{{ route('lancamentos.create') }}"
                                        class="nav-link {{ request()->routeIs('lancamentos.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('lancamentos.create') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Criar Lançamento</p>
                                    </a>
                                    @endcan
                                </li>
                                <li class="nav-item">
                                    @can('Visualizar Lançamento')
                                    <a href="{{ route('lancamentos.index') }}"
                                        class="nav-link {{ request()->routeIs('lancamentos.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('lancamentos.index') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Listar Lançamentos</p>
                                    </a>
                                    @endcan
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>

        </aside>
        --}}
        <main class="app-main">
            @yield('content')
        </main>
    </div>
    <style>
        .focus-ring-green:focus {
            border-color: green;
            box-shadow: 0 0 0 0.25rem rgba(0, 128, 0, 0.25);
        }

        .focus-ring-orange:focus {
            border-color: orange;
            box-shadow: 0 0 0 0.25rem rgba(255, 165, 0, 0.25);
        }

        .focus-ring-red:focus {
            border-color: red;
            box-shadow: 0 0 0 0.25rem rgba(255, 0, 0, 0.25);
        }
    </style>
    <style>
        .alert {
            position: fixed;
            top: 110px;
            left: 30%;
            transform: translateX(-50%);
            padding: 1rem;
            margin: 0;
            border: 1px solid transparent;
            border-radius: .20rem;
            z-index: 1050;
        }

        .progress-bar-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: #f1f1f1;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 0%;
            background-color: #28a745;
            transition: width 0.5s linear;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var alert = document.getElementById('alert');
            var progressBar = document.getElementById('progress-bar');

            if (alert && progressBar) {
                var duration = 5000;
                var interval = 10;
                var progress = 0;

                function updateProgressBar() {
                    progress += (interval / duration) * 100;
                    progressBar.style.width = progress + '%';
                    if (progress >= 100) {
                        clearInterval(progressInterval);
                        setTimeout(function () {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }, 500);
                    }
                }
                var progressInterval = setInterval(updateProgressBar, interval);
            }
        });
    </script>

    <script>
        function updateCharacterCount() {
            const textarea = document.getElementById('descricao');
            const charCount = document.getElementById('charCount');
            const maxLength = 520;
            const currentLength = textarea.value.length;

            charCount.textContent = `${currentLength}/${maxLength}`;

            textarea.classList.remove('focus-ring-green', 'focus-ring-orange', 'focus-ring-red');

            if (currentLength < maxLength / 2) {
                textarea.classList.add('focus-ring-green');
            } else if (currentLength < maxLength) {
                textarea.classList.add('focus-ring-orange');
            } else {
                textarea.classList.add('focus-ring-red');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('descricao');
            if (!textarea) {
                return;
            }

            textarea.addEventListener('input', updateCharacterCount);
            updateCharacterCount();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"
        integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>
        @vite('resources/js/adminlte.js')
        @vite('resources/js/menu.js')
            <script>
                const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
                const Default = {
                    scrollbarTheme: "os-theme-light",
                    scrollbarAutoHide: "leave",
                    scrollbarClickScroll: true,
                };
                document.addEventListener("DOMContentLoaded", function () {
                    const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
                    if (
                        sidebarWrapper &&
                        !sidebarWrapper.closest('.admin-sidebar') &&
                        typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
                    ) {
                        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                            scrollbars: {
                                theme: Default.scrollbarTheme,
                                autoHide: Default.scrollbarAutoHide,
                                clickScroll: Default.scrollbarClickScroll,
                            },
                        });
                    }
                });
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelectorAll('.admin-ui-file-native').forEach((input) => {
                        const fileName = input.closest('.admin-ui-file-control')?.querySelector('[data-admin-file-name]');

                        if (!fileName) {
                            return;
                        }

                        input.addEventListener('change', function () {
                            fileName.textContent = this.files?.[0]?.name || 'Nenhum arquivo selecionado';
                        });
                    });
                });
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const portaledMenus = new WeakMap();
                    const portalMenuSelector = '.admin-ui-actions-menu, .admin-topbar-notification-menu';

                    const positionMenu = (toggle, menu) => {
                        const toggleRect = toggle.getBoundingClientRect();
                        const menuRect = menu.getBoundingClientRect();
                        const spacing = 4;
                        const viewportPadding = 16;

                        let left = toggleRect.right - menuRect.width;
                        left = Math.max(viewportPadding, Math.min(left, window.innerWidth - menuRect.width - viewportPadding));

                        let top = toggleRect.bottom + spacing;
                        if (top + menuRect.height > window.innerHeight - viewportPadding) {
                            top = Math.max(viewportPadding, toggleRect.top - menuRect.height - spacing);
                        }

                        menu.style.position = 'fixed';
                        menu.style.left = `${left}px`;
                        menu.style.top = `${top}px`;
                        menu.style.right = 'auto';
                        menu.style.bottom = 'auto';
                        menu.style.transform = 'none';
                    };

                    document.addEventListener('show.bs.dropdown', function (event) {
                        const toggle = event.target;
                        const menu = toggle.parentElement?.querySelector(portalMenuSelector);

                        if (!menu) {
                            return;
                        }

                        const placeholder = document.createComment('admin dropdown menu placeholder');
                        menu.before(placeholder);
                        portaledMenus.set(menu, { placeholder, toggle });

                        document.body.appendChild(menu);
                        menu.classList.add('is-portaled');

                        requestAnimationFrame(() => positionMenu(toggle, menu));
                    });

                    document.addEventListener('shown.bs.dropdown', function (event) {
                        const toggle = event.target;
                        const menu = document.body.querySelector(`${portalMenuSelector}.is-portaled.show`);

                        if (menu) {
                            positionMenu(toggle, menu);
                        }
                    });

                    document.addEventListener('hidden.bs.dropdown', function () {
                        document.querySelectorAll(`${portalMenuSelector}.is-portaled`).forEach((menu) => {
                            const state = portaledMenus.get(menu);

                            menu.classList.remove('is-portaled');
                            menu.removeAttribute('style');

                            if (state?.placeholder?.parentNode) {
                                state.placeholder.replaceWith(menu);
                            }

                            portaledMenus.delete(menu);
                        });
                    });

                    const repositionOpenMenu = () => {
                        document.querySelectorAll(`${portalMenuSelector}.is-portaled.show`).forEach((menu) => {
                            const state = portaledMenus.get(menu);

                            if (state?.toggle) {
                                positionMenu(state.toggle, menu);
                            }
                        });
                    };

                    window.addEventListener('resize', repositionOpenMenu);
                    window.addEventListener('scroll', repositionOpenMenu, true);
                });
            </script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#inputCpf').mask('000.000.000-00', {
                        reverse: true
                    });
                });
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const cancelButton = document.querySelector('#cancel-button');
                    const cropButton = document.getElementById('crop');
                    const imageInput = document.getElementById('inputImagem');
                    const imageTarget = document.getElementById('image');
                    const croppedImageContainer = document.getElementById('croppedImageContainer');
                    const preview = document.getElementById('newImagePreview');

                    if (cancelButton && imageInput) {
                        cancelButton.addEventListener('click', function () {
                            $('#modal').modal('hide');
                            imageInput.value = '';
                        });
                    }

                    if (cropButton && croppedImageContainer) {
                        cropButton.addEventListener('click', function () {
                            croppedImageContainer.style.display = 'block';
                        });
                    }

                    if (imageInput) {
                        imageInput.addEventListener('change', function () {
                            if (this.files.length > 0 && imageTarget) {
                                var file = this.files[0];
                                var done = function (url) {
                                    imageTarget.src = url;
                                    $('#modal').modal('show');
                                };

                                if (URL) {
                                    done(URL.createObjectURL(file));
                                } else if (FileReader) {
                                    var reader = new FileReader();
                                    reader.onload = function (e) {
                                        done(reader.result);
                                    };
                                    reader.readAsDataURL(file);
                                }
                            }
                        });

                        imageInput.addEventListener('change', function (event) {
                            const [file] = event.target.files;
                            if (file && preview) {
                                preview.innerHTML =
                                    `<p class="mt-2"><strong>Nova imagem:</strong></p><img src="${URL.createObjectURL(file)}" width="160px" class="mt-2">`;
                            }
                        });
                    }

                    if (document.querySelector('#inputConteudo') && typeof tinymce !== 'undefined') {
                        tinymce.init({
                            selector: '#inputConteudo',
                            language: 'pt_BR',
                            directionality: 'ltr',
                            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons',
                            plugins: [
                                'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor',
                                'pagebreak',
                                'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen',
                                'insertdatetime',
                                'media', 'table', 'emoticons', 'help'
                            ],
                        });
                    }
                });
            </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const breadcrumbTarget = document.querySelector('[data-admin-header-breadcrumb]');
            const contentHeader = document.querySelector('.app-main .app-content-header');
            const sourceBreadcrumb = contentHeader ? contentHeader.querySelector('.breadcrumb') : null;
            const listBreadcrumbMap = {
                funcoes: {
                    label: 'Cargos',
                    href: "{{ route('funcoes.index') }}",
                },
                permissoes: {
                    label: 'Permissões',
                    href: "{{ route('permissoes.index') }}",
                },
                noticias: {
                    label: 'Notícias',
                    href: "{{ route('noticias.index') }}",
                },
                users: {
                    label: 'Membros',
                    href: "{{ route('users.index') }}",
                },
                parceiros: {
                    label: 'Parceiros',
                    href: "{{ route('parceiros.index') }}",
                },
                galeria: {
                    label: 'Galeria',
                    href: "{{ route('galeria.indexAdmin') }}",
                },
                certificados: {
                    label: 'Certificados',
                    href: "{{ route('certificados.index') }}",
                },
                projetos: {
                    label: 'Projetos',
                    href: "{{ route('projetos.index') }}",
                },
                servicos: {
                    label: 'Serviços',
                    href: "{{ route('servicos.index') }}",
                },
                lancamentos: {
                    label: 'Lançamentos',
                    href: "{{ route('lancamentos.index') }}",
                },
                tags: {
                    label: 'Tags',
                    href: "{{ route('tags.index') }}",
                },
            };

            if (!breadcrumbTarget || !sourceBreadcrumb) {
                return;
            }

            const clonedBreadcrumb = sourceBreadcrumb.cloneNode(true);
            clonedBreadcrumb.classList.remove('float-sm-end');
            clonedBreadcrumb.classList.add('admin-header-breadcrumb');

            const firstItem = clonedBreadcrumb.querySelector('.breadcrumb-item');
            if (firstItem) {
                const homeLink = firstItem.querySelector('a');
                const homeText = homeLink ? homeLink.textContent.trim() : firstItem.textContent.trim();

                if (homeText.toLowerCase() === 'home') {
                    if (homeLink) {
                        homeLink.textContent = 'Início';
                    } else {
                        firstItem.textContent = 'Início';
                    }
                }

                if (!firstItem.querySelector('.bi-house-door')) {
                    const homeIcon = document.createElement('i');
                    homeIcon.className = 'bi bi-house-door';
                    homeIcon.setAttribute('aria-hidden', 'true');
                    firstItem.prepend(homeIcon);
                }
            }

            const breadcrumbItems = Array.from(clonedBreadcrumb.querySelectorAll('.breadcrumb-item'));
            const activeItem = breadcrumbItems.at(-1);
            const activeLabel = activeItem ? activeItem.textContent.trim().toLowerCase() : '';
            const pathSegments = window.location.pathname.split('/').filter(Boolean);
            const resourceKey = pathSegments[1];
            const shouldInjectListItem = breadcrumbItems.length === 2
                && activeItem
                && resourceKey
                && listBreadcrumbMap[resourceKey]
                && /^(novo|nova|criar|editar)\b/.test(activeLabel);

            if (shouldInjectListItem) {
                const listItem = document.createElement('li');
                listItem.className = 'breadcrumb-item';

                const listLink = document.createElement('a');
                listLink.href = listBreadcrumbMap[resourceKey].href;
                listLink.textContent = listBreadcrumbMap[resourceKey].label;

                listItem.appendChild(listLink);
                activeItem.before(listItem);
            }

            breadcrumbTarget.replaceChildren(clonedBreadcrumb);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const breadcrumbTarget = document.querySelector('[data-admin-header-breadcrumb]');
            const pathSegments = window.location.pathname.split('/').filter(Boolean);
            const actionSegment = pathSegments.at(-1);
            const isCreatePage = actionSegment === 'create';
            const isEditPage = actionSegment === 'edit' || actionSegment === 'editar';
            const adminHomePath = "{{ route('admin', [], false) }}";
            const pageHeading = document.querySelector('.app-content-header h1, .app-content-header h2, .app-content-header h3, .app-main h1, .app-main h2, .app-main h3');
            const fallbackLabel = pageHeading ? pageHeading.textContent.trim() : '';
            const breadcrumbMap = {
                funcoes: {
                    listLabel: 'Cargos',
                    href: "{{ route('funcoes.index') }}",
                    createLabel: 'Novo Cargo',
                    editLabel: 'Editar Função',
                },
                permissoes: {
                    listLabel: 'Permissões',
                    href: "{{ route('permissoes.index') }}",
                    createLabel: 'Nova permissão',
                    editLabel: 'Editar permissão',
                },
                noticias: {
                    listLabel: 'Notícias',
                    href: "{{ route('noticias.index') }}",
                    createLabel: 'Nova notícia',
                    editLabel: 'Editar notícia',
                },
                users: {
                    listLabel: 'Membros',
                    href: "{{ route('users.index') }}",
                    createLabel: 'Novo Membro',
                    editLabel: 'Editar Membro',
                },
                parceiros: {
                    listLabel: 'Parceiros',
                    href: "{{ route('parceiros.index') }}",
                    createLabel: 'Novo Parceiro',
                    editLabel: 'Editar Parceiro',
                },
                galeria: {
                    listLabel: 'Galeria',
                    href: "{{ route('galeria.indexAdmin') }}",
                    createLabel: 'Nova Mídia',
                    editLabel: 'Editar Galeria',
                },
                certificados: {
                    listLabel: 'Certificados',
                    href: "{{ route('certificados.index') }}",
                    createLabel: 'Novo certificado',
                    editLabel: 'Editar certificado',
                },
                projetos: {
                    listLabel: 'Projetos',
                    href: "{{ route('projetos.index') }}",
                    createLabel: 'Novo Projeto',
                    editLabel: 'Editar Projeto',
                },
                servicos: {
                    listLabel: 'Serviços',
                    href: "{{ route('servicos.index') }}",
                    createLabel: 'Novo Serviço',
                    editLabel: 'Editar Serviço',
                },
                lancamentos: {
                    listLabel: 'Lançamentos',
                    href: "{{ route('lancamentos.index') }}",
                    createLabel: 'Novo Lançamento',
                    editLabel: 'Editar Lançamento',
                },
                tags: {
                    listLabel: 'Tags',
                    href: "{{ route('tags.index') }}",
                    createLabel: 'Nova tag',
                    editLabel: 'Editar tag',
                },
            };
            const resourceKey = [...pathSegments].reverse().find((segment) => Object.prototype.hasOwnProperty.call(breadcrumbMap, segment));
            const resourceConfig = resourceKey ? breadcrumbMap[resourceKey] : null;

            if (!breadcrumbTarget) {
                return;
            }

            const ensureHomeItem = (item) => {
                if (!item) {
                    return;
                }

                const homeLink = item.querySelector('a');
                if (homeLink) {
                    homeLink.textContent = 'Início';
                } else {
                    item.textContent = 'Início';
                }

                if (!item.querySelector('.bi-house-door')) {
                    const homeIcon = document.createElement('i');
                    homeIcon.className = 'bi bi-house-door';
                    homeIcon.setAttribute('aria-hidden', 'true');
                    item.prepend(homeIcon);
                }
            };

            let breadcrumb = breadcrumbTarget.querySelector('.breadcrumb');

            if (!breadcrumb && window.location.pathname === adminHomePath) {
                breadcrumb = document.createElement('ol');
                breadcrumb.className = 'breadcrumb admin-header-breadcrumb';

                const homeItem = document.createElement('li');
                homeItem.className = 'breadcrumb-item active';
                homeItem.setAttribute('aria-current', 'page');
                breadcrumb.appendChild(homeItem);

                ensureHomeItem(homeItem);
                breadcrumbTarget.replaceChildren(breadcrumb);
                return;
            }

            if (!breadcrumb) {
                breadcrumb = document.createElement('ol');
                breadcrumb.className = 'breadcrumb admin-header-breadcrumb';
                breadcrumbTarget.replaceChildren(breadcrumb);
            }

            let breadcrumbItems = Array.from(breadcrumb.querySelectorAll('.breadcrumb-item'));

            if (breadcrumbItems.length === 0) {
                const homeItem = document.createElement('li');
                homeItem.className = 'breadcrumb-item';

                const homeLink = document.createElement('a');
                homeLink.href = adminHomePath;
                homeItem.appendChild(homeLink);

                const activeItem = document.createElement('li');
                activeItem.className = 'breadcrumb-item active';
                activeItem.setAttribute('aria-current', 'page');

                breadcrumb.append(homeItem, activeItem);
                breadcrumbItems = [homeItem, activeItem];
            }

            const firstItem = breadcrumbItems[0];
            const activeItem = breadcrumbItems.at(-1);

            ensureHomeItem(firstItem);

            if (resourceConfig && activeItem) {
                const isListPage = breadcrumbItems.length === 2 && !isCreatePage && !isEditPage;

                if ((isCreatePage || isEditPage) && breadcrumbItems.length === 2) {
                    const existingListItem = breadcrumbItems.find((item, index) => index > 0 && item !== activeItem);

                    if (!existingListItem) {
                        const listItem = document.createElement('li');
                        listItem.className = 'breadcrumb-item';

                        const listLink = document.createElement('a');
                        listLink.href = resourceConfig.href;
                        listLink.textContent = resourceConfig.listLabel;

                        listItem.appendChild(listLink);
                        activeItem.before(listItem);
                    }
                }

                if (isCreatePage && resourceConfig.createLabel) {
                    activeItem.textContent = resourceConfig.createLabel;
                } else if (isEditPage && resourceConfig.editLabel) {
                    activeItem.textContent = resourceConfig.editLabel;
                } else if (isListPage && resourceConfig.listLabel) {
                    activeItem.textContent = resourceConfig.listLabel;
                }
            }

            if (activeItem && !activeItem.textContent.trim()) {
                activeItem.textContent = fallbackLabel || 'Início';
            }

            const normalizedItems = Array.from(breadcrumb.querySelectorAll('.breadcrumb-item'));
            if (normalizedItems.length >= 3) {
                const secondItem = normalizedItems[1];
                const secondLabel = secondItem ? secondItem.textContent.trim() : '';

                if (resourceKey === 'galeria' && secondLabel === 'Galeria - Lista') {
                    const secondLink = secondItem.querySelector('a');
                    if (secondLink) {
                        secondLink.textContent = 'Galeria';
                    } else {
                        secondItem.textContent = 'Galeria';
                    }
                }
            }
        });
    </script>
    <script>
        window.addEventListener('load', function() {
            document.body.classList.add('loaded', 'app-loaded');

            const loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) {
                loadingScreen.style.display = 'none';
            }
        });
    </script>
</body>

</html>
