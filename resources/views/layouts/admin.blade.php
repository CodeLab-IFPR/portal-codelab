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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css"
        integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
        integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"
        integrity="sha384-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <script src="https://cdn.tiny.cloud/1/i6174a4p21k3bvgofjdjglzvdfxrle8qza1n62srherxw93i/tinymce/7/tinymce.min.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://cdn.tiny.cloud/1/7zo9iyuj1gb1fyw0uccbyarr0akkym7ki4hkoeb6tfq12zg5/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    @vite('resources/css/adminlte.css"')
        <script>
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
        </script>

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i
                                class="bi bi-list"></i> </a> </li>
                    <li class="nav-item d-none d-md-block"> <a href="{{ route('home') }}"
                            class="nav-link">Home</a> </li>
                    <li class="nav-item d-none d-md-block"> <a href="{{ route('contact') }}"
                            class="nav-link">Contato</a> </li>
                </ul>
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i
                                data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i
                                data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a>
                    </li>
                    <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown"> <img
                                src="{{ asset('/img/user2-160x160.jpg') }}"
                                class="user-image rounded-circle shadow" alt="User Image"> <span
                                class="d-none d-md-inline">Alexander Pierce</span> </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <li class="user-header text-bg-primary"> <img
                                    src="{{ asset('/img/user2-160x160.jpg') }}"
                                    class="rounded-circle shadow" alt="User Image">
                                <p>
                                    Alexander Pierce - Web Developer
                                    <small>Member since Nov. 2023</small>
                                </p>
                            </li>
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-4 text-center"> <a href="#">Followers</a> </div>
                                    <div class="col-4 text-center"> <a href="#">Sales</a> </div>
                                    <div class="col-4 text-center"> <a href="#">Friends</a> </div>
                                </div>
                            </li>
                            <li class="user-footer"> <a href="#" class="btn btn-default btn-flat">Profile</a> <a
                                    href="#" class="btn btn-default btn-flat float-end">Sign out</a> </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
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
                            class="nav-item {{ request()->routeIs('noticias.create') || request()->routeIs('users.create') || request()->routeIs('parceiros.create') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-journal-plus"></i>
                                <p>
                                    Cadastro
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('noticias.create') }}"
                                        class="nav-link {{ request()->routeIs('noticias.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('noticias.create') ? 'bi-play-fill' : 'bi-play' }}"></i>
                                        <p>Nova Notícia</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('users.create') }}"
                                        class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('users.create') ? 'bi-play-fill' : 'bi-play' }}"></i>
                                        <p>Novo User</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('parceiros.create') }}"
                                        class="nav-link {{ request()->routeIs('parceiros.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('parceiros.create') ? 'bi-play-fill' : 'bi-play' }}"></i>
                                        <p>Novo Parceiro</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="nav-item {{ request()->routeIs('users.index') || request()->routeIs('parceiros.index') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-journal-text"></i>
                                <p>
                                    Lista
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('noticias.index') }}"
                                        class="nav-link {{ request()->routeIs('noticias.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('users.index') ? 'bi-play-fill' : 'bi-play' }}"></i>
                                        <p>Noticias</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}"
                                        class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('users.index') ? 'bi-play-fill' : 'bi-play' }}"></i>
                                        <p>User</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('parceiros.index') }}"
                                        class="nav-link {{ request()->routeIs('parceiros.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('parceiros.index') ? 'bi-play-fill' : 'bi-play' }} "></i>
                                        <p>Parceiro</p>
                                    </a>
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
                                    <a href="{{ route('certificados.create') }}"
                                        class="nav-link {{ request()->routeIs('certificados.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('certificados.create') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Novo Certificado</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('certificados.index') }}"
                                        class="nav-link {{ request()->routeIs('certificados.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('certificados.index') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Todos Certificados</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('certificados.index') || request()->routeIs('certificados.create') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-award"></i>
                                <p>
                                    Projeto
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('projetos.create') }}"
                                        class="nav-link {{ request()->routeIs('projetos.create') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('projetos.create') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Novo Projeto</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('projetos.index') }}"
                                        class="nav-link {{ request()->routeIs('projetos.index') ? 'active' : '' }}">
                                        <i
                                            class="nav-icon bi {{ request()->routeIs('projetos.index') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                        <p>Todos Projetos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>

        </aside>
        <main class="app-main">
            @yield('content')
        </main>
        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">Anything you want</div><strong>
                Copyright &copy; 2014-2024&nbsp;
                <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
            </strong>
            All rights reserved.
        </footer>
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
                    if (sidebarWrapper && typeof OverlayScrollbarsGlobal ? .OverlayScrollbars !== "undefined") {
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
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
                integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ=" crossorigin="anonymous"></script>
            <!-- sortablejs -->
            <script>
                const connectedSortables =
                    document.querySelectorAll(".connectedSortable");
                connectedSortables.forEach((connectedSortable) => {
                    let sortable = new Sortable(connectedSortable, {
                        group: "shared",
                        handle: ".card-header",
                    });
                });

                <
                script >
                    const cardHeaders = document.querySelectorAll(
                        ".connectedSortable .card-header",
                    );
                cardHeaders.forEach((cardHeader) => {
                    cardHeader.style.cursor = "move";
                });
            </script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
                integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
                integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y=" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
                integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY=" crossorigin="anonymous"></script>
            <script>
                $('#conteudo').summernote({
                    placeholder: 'Hello stand alone ui',
                    tabsize: 2,
                    height: 120,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#inputCpf').mask('000.000.000-00', {
                        reverse: true
                    });
                });
            </script>
            <script>
                document.querySelector('#cancel-button').addEventListener('click', function () {
                    $('#modal').modal('hide');
                    document.querySelector('#inputImagem').value = '';
                });
            </script>
            <script>
                document.getElementById('crop').addEventListener('click', function () {
                    document.getElementById('croppedImageContainer').style.display = 'block';
                });
            </script>
            <script>
                document.getElementById('inputImagem').addEventListener('change', function () {
                    if (this.files.length > 0) {
                        var file = this.files[0];
                        var done = function (url) {
                            document.getElementById('image').src = url;
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
            </script>

            <script>
                document.getElementById('inputImagem').addEventListener('change', function (event) {
                    const [file] = event.target.files;
                    if (file) {
                        const preview = document.getElementById('newImagePreview');
                        preview.innerHTML =
                            `<p class="mt-2"><strong>Nova imagem:</strong></p><img src="${URL.createObjectURL(file)}" width="160px" class="mt-2">`;
                    }
                });
            </script>

            <script>
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
            </script>
</body>

</html>
