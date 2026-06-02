@extends('layouts.portal')

<!-- Titulo -->
@section('title')
Contate Nos
@endsection
<!-- Titulo -->

@section('content')
<!-- <header class="pt-10">
    <div class="container">
        <div class="text-center col-12 col-sm-9 col-lg-7 col-xl-6 mx-auto position-relative z-index-20">
            <h1 class="display-3 fw-bold mb-3">Entre em contato</h1>
            <p class="text-muted lead mb-0">Selecione uma categoria abaixo para enviar um e-mail para a equipe de suporte correta, ou, alternativamente, envie-nos uma mensagem geral usando o formulário abaixo.</p>
        </div>
    </div>
</header> -->
<div class="container position-relative z-index-20 py-0">
    <div class="row gx-10 mb-10 pt-5">
        <div class="col-12 col-lg-8">
            <p class="mb-3 small fw-bolder tracking-wider text-uppercase text-primary">Entre em contato</p>
            <h2 class="display-5 fw-bold mb-6">Envie-nos uma mensagem</h2>
            <form id="contactForm" method="POST" action="{{ route('send-message') }}" aria-labelledby="formTitle">
                @csrf
                <div class="row g-5">
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name">Nome</label>
                        <input type="text" class="form-control rounded" id="name" name="name" placeholder="Seu nome" value="{{ old('name') }}" required aria-required="true">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="email">E-mail</label>
                        <input type="email" class="form-control rounded" id="email" name="email" placeholder="email@email.com.br" value="{{ old('email') }}" required aria-required="true">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="telephone">Celular</label>
                        <input type="text" class="form-control rounded" id="telephone" name="telephone" placeholder="(99) 9-9999-9999" value="{{ old('telephone') }}" required aria-required="true">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="message">Mensagem</label>
                        <textarea name="message" id="message" class="form-control rounded" style="resize: none; height: 150px;" placeholder="Sua mensagem..." required aria-required="true">{{ old('message') }}</textarea>
                    </div>
                    <div class="col-12" style="position:absolute; left:-10000px; top:auto; width:1px; height:1px; overflow:hidden;" aria-hidden="true">
                        <label class="form-label" for="website">Website</label>
                        <input type="text" class="form-control rounded" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    <input type="hidden" id="contactRecaptchaToken" name="g-recaptcha-response">

                    <div class="col-12 justify-content-end d-flex">
                        @error('form')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                        @error('g-recaptcha-response')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                        <button class="btn btn-primary rounded" type="submit">Enviar mensagem</button>
                    </div>

                </div>
            </form>
        </div>
        <div class="col-12 col-lg-4 mt-5 mt-lg-0">
            <div class="mb-5">
                <p class="mb-4 small fw-bolder tracking-wider text-uppercase text-primary">Nos encontre online</p>
                <ul class="list-unstyled">
                    <li class="d-flex align-items-center mb-2"><i class="ri-github-line me-3 ri-lg"></i> <a class="text-muted" href="{{ \App\Models\FraseInicio::getParametro(PARAM_NOS_ENCONTRE_ONLINE)}}" target="_blank">GitHub</a></li>
                </ul>
            </div>
            <p class="mb-4 small fw-bolder tracking-wider text-uppercase text-primary">Nosso endereço</p>
            <p>{{ \App\Models\FraseInicio::getParametro(PARAM_ENDERECO) ?? '' }}</p>
        </div>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render={{ env('NOCAPTCHA_SITEKEY') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var contactForm = document.getElementById('contactForm');
        var contactRecaptchaToken = document.getElementById('contactRecaptchaToken');
        var recaptchaSiteKey = "{{ env('NOCAPTCHA_SITEKEY') }}";
        var submitting = false;
        var telephoneInput = document.getElementById('telephone');
        telephoneInput.addEventListener('input', function (e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,1})(\d{0,4})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '') + (x[4] ? '-' + x[4] : '');
        });

        contactForm.addEventListener('submit', function (event) {
            if (submitting || typeof grecaptcha === 'undefined' || !recaptchaSiteKey) {
                return;
            }

            event.preventDefault();
            grecaptcha.ready(function () {
                grecaptcha.execute(recaptchaSiteKey, { action: 'contact' }).then(function (token) {
                    contactRecaptchaToken.value = token;
                    submitting = true;
                    contactForm.submit();
                });
            });
        });
    });
</script>
@endsection