@extends('layouts.admin')

@section('title')
Galeria Admin
@endsection

@section('content')
<div class="container">
    <h1>Galeria Admin</h1>
    <a href="{{ route('galeria.create') }}" class="btn btn-primary mb-3">Adicionar Mídia</a>
    <table id="midiasTable" class="display">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($midias as $midia)
                <tr>
                    <td>
                        @if($midia->tipo == 'imagem')
                            <img src="{{ asset($midia->caminho) }}" alt="{{ $midia->titulo }}" style="width: 100%; height: 100px; object-fit: cover;">
                        @else
                            @php
                                $videoId = '';
                                if (preg_match('/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/', $midia->caminho, $match)) {
                                    $videoId = $match[7];
                                }
                            @endphp
                            <img src="https://img.youtube.com/vi/{{ $videoId }}/mqdefault.jpg" alt="{{ $midia->titulo }}" style="width: 100%; height: 100px; object-fit: cover;">
                        @endif
                    </td>
                    <td>{{ $midia->titulo }}</td>
                    <td>{{ $midia->descricao }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item text-warning" href="{{ route('galeria.edit', $midia->id) }}"><i class="fas fa-edit"></i> Editar</a></li>
                                <li>
                                    <form action="{{ route('galeria.destroy', $midia->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash-alt"></i> Excluir</button>
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
    $(document).ready(function() {
        $('#midiasTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
            }
        });
    });
</script>
@endsection