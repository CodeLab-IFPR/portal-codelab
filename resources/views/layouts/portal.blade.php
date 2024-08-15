<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <link rel="apple-touch-icon" sizes="180x180" src="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" src="{{ asset('img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" src="{{ asset('img/favicon/favicon-16x16.png') }}">
    <link rel="mask-icon" src="{{ asset('img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    
    @vite('resources/css/libs.bundle.css')    
    @vite('resources/css/theme.bundle.css')
    <noscript>
        <style>
          .simplebar-content-wrapper {
            overflow: auto;
          }
        </style>
    </noscript>
    <title>@yield('title')</title>
    
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white ">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center lh-1 me-10 transition-opacity opacity-75-hover" href="{{ route('home') }}">
                <span class="f-w-7 d-block text-success me-2">
                    <svg class="w-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 246.46 258.91"><path d="M145.61,187.72,22.41,116.58,0,129.52l50.45,29.13L0,187.77l22.41,12.94s90.75,52.38,100.82,58.2l123.23-71.13L44.7,71.2l78.54-45.34,78.4,45.26-28,16.2-50.31-29L100.85,71.2l123.21,71.13,22.4-12.94L196,100.25q25.25-14.55,50.46-29.12L123.23,0,0,71.13,201.77,187.71l-78.52,45.41L44.8,187.78l28.06-16.19,50.34,29.07Z" fill="currentColor" fill-rule="evenodd"/></svg>
                </span>
                <span class="fw-bold text-body">Sigma</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ri-menu-line"></i>
            </button>    
            <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown position-static">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Features
                        </a>
                        <div class="dropdown-menu dropdown-megamenu">
                            <div class="container">
                                <div class="row py-lg-5 gx-8">
                                    <div class="col-auto me-4 mb-4 me-lg-0 mb-lg-0 col-lg-4 d-flex align-items-start">
                                        <span class="f-w-16 d-block text-primary me-4 d-none d-lg-flex">
                                            <svg class="w-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline opacity=".4" points="2 12 12 17 22 12"></polyline></svg>
                                        </span>
                                        <div class="position-relative">
                                            <h6 class="dropdown-heading">Tasks planner</h6>
                                            <p class="text-muted">Plan and schedule your weekly tasks on web or mobile through our desktop or mobile apps.</p>
                                            <a href="#" class="fw-medium fs-7 text-decoration-none link-cover">Read more &rarr;</a>
                                        </div>
                                    </div>
                                    <div class="col-auto me-4 mb-4 me-lg-0 mb-lg-0 col-lg-4 d-flex align-items-start">
                                        <span class="f-w-16 d-block text-primary me-4 d-none d-lg-flex">
                                            <svg class="w-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect opacity=".3" x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                        </span>
                                        <div class="position-relative">
                                            <h6 class="dropdown-heading">Team collaborations</h6>
                                            <p class="text-muted">Invite unlimited team members to view, edit, comment and create landing pages with you.</p>
                                            <a href="#" class="fw-medium fs-7 text-decoration-none link-cover">Read more &rarr;</a>
                                        </div>
                                    </div>
                                    <div class="col-auto me-4 mb-4 me-lg-0 mb-lg-0 col-lg-4 d-flex align-items-start">
                                        <span class="f-w-16 d-block text-primary me-4 d-none d-lg-flex">
                                            <svg class="w-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path opacity=".4" d="M13 6h3a2 2 0 0 1 2 2v7"></path><line opacity=".4" x1="6" y1="9" x2="6" y2="21"></line></svg>
                                        </span>
                                        <div class="position-relative">
                                            <h6 class="dropdown-heading">Version control</h6>
                                            <p class="text-muted">Full integration with Git, GitLab and Bitbucket to easily allow version control.</p>
                                            <a href="#" class="fw-medium fs-7 text-decoration-none link-cover">Read more &rarr;</a>
                                        </div>
                                    </div>                                
                                </div>
                                <div class="mt-4 border-top d-none d-lg-flex flex-column py-5">
                                    <p class="text-muted">From the blog</p>
                                    <a href="#">The ultimate guide to event project management &rarr;</a>
                                    <a href="#">How to use Agile to implememt Scrum method &rarr;</a>
                                    <a href="#">What is the best software version control? &rarr;</a>
                                </div>
                            </div>
                        </div>
                    </li>    
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('noticias.index')}}">Notícias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>            <div class="d-none d-lg-flex">
                    <a href="{{ route('login') }}" class="btn btn-link text-muted" role="button">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary ms-2" role="button">Registre-se</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="mt-0 ">
        @yield('content')
    </main>
    <footer class="bg-dark pt-10 pb-8">
        <div class="container">
    
            <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-center">
    
                <a class="d-flex align-items-center lh-1 text-white transition-opacity opacity-50-hover text-decoration-none mb-4 mb-md-0"
                    href="#">
                    <span class="f-w-7 d-block text-success me-2">
                        <svg class="w-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 246.46 258.91"><path d="M145.61,187.72,22.41,116.58,0,129.52l50.45,29.13L0,187.77l22.41,12.94s90.75,52.38,100.82,58.2l123.23-71.13L44.7,71.2l78.54-45.34,78.4,45.26-28,16.2-50.31-29L100.85,71.2l123.21,71.13,22.4-12.94L196,100.25q25.25-14.55,50.46-29.12L123.23,0,0,71.13,201.77,187.71l-78.52,45.41L44.8,187.78l28.06-16.19,50.34,29.07Z" fill="currentColor" fill-rule="evenodd"/></svg>
                    </span>
                    <span class="fw-bold">Sigma</span>
                </a>    
                <ul class="list-unstyled d-flex align-items-center justify-content-end">
                    <li class="ms-5"><a href="#" class="text-white text-decoration-none opacity-50-hover transition-opacity"><i class="ri-facebook-circle-line ri-lg"></i></a></li>
                    <li class="ms-5"><a href="#" class="text-white text-decoration-none opacity-50-hover transition-opacity"><i class="ri-twitter-line ri-lg"></i></a></li>
                    <li class="ms-5"><a href="#" class="text-white text-decoration-none opacity-50-hover transition-opacity"><i class="ri-instagram-line ri-lg"></i></a></li>
                    <li class="ms-5"><a href="#" class="text-white text-decoration-none opacity-50-hover transition-opacity"><i class="ri-snapchat-line ri-lg"></i></a></li>
                </ul>
            </div>
            <div class="d-flex flex-wrap justify-content-between mt-5 mt-lg-7">    
                <div class="w-100 w-sm-50 w-lg-auto mb-4 mb-lg-0">
                    <h6 class="text-uppercase fs-xs fw-bolder tracking-wider text-white opacity-50">Portal</h6>
                    <ul class="list-unstyled footer-nav">
                        <li><a href="{{ route('about') }}">Sobre Nós</a></li>
                        <li><a href="#">Junte-se</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Ultimas Noticias</a></li>
                    </ul>
                </div>
                <div class="w-100 w-sm-50 w-lg-auto mb-4 mb-lg-0">
                    <h6 class="text-uppercase fs-xs fw-bolder tracking-wider text-white opacity-50">Navegação</h6>
                    <ul class="list-unstyled footer-nav">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Registre-se</a></li>
                        <li><a href="#">Ajuda & Suporte</a></li>
                        <li><a href="{{ route('contact') }}">Contato</a></li>
                        <li><a href="#">Esqueceu a senha?</a></li>
                    </ul>
                </div>
                <div class="w-100 w-sm-50 w-lg-auto mb-4 mb-lg-0">
                    <h6 class="text-uppercase fs-xs fw-bolder tracking-wider text-white opacity-50">Legals</h6>
                    <ul class="list-unstyled footer-nav">
                        <li><a href="#">Política de Privacidade</a></li>
                        <li><a href="#">Termos & Condições</a></li>
                        <li><a href="#">LGPD</a></li>
                        <li><a href="#">IFPR</a></li>
                    </ul>
                </div>    
            </div>
        </div>
        <div class="container">
            <div class="border-top pt-6 mt-7 border-white-10 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <span class="small text-white opacity-50 mb-2 mb-md-0">All rights reserved &copy Sigma 2021</span>
                <span class="small text-white opacity-50">Termos de Serviço  |  Política de Segurança</span>
            </div>
        </div>    
    </footer>
    <div class="modal fade modal-video" id="videoIframeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <button type="button"
                            class="btn btn-link text-decoration-none text-white opacity-75-hover transition-all position-absolute end-0 top-0 z-index-20"
                            data-bs-dismiss="modal" aria-label="Close"><i class="ri-close-fill"></i></button>
                        <div id="player" class="modal-video-player plyr__video-embed">
                            <iframe src="" allowfullscreen allowtransparency allow="autoplay"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @vite('resources/js/vendor.bundle.js')
        @vite('resources/js/theme.bundle.js')
</body>
</html>
