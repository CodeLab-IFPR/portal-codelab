@extends('layouts.admin')

@section('title')
Novo Membro
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Novo Membro</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Novo Membro</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="admin-ui-page admin-ui-page-narrow">
    <div class="admin-ui-intro">
        <div class="admin-ui-intro-copy">
            <h1 class="admin-ui-title">Novo Membro</h1>
        </div>
        <a href="{{ route('users.index') }}" class="admin-ui-btn admin-ui-btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span class="admin-ui-mobile-hide">Voltar</span>
        </a>
    </div>

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="admin-ui-card admin-ui-card-form">
            <h2 class="admin-ui-card-title">Dados do membro</h2>

            <div class="admin-ui-grid admin-ui-grid-2">
                <div class="admin-ui-field">
                    <label for="inputNome" class="admin-ui-label">Nome</label>
                    <input type="text" name="name" class="admin-ui-input @error('name') is-invalid @enderror" id="inputNome"
                        placeholder="Nome..." value="{{ old('name') }}" required>
                    @error('name')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputEmail" class="admin-ui-label">Email</label>
                    <input type="email" name="email" class="admin-ui-input @error('email') is-invalid @enderror" id="inputEmail"
                        placeholder="Email..." value="{{ old('email') }}" required>
                    @error('email')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputWhatsapp" class="admin-ui-label">WhatsApp (com DDD)</label>
                    <input type="text" name="whatsapp" class="admin-ui-input @error('whatsapp') is-invalid @enderror" id="inputWhatsapp"
                        placeholder="WhatsApp..." value="{{ old('whatsapp') }}" inputmode="numeric"
                        oninput="this.value = formatWhatsapp(this.value)">
                    @error('whatsapp')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputCargo" class="admin-ui-label">Cargo</label>
                    <input type="text" class="admin-ui-input @error('cargo') is-invalid @enderror" name="cargo" id="inputCargo"
                        placeholder="Cargo..." value="{{ old('cargo') }}">
                    @error('cargo')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputCpf" class="admin-ui-label">CPF</label>
                    <input type="text" class="admin-ui-input @error('cpf') is-invalid @enderror" name="cpf" id="inputCpf"
                        placeholder="CPF..." value="{{ old('cpf') }}" required>
                    @error('cpf')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label class="admin-ui-label">Ativo</label>
                    <div class="admin-ui-field-inline">
                        <input type="checkbox" name="ativo" class="admin-ui-check @error('ativo') is-invalid @enderror" id="inputAtivo" value="1" {{ old('ativo') ? 'checked' : '' }}>
                        <label for="inputAtivo" class="admin-ui-helper mb-0">Marque para deixar o membro ativo</label>
                    </div>
                    @error('ativo')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field" style="grid-column: 1 / -1;">
                    <label for="inputBiografia" class="admin-ui-label">Biografia</label>
                    <textarea class="admin-ui-textarea @error('biografia') is-invalid @enderror"
                        name="biografia" id="inputBiografia" placeholder="Biografia...">{{ old('biografia') }}</textarea>
                    @error('biografia')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputLinkedin" class="admin-ui-label">LinkedIn</label>
                    <input type="url" class="admin-ui-input @error('linkedin') is-invalid @enderror" name="linkedin" id="inputLinkedin"
                        placeholder="LinkedIn URL" value="{{ old('linkedin') }}">
                    @error('linkedin')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputGithub" class="admin-ui-label">GitHub</label>
                    <input type="url" class="admin-ui-input @error('github') is-invalid @enderror" name="github" id="inputGithub"
                        placeholder="GitHub URL" value="{{ old('github') }}">
                    @error('github')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field" style="grid-column: 1 / -1;">
                    <label class="admin-ui-label">Funções</label>
                    <input type="hidden" name="roles[]" value="" required>
                    <div class="admin-ui-inline-options">
                        @foreach ($roles as $role)
                            <label for="role-{{$role->id}}" class="admin-ui-inline-option">
                                <input type="checkbox" name="roles[]" id="role-{{$role->id}}" class="admin-ui-check" value="{{ $role->name }}">
                                <span>{{$role->name}}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('roles')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-ui-field">
                    <label for="inputAlt" class="admin-ui-label">Alt</label>
                    <input type="text" class="admin-ui-input @error('alt') is-invalid @enderror" name="alt" id="inputAlt"
                        placeholder="Texto alternativo..." value="{{ old('alt') }}">
                    @error('alt')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                </div>

                <div id="additional-links"></div>

                <div class="admin-ui-field">
                    <label for="inputImagem" class="admin-ui-label">Imagem</label>
                    <div class="admin-ui-file-control">
                        <label class="admin-ui-file-button" for="inputImagem" aria-label="Selecionar imagem">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <span class="admin-ui-file-name" data-admin-file-name>Nenhum arquivo selecionado</span>
                        </label>
                        <input type="file" name="imagem" class="admin-ui-file-native @error('imagem') is-invalid @enderror image" id="inputImagem">
                    </div>
                    @error('imagem')
                        <div class="admin-ui-error">{{ $message }}</div>
                    @enderror
                    <input type="hidden" name="cropped_image" id="cropped_image" value="{{ old('cropped_image') }}">
                </div>

                <div class="admin-ui-field" id="croppedImageContainer" style="{{ old('cropped_image') ? '' : 'display: none;' }}">
                    <label for="croppedImagePreview" class="admin-ui-label">Preview da imagem</label>
                    <div id="croppedImagePreview" style="width: 160px; height: 160px; border: 1px solid #ddd; border-radius: 50%; overflow: hidden;">
                        <img id="croppedImage" src="{{ old('cropped_image') }}" alt="Imagem recortada" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
            </div>

            <input type="hidden" name="generated_password" id="generated_password" value="">
        </div>

        <div class="admin-ui-actions">
            <a href="{{ route('users.index') }}" class="admin-ui-btn admin-ui-btn-secondary">Cancelar</a>
            <button type="submit" class="admin-ui-btn admin-ui-btn-primary">
                <i class="fa-regular fa-floppy-disk"></i> Salvar
            </button>
        </div>
    </form>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Recortar Imagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="img-container" style="max-width: 100%; margin-top: 20px;">
                            <img id="image" src="" alt="Imagem para recortar" style="max-width: 100%;">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="preview" style="width: 140px; height: 140px; border: 1px solid #ddd; border-radius: 50%; overflow: hidden;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="cancel-button">Cancelar</button>
                <button type="button" class="btn btn-primary" id="crop">Recortar</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>

