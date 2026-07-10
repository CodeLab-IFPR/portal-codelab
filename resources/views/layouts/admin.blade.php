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
                <div class="admin-topbar-breadcrumb">
                    @hasSection('breadcrumb')
                        @yield('breadcrumb')
                    @else
                        <x-admin.breadcrumb />
                    @endif
                </div>
            </div>
        </nav>
        @include('layouts.partials.admin-sidebar')
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
