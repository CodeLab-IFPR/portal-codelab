@extends('layouts.portal')

<!-- Titulo -->
@section('title')
Contate Nos
@endsection
<!-- Titulo -->

@section('content')
<header class="pt-10">
    <div class="container">
        <div class="text-center col-12 col-sm-9 col-lg-7 col-xl-6 mx-auto position-relative z-index-20">
            <h1 class="display-3 fw-bold mb-3">Entre em contato</h1>
            <p class="text-muted lead mb-0">Selecione uma categoria abaixo para enviar um e-mail para a equipe de suporte correta, ou, alternativamente, envie-nos uma mensagem geral usando o formulário abaixo.</p>
        </div>
    </div>
</header>
<div class="container position-relative z-index-20 py-7">
    <div class="row g-5">
        <div class="col-12 col-lg-4">
            <div class="card rounded shadow-lg h-100">
                <div class="card-body d-flex align-items-center flex-column justify-content-center text-center p-5">
                    <span class="f-w-10 d-block text-primary">
                        <svg class="w-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                            <polyline points="2 17 12 22 22 17"></polyline>
                            <polyline opacity=".4" points="2 12 12 17 22 12"></polyline>
                        </svg>
                    </span>
                    <p class="fw-medium mb-1 my-4 fs-5">Base de conhecimento</p>
                    <span class="text-muted fs-7 mb-4">Navegue pelos nossos recursos ou envie um ticket para a nossa equipe de suporte.</span>
                    <a href="#" class="fw-bolder">Visitar centro de ajuda &rarr;</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card rounded shadow-lg h-100">
                <div class="card-body d-flex align-items-center flex-column justify-content-center text-center p-5">
                    <span class="f-w-10 d-block text-primary">
                        <svg class="w-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path opacity=".4" d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path opacity=".4" d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </span>
                    <p class="fw-medium mb-1 my-4 fs-5">Contato de vendas</p>
                    <span class="text-muted fs-7 mb-4">Pergunte sobre um plano de preços personalizado, nossos produtos empresariais ou solicite uma demonstração.</span>
                    <a href="#" class="fw-bolder">Contatar vendas &rarr;</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card rounded shadow-lg h-100">
                <div class="card-body d-flex align-items-center flex-column justify-content-center text-center p-5">
                    <span class="f-w-12 d-block text-primary">
                        <svg class="w-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="18" cy="18" r="3"></circle>
                            <circle cx="6" cy="6" r="3"></circle>
                            <path opacity=".4" d="M13 6h3a2 2 0 0 1 2 2v7"></path>
                            <line opacity=".4" x1="6" y1="9" x2="6" y2="21"></line>
                        </svg>
                    </span>
                    <p class="fw-medium mb-1 my-4 fs-5">Suporte técnico</p>
                    <span class="text-muted fs-7 mb-4">Precisa de ajuda com nossa API ou assistência para usar nossa ferramenta de design de página de destino?</span>
                    <a href="#" class="fw-bolder">Contatar suporte &rarr;</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row gx-10 my-10 pt-5">
        <div class="col-12 col-lg-8">
            <p class="mb-3 small fw-bolder tracking-wider text-uppercase text-primary">Entre em contato</p>
            <h2 class="display-5 fw-bold mb-6">Envie-nos uma mensagem</h2>
            <form>
                <div class="row g-5">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="name" placeholder="Faustão">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="xuxa@rainhadosexos.com.br">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Compania</label>
                        <input type="text" class="form-control" name="company" placeholder="Globo">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Telefone</label>
                        <input type="text" class="form-control" name="telephone" placeholder="+55 (11) 9-9999-9999">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mensagem</label>
                        <textarea name="about" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    <div class="col-12 justify-content-end d-flex">
                        <button class="btn btn-primary" type="submit">Enviar mensagem</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-lg-4 mt-5 mt-lg-0">
            <div class="mb-5">
            <p class="mb-4 small fw-bolder tracking-wider text-uppercase text-primary">Nos encontre online</p>
            <ul class="list-unstyled">
            <li class="d-flex align-items-center mb-2"><i class="ri-github-line me-3 ri-lg"></i> <a
                class="text-muted" href="#">Github</a></li>
            <li class="d-flex align-items-center mb-2"><i class="ri-facebook-line me-3 ri-lg"></i> <a
                class="text-muted" href="#">Facebook</a></li>
            <li class="d-flex align-items-center mb-2"><i class="ri-twitter-line me-3 ri-lg"></i> <a
                class="text-muted" href="#">Twitter</a></li>
            <li class="d-flex align-items-center mb-2"><i class="ri-codepen-line me-3 ri-lg"></i> <a
                class="text-muted" href="#">Codepen</a></li>
            </ul>
            </div>
            <p class="mb-4 small fw-bolder tracking-wider text-uppercase text-primary">Nosso escritório principal</p>
            <p>Av. José Felipe Tequinha, 1400 - Jardim das Nacoes, Paranavaí - PR</p>
        </div>
        </div>
    </div>
</div>
@endsection