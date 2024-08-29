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
                <input type="file" name="imagem" class="form-control @error('imagem') is-invalid @enderror"
                    id="inputImagem">
                @if($membro->imagem)
                    <img src="/imagens/{{ $membro->imagem }}" width="300px" class="mt-2">
                @endif
                @error('imagem')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputAlt" class="form-label"><strong>Alt:</strong></label>
                <input type="text" name="alt" value="{{ old('alt', $membro->alt) }}"
                    class="form-control @error('alt') is-invalid @enderror" id="inputAlt"
                    placeholder="Descrição da imagem...">
                @error('alt')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div id="links-container">
                <label for="links" class="form-label"><strong>Links:</strong></label>
                @foreach($membro->links as $index => $link)
                    <div class="input-group mb-3">
                        <input type="text" name="links[{{ $index }}][link]"
                            value="{{ old("links[$index][link]", $link->link) }}"
                            class="form-control @error(" links.$index.link") is-invalid @enderror"
                            placeholder="LinkedIn/Github/Discord...">
                        <button type="button" class="btn btn-outline-primary"
                            onclick="addLink()"><strong>+</strong></button>
                        <button type="button" class="btn btn-outline-danger" onclick="removeLink(this)">-</button>
                        @error("links.$index.link")
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>
            <br>
            
            <div class="d-flex justify-content-between mt-3">
                <a class="btn btn-outline-danger btn-sm" href="{{ route('membros.index') }}"><i
                        class="fa fa-arrow-left"></i>Cancelar</a>

                <button type="submit" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-floppy-disk"></i> Atualizar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function addLink() {
        const container = document.getElementById('links-container');
        const index = container.children.length;

        const div = document.createElement('div');
        div.classList.add('input-group', 'mb-3');

        div.innerHTML = `
            <input type="text" name="links[${index}][link]" class="form-control" placeholder="LinkedIn/Github/Discord...">
            <button type="button" class="btn btn-danger" onclick="removeLink(this)">-</button>
        `;
        container.appendChild(div);
    }

    function removeLink(button) {
        button.parentElement.remove();
    }
</script>
@endsection
