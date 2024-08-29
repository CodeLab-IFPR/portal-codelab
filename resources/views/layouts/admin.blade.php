<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE v4 | Dashboard">
    <meta name="author" content="ColorlibHQ">
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
    <script src="https://cdn.tiny.cloud/1/no-key/tinymce/7/tinymce.min.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
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
                    <li class="nav-item"> <a class="nav-link" data-widget="navbar-search" href="#" role="button"> <i
                                class="bi bi-search"></i> </a> </li>
                    <li class="nav-item dropdown"> <a class="nav-link" data-bs-toggle="dropdown" href="#"> <i
                                class="bi bi-chat-text"></i> <span class="navbar-badge badge text-bg-danger">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <a href="#"
                                class="dropdown-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0"> <img
                                            src="{{ asset('/img/user1-128x128.jpg') }}"
                                            alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                                    <div class="flex-grow-1">
                                        <h3 class="dropdown-item-title">
                                            Brad Diesel
                                            <span class="float-end fs-7 text-danger"><i
                                                    class="bi bi-star-fill"></i></span>
                                        </h3>
                                        <p class="fs-7">Call me whenever you can...</p>
                                        <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours
                                            Ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0"> <img
                                            src="{{ asset('/img/user8-128x128.jpg') }}"
                                            alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                                    <div class="flex-grow-1">
                                        <h3 class="dropdown-item-title">
                                            John Pierce
                                            <span class="float-end fs-7 text-secondary"> <i class="bi bi-star-fill"></i>
                                            </span>
                                        </h3>
                                        <p class="fs-7">I got your message bro</p>
                                        <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours
                                            Ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0"> <img
                                            src="{{ asset('/img/user3-128x128.jpg') }}"
                                            alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                                    <div class="flex-grow-1">
                                        <h3 class="dropdown-item-title">
                                            Nora Silvester
                                            <span class="float-end fs-7 text-warning"> <i class="bi bi-star-fill"></i>
                                            </span>
                                        </h3>
                                        <p class="fs-7">The subject goes here</p>
                                        <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours
                                            Ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item dropdown-footer">See
                                All Messages</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown"> <a class="nav-link" data-bs-toggle="dropdown" href="#"> <i
                                class="bi bi-bell-fill"></i> <span class="navbar-badge badge text-bg-warning">15</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <span
                                class="dropdown-item dropdown-header">15 Notifications</span>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i
                                    class="bi bi-envelope me-2"></i> 4 new messages
                                <span class="float-end text-secondary fs-7">3 mins</span> </a>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i
                                    class="bi bi-people-fill me-2"></i> 8 friend requests
                                <span class="float-end text-secondary fs-7">12 hours</span> </a>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i
                                    class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                                <span class="float-end text-secondary fs-7">2 days</span> </a>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item dropdown-footer">
                                See All Notifications
                            </a>
                        </div>
                    </li>
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
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

            <!-- Cadastro Section -->
            <li class="nav-item {{ request()->routeIs('noticias.create') || request()->routeIs('membros.create') || request()->routeIs('parceiros.create') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link"> 
                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>
                        Cadastro
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('noticias.create') }}" class="nav-link {{ request()->routeIs('noticias.create') ? 'active' : '' }}">
                            <i class="nav-icon bi {{ request()->routeIs('noticias.create') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                            <p>Nova Notícia</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('membros.create') }}" class="nav-link {{ request()->routeIs('membros.create') ? 'active' : '' }}">
                            <i class="nav-icon bi {{ request()->routeIs('membros.create') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                            <p>Novo Membro</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('parceiros.create') }}" class="nav-link {{ request()->routeIs('parceiros.create') ? 'active' : '' }}">
                            <i class="nav-icon bi {{ request()->routeIs('parceiros.create') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                            <p>Novo Parceiro</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Lista Section -->
            <li class="nav-item {{ request()->routeIs('membros.index') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-box-seam-fill"></i>
                    <p>
                        Lista
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Notícia</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('membros.index') }}" class="nav-link {{ request()->routeIs('membros.index') ? 'active' : '' }}">
                            <i class="nav-icon bi {{ request()->routeIs('membros.index') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                            <p>Membro</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Parceiro</p>
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
                    typeof OverlayScrollbarsGlobal ? .OverlayScrollbars !== "undefined"
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

            const cardHeaders = document.querySelectorAll(
                ".connectedSortable .card-header",
            );
            cardHeaders.forEach((cardHeader) => {
                cardHeader.style.cursor = "move";
            });
        </script>
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
</body>

</html>