@extends('layouts.admin')

@section('title')
Galeria Admin
@endsection

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Galeria - Lista</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end" aria-label="breadcrumb"></ol>
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Galeria - Lista
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end" style="margin-right: 10px;">
        <a class="btn btn-outline-success btn-sm" href="{{ route('galeria.create') }}" aria-label="Adicionar Mídia">
            <i class="fa fa-plus" aria-hidden="true"></i> Adicionar Mídia
        </a>
    </div>
    <br>
    <table id="midiasTable" class="display" aria-describedby="midiasTable_info">
        <thead>
            <tr>
                <th scope="col">Tipo</th>
                <th scope="col">Título</th>
                <th scope="col">Descrição</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($midias as $midia)
                <tr>
                    <td>
                        @if($midia->tipo == 'imagem')
                            <img src="{{ asset($midia->caminho) }}" alt="{{ $midia->titulo }}"
                                style="width: 100%; height: 100px; object-fit: cover;">
                        @else
                            @php
                                $videoId = '';
                                if (preg_match('/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/', $midia->caminho, $match)) {
                                    $videoId = $match[7];
                                }
                            @endphp
                            <img src="https://img.youtube.com/vi/{{ $videoId }}/mqdefault.jpg"
                                alt="{{ $midia->titulo }}" style="width: 100%; height: 100px; object-fit: cover;">
                        @endif
                    </td>
                    <td>{{ $midia->titulo }}</td>
                    <td>{{ $midia->descricao }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" aria-label="Ações">
                                <i class="fas fa-cog" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item text-warning" href="{{ route('galeria.edit', $midia->id) }}"><i class="fas fa-edit" aria-hidden="true"></i> Editar</a></li>
                                <li>
                                    <form action="{{ route('galeria.destroy', $midia->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash-alt" aria-hidden="true"></i> Excluir</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $midias->links() }}
</div>

<script>
    $(document).ready(function () {
        $('#midiasTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
            }
        });
    });
</script>
@endsection
