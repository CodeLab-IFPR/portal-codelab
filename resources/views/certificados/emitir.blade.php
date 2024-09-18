@extends('layouts.portal')

@section('title')
Emitir Certificado
@endsection

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-50">
    <div class="text-center">
        <h1>Emitir Certificados</h1>

        <!-- Formulário para busca de certificados por CPF -->
        <form id="cpfForm" class="mb-2">
            <div class="mb-3">
                <label for="cpf" class="form-label">Digite seu CPF:</label>
                <input type="text" id="cpf" name="cpf" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar Certificados</button>
        </form>

        <!-- Onde os certificados aparecerão -->
        <div id="certificadosList"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Script de emissão carregado'); // Verifica se o script está carregado

        // Função para aplicar a máscara de CPF
        function aplicarMascaraCPF(valor) {
            valor = valor.replace(/\D/g, ''); // Remove tudo que não é número
            valor = valor.substring(0, 11); // Limita o comprimento a 11 caracteres
            if (valor.length > 9) {
                valor = valor.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
            } else if (valor.length > 6) {
                valor = valor.replace(/(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3');
            } else if (valor.length > 3) {
                valor = valor.replace(/(\d{3})(\d{1,2})/, '$1.$2');
            } else {
                valor = valor.replace(/(\d{1,2})/, '$1');
            }
            return valor;
        }

        const cpfInput = document.getElementById('cpf');
        cpfInput.addEventListener('input', function () {
            this.value = aplicarMascaraCPF(this.value);
        });

        document.getElementById('cpfForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Previne o comportamento padrão de submit
            console.log('Formulário enviado'); // Verifica se o formulário está sendo enviado

            let cpf = document.getElementById('cpf').value; // Obtém o valor do CPF digitado
            console.log('CPF digitado:', cpf); // Mostra o CPF no console

            // Envia a requisição AJAX para a rota de buscar certificados
            fetch('{{ route('certificados.buscar') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        cpf: cpf
                    }) // Envia o CPF no corpo da requisição
                })
                .then(response => {
                    console.log('Resposta recebida:', response); // Verifica a resposta da requisição
                    return response.json(); // Processa a resposta como JSON
                })
                .then(data => {
                    console.log('Dados recebidos:', data); // Verifica os dados recebidos
                    let certificadosList = document.getElementById('certificadosList');
                    certificadosList.innerHTML = ''; // Limpa a lista de certificados

                    if (data.certificados && data.certificados.length > 0) {
                        let table = '<table class="table"><thead><tr><th>Descrição</th><th>Horas</th><th>Ações</th></tr></thead><tbody>';
                        data.certificados.forEach(certificado => {
                            table += `<tr>
                                <td>${certificado.descricao}</td>
                                <td>${certificado.horas}</td>
                                <td>
                                    <a href="/certificados/${certificado.id}/view" target="_blank">Visualizar</a> |
                                    <a href="/certificados/${certificado.id}/download">Baixar</a>
                                </td>
                            </tr>`;
                        });
                        table += '</tbody></table>';
                        certificadosList.innerHTML = table;
                    } else {
                        certificadosList.innerHTML = '<p>Nenhum certificado encontrado para esse CPF.</p>';
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar certificados:', error); // Exibe erros no console
                });
        });
    });
</script>
@endsection
