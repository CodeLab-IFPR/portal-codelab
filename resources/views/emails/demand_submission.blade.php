<!DOCTYPE html>
<html>
<head>
    <title>Nova Submissão de Demanda</title>
</head>
<body>
    <h1>Nova Submissão de Demanda</h1>
    <p><strong>Nome:</strong> {{ $data['name'] }}</p>
    <p><strong>E-mail:</strong> {{ $data['email'] }}</p>
    <p><strong>Descrição da Demanda:</strong> {{ $data['demand_description'] }}</p>
    <p><strong>Utilidade Esperada:</strong> {{ $data['expected_utility'] }}</p>
</body>
</html>