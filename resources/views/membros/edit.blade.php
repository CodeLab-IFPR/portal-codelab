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
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Membro - Edição
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="card-body">
        <form action="{{ route('membros.update', $membro->id) }}" method="POST"
            enctype="multipart/form-data">
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
                <label for="inputBiografia" class="form-label"><strong>Biografia:</strong></label>
                <textarea class="form-control @error('biografia') is-invalid @enderror" style="height:150px"
                    name="biografia" id="inputBiografia"
                    placeholder="Biografia...">{{ old('biografia', $membro->biografia) }}</textarea>
                @error('biografia')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputImagem" class="form-label"><strong>Imagem:</strong></label>
                <input type="file" name="imagem" class="form-control @error('imagem') is-invalid @enderror" id="inputImagem">
                @if($membro->imagem)
                    <img src="/imagens/{{ $membro->imagem }}" width="300px" class="mt-2">
                @endif
                @error('imagem')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputAlt" class="form-label"><strong>Alt:</strong></label>
                <input type="text" name="alt" value="{{ old('alt', $membro->alt) }}" class="form-control @error('alt') is-invalid @enderror" id="inputAlt" placeholder="Descrição da imagem...">
                @error('alt')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputLinkedin" class="form-label"><strong>LinkedIn:</strong></label>
                <input type="url" name="linkedin" value="{{ old('linkedin', $membro->linkedin) }}"
                    class="form-control @error('linkedin') is-invalid @enderror" id="inputLinkedin" placeholder="LinkedIn URL">
                @error('linkedin')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputGithub" class="form-label"><strong>GitHub:</strong></label>
                <input type="url" name="github" value="{{ old('github', $membro->github) }}"
                    class="form-control @error('github') is-invalid @enderror" id="inputGithub" placeholder="GitHub URL">
                @error('github')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            
            <div class="d-flex justify-content-between mt-3">
                <a class="btn btn-outline-danger btn-sm" href="{{ route('membros.index') }}"><i
                        class="fa fa-arrow-left"></i>Cancelar</a>

                <button type="submit" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-floppy-disk"></i> Atualizar</button>
            </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal para crop de imagem -->
<div id="imageModel" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crop de Imagem</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="image_demo" style="width:350px; margin-top:30px"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary crop_image">Salvar</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        var $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'square'
            },
            boundary: {
                width: 300,
                height: 300
            }
        });

        $('#inputImagem').on('change', function() {
            var reader = new FileReader();
            reader.onload = function(event) {
                $image_crop.croppie('bind', {
                    url: event.target.result
                }).then(function() {
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
            $('#imageModel').modal('show');
        });

        $('.crop_image').click(function(event) {
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function(response) {
                $('#imageModel').modal('hide');
                $('form').append('<input type="hidden" name="cropped_image" value="' + response + '">');
                $('form').submit();
            });
        });
    });
</script>
@endsection
