<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Formulário de Login e Registro</title>
  <!---Custom CSS File--->
  @vite('resources/css/styleLogin.css')    
</head>
<body>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <header>Login</header>
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Digite seu e-mail" :value="old('email')" required autofocus autocomplete="username">
        <input type="password" name="password" placeholder="Digite sua senha" required autocomplete="current-password">
        <a href="{{ route('password.request') }}">Esqueceu a senha?</a>
        <input type="submit" class="button" value="Entrar">
      </form>
      </div>
    </div>
  </div>
</body>
</html>
