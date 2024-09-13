@extends('layouts.admin')

<!-- Titulo -->
@section('title')
Membros - Cadastro
@endsection
<!-- Titulo -->

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Membro - Cadastro</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Membro - Cadastro
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="card-body">
        <form action="{{ route('membros.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="inputNome" class="form-label"><strong>*Nome:</strong></label>
                <input type="text" name="nome" class="form-control @error('nome') inválido @enderror" id="inputNome"
                    placeholder="Nome..." required>
                @error('nome')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputCargo" class="form-label"><strong>*Cargo:</strong></label>
                <input type="text" class="form-control @error('cargo') inválido @enderror" name="cargo" id="inputCargo"
                    placeholder="Cargo..." required>
                @error('cargo')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
    <label for="inputCpf" class="form-label"><strong>*CPF:</strong></label>
    <input type="text" class="form-control @error('cpf') inválido @enderror" name="cpf" id="inputCpf"
        placeholder="CPF..." required>
    @error('cpf')
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="inputAtivo" class="form-label"><strong>*Ativo:</strong></label>
    <input type="checkbox" class="form-check-input @error('ativo') inválido @enderror" name="ativo" id="inputAtivo" value="1" required>
    @error('ativo')
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>

            <div class="mb-3">
                <label for="inputBiografia" class="form-label"><strong>*Biografia:</strong></label>
                <textarea class="form-control @error('biografia') inválido @enderror" style="height:150px"
                    name="biografia" id="inputBiografia" placeholder="Biografia..." required></textarea>
                @error('biografia')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputLinkedin" class="form-label"><strong>LinkedIn:</strong></label>
                <input type="url" class="form-control @error('linkedin') is-invalid @enderror" name="linkedin" id="inputLinkedin"
                    placeholder="LinkedIn URL">
                @error('linkedin')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputGithub" class="form-label"><strong>GitHub:</strong></label>
                <input type="url" class="form-control @error('github') is-invalid @enderror" name="github" id="inputGithub"
                    placeholder="GitHub URL">
                @error('github')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputAlt" class="form-label"><strong>*Alt:</strong></label>
                <input type="text" class="form-control @error('alt') is-invalid @enderror" name="alt" id="inputAlt"
                    placeholder="Texto alternativo..." required>
                @error('alt')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div id="additional-links"></div>

            <div class="mb-3">
                <label for="inputImagem" class="form-label"><strong>*Imagem:</strong></label>
                <input type="file" name="imagem" class="form-control @error('imagem') inválido @enderror image" id="inputImagem" required>
                @error('imagem')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
                <input type="hidden" name="cropped_image" id="cropped_image">
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <input type="submit" class="btn btn-outline-success" value="Salvar">
            </div>
        </form>
    </div>
</div>

<!-- Modal para Cropper.js -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Cortar Imagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="image" src="" style="max-width: 100%; height: auto;">
                        </div>
                        <div class="col-md-4">
                            <div class="preview" style="width: 100%; height: 200px; overflow: hidden; border-radius: 50%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="cancelButton">Cancelar</button>
                <button type="button" class="btn btn-primary" id="crop">Cortar</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts necessários para Cropper.js -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>

<script>
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
        var url;

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
            aspectRatio: 1, // Mantenha a proporção 1:1 para um círculo
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function(){
        canvas = cropper.getCroppedCanvas({
            width: 160,
            height: 160,
        });

        // Crie um canvas circular
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
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result; 
                $('#cropped_image').val(base64data);
                $modal.modal('hide');
            }
        });
    });
</script>
@endsection