<script>
function formatWhatsapp(value) {
    var digits = value.replace(/\D/g, '').slice(0, 11);

    if (digits.length <= 2) {
        return digits;
    }

    if (digits.length <= 7) {
        return '(' + digits.slice(0, 2) + ') ' + digits.slice(2);
    }

    return '(' + digits.slice(0, 2) + ') ' + digits.slice(2, 7) + '-' + digits.slice(7);
}

var $modal = $('#modal');
var image = document.getElementById('image');
var cropper;

$("body").on("change", ".image", function(e){
    var files = e.target.files;
    var done = function (url) {
        image.src = url;
        $modal.modal('show');
    };

    var reader;
    var file;

    if (files && files.length > 0) {
        file = files[0];

        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
});

$modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 3,
        preview: '.preview'
    });
}).on('hidden.bs.modal', function () {
    cropper.destroy();
    cropper = null;
});

$("#crop").click(function(){
    var canvas = cropper.getCroppedCanvas({
        width: 160,
        height: 160,
    });

    var circleCanvas = document.createElement('canvas');
    var circleCtx = circleCanvas.getContext('2d');
    circleCanvas.width = 160;
    circleCanvas.height = 160;

    circleCtx.beginPath();
    circleCtx.arc(80, 80, 80, 0, 2 * Math.PI);
    circleCtx.closePath();
    circleCtx.clip();

    circleCtx.drawImage(canvas, 0, 0, 160, 160);

    circleCanvas.toBlob(function(blob) {
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
            var base64data = reader.result;
            $('#cropped_image').val(base64data);
            $('#croppedImage').attr('src', base64data);
            $('#croppedImagePreview').show();
            $modal.modal('hide');
        };
    });
});

@if(old('cropped_image'))
    $(document).ready(function() {
        $('#croppedImageContainer').show();
    });
@endif

document.addEventListener('DOMContentLoaded', function() {
    var password = Math.random().toString(36).slice(-8);
    document.getElementById('generated_password').value = password;

    var whatsappInput = document.getElementById('inputWhatsapp');
    if (whatsappInput) {
        whatsappInput.value = formatWhatsapp(whatsappInput.value);
    }
});
</script>
@endsection
