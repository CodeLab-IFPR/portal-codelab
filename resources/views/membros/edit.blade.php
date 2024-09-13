@extends('layouts.admin')

<!-- Titulo -->
@section('title')
Membros - Edição
@endsection
<!-- Titulo -->

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Membro - Edição</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="card-body">
        <form action="{{ route('membros.update', $membro->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="inputNome" class="form-label"><strong>Nome:</strong></label>
                <input type="text" name="nome" value="{{ old('nome', $membro->nome) }}"
                    class="form-control @error('nome') is-invalid @enderror" id="inputNome" placeholder="Nome...">
                @error('nome')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputCargo" class="form-label"><strong>Cargo:</strong></label>
                <input type="text" name="cargo" value="{{ old('cargo', $membro->cargo) }}"
                    class="form-control @error('cargo') is-invalid @enderror" id="inputCargo" placeholder="Cargo...">
                @error('cargo')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
    <label for="inputCpf" class="form-label"><strong>CPF:</strong></label>
    <input type="text" name="cpf" value="{{ old('cpf', $membro->cpf) }}"
        class="form-control @error('cpf') is-invalid @enderror" id="inputCpf" placeholder="CPF...">
    @error('cpf')
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="inputAtivo" class="form-label"><strong>Ativo:</strong></label>
    <input type="checkbox" name="ativo" class="form-check-input @error('ativo') is-invalid @enderror" id="inputAtivo" value="1" {{ old('ativo', $membro->ativo) ? 'checked' : '' }}>
    @error('ativo')
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>    

            <div class="mb-3">
                <label for="inputBiografia" class="form-label"><strong>Biografia:</strong></label>
                <textarea class="form-control @error('biografia') is-invalid @enderror" style="height:150px"
                    name="biografia" id="inputBiografia" placeholder="Biografia...">{{ old('biografia', $membro->biografia) }}</textarea>
                @error('biografia')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputLinkedin" class="form-label"><strong>LinkedIn:</strong></label>
                <input type="url" class="form-control @error('linkedin') is-invalid @enderror" name="linkedin" id="inputLinkedin"
                    placeholder="LinkedIn URL" value="{{ old('linkedin', $membro->linkedin) }}">
                @error('linkedin')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputGithub" class="form-label"><strong>GitHub:</strong></label>
                <input type="url" class="form-control @error('github') is-invalid @enderror" name="github" id="inputGithub"
                    placeholder="GitHub URL" value="{{ old('github', $membro->github) }}">
            </div>

            <div class="mb-3">
                <label for="inputAlt" class="form-label"><strong>Alt:</strong></label>
                <input type="text" class="form-control @error('alt') is-invalid @enderror" name="alt" id="inputAlt"
                    placeholder="Texto alternativo..." value="{{ old('alt', $membro->alt) }}">
                @error('alt')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputImagem" class="form-label"><strong>Imagem:</strong></label>
                <input type="file" name="imagem" class="form-control @error('imagem') is-invalid @enderror image" id="inputImagem">
                @if($membro->imagem)
                    <img src="/imagens/{{ $membro->imagem }}" width="300px" class="mt-2">
                @endif
                @error('imagem')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
                <input type="hidden" name="cropped_image" id="cropped_image">
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary">Salvar</button>
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