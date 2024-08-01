@extends('membros.layout')

@section('content')
<div class="card mt-5">
    <h2 class="card-header">Cadastro de Membro</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('membros.index') }}"><i
                    class="fa fa-arrow-left"></i> Voltar</a>
        </div>

        <form action="{{ route('membros.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="inputNome" class="form-label"><strong>Nome:</strong></label>
                <input type="text" name="nome" class="form-control" id="inputNome"
                    placeholder="Nome...">
            </div>

            <div class="mb-3">
                <label for="inputCargo" class="form-label"><strong>Cargo:</strong></label>
                <input type="text" class="form-control" name="cargo"
                    id="inputCargo" placeholder="Cargo...">
            </div>

            <div class="mb-3">
                <label for="inputBiografia" class="form-label"><strong>Biografia:</strong></label>
                <textarea class="form-control" style="height:150px"
                    name="biografia" id="inputBiografia" placeholder="Biografia..."></textarea>
            </div>

            <div class="mb-3">
                <label for="inputImagem" class="form-label"><strong>Imagem:</strong></label>
                <input type="file" name="imagem" class="form-control"id="inputImagem">
            </div>

            <div class="mb-3">
                <label for="inputAlt" class="form-label"><strong>Alt:</strong></label>
                <input type="text" class="form-control" name="alt"
                    id="inputAlt" placeholder="Descrição da imagem...">
            </div>

            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
        </form>

    </div>
</div>
@endsection