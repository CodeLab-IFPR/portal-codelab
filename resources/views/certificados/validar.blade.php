@extends('layouts.portal')

@section('title')
Validar Certificado
@endsection

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-50">
    <div class="text-center">
        <h1>Validar Certificado</h1>
        <form id="validar-certificado-form">
            @csrf
            <div class="form-group">
                <label for="token">Token do Certificado</label>
                <input type="text" class="form-control" id="token" name="token" required>
            </div>
            <br>
            <button type="submit" class="btn btn-outline-primary">Validar</button>
        </form>

        <div id="certificado-detalhes" class="mt-4" style="display: none;">
            <h2>Detalhes do Certificado</h2>
            <p><strong>Nome:</strong> <span id="nome"></span></p>
            <p><strong>Descrição:</strong> <span id="descricao"></span></p>
            <p><strong>Horas:</strong> <span id="horas"></span></p>
            <p><strong>Data:</strong> <span id="data"></span></p>
        </div>

        <div id="error-message" class="mt-4 alert alert-danger" style="display: none;"></div>
    </div>
</div>

<script>
    document.getElementById('validar-certificado-form').addEventListener('submit', function (event) {
        event.preventDefault();

        let token = document.getElementById('token').value;
        let formData = new FormData();
        formData.append('token', token);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route('certificados.validar.post') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.certificado) {
                    if (data.certificado.membro) {
                        document.getElementById('nome').innerText = data.certificado.membro.nome || 'N/A';
                    } else {
                        document.getElementById('nome').innerText = 'Membro não encontrado';
                    }
                    document.getElementById('descricao').innerText = data.certificado.descricao || 'N/A';
                    document.getElementById('horas').innerText = data.certificado.horas || 'N/A';
                    document.getElementById('data').innerText = data.certificado.data || 'N/A';

                    document.getElementById('certificado-detalhes').style.display = 'block';
                    document.getElementById('error-message').style.display = 'none';
                } else {
                    document.getElementById('error-message').innerText = data.error || 'Erro desconhecido';
                    document.getElementById('error-message').style.display = 'block';
                    document.getElementById('certificado-detalhes').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                document.getElementById('error-message').innerText = 'Ocorreu um erro ao validar o certificado.';
                document.getElementById('error-message').style.display = 'block';
                document.getElementById('certificado-detalhes').style.display = 'none';
            });
    });
</script>
@endsection