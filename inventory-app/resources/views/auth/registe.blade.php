<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body{
               background-color: white;
               display: flex;
               justify-content: center;
               align-items: center;
               flex-direction: column;
               font-family: Arial, Helvetica, sans-serif
            }
            .app-logo{
                font-size: 70px;
                border-style: solid;
                border-radius: 100px;
                padding: 1rem;
                box-shadow: 1px 1px 1px
            }
            .login-card{
                display: flex;
                flex-direction: column;

                width: 300px;
                border-style: solid;
                padding: 1rem;
                border-radius: 10px
            }
            form {
                display: flex;
                flex-direction: column;
            }
            .login-submit{
                margin-top: 1rem;
                padding: 1rem;
                background-color: #00b300;
                color: white;
                transition: background-color 0.3s ease, box-shadow 0.3s ease;
                border-style: none
            }
            .login-submit:hover{
                background-color: #009900; 
                box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
            }
            .error{
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .error li{
                background-color: red;
                color: white;
                padding: 1rem;
                border-radius: 10px;
                list-style: none;
            }
            .error ul{
                padding: 0;
            }
        </style>
    </head>
    <body class="antialiased">
        <h1 class="app-logo">Control App</h1>
        @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="login-card">
            <h1>Faça seu Registro</h1>
        <form action="/register" method="POST">
            @csrf
                <label  for="name">Nome</label>
                <input type="text" name="name" required>
                <label style="margin-top: 1rem;" for="email">Email</label>
                <input type="email" name="email" required>
                <label style="margin-top: 1rem;"  for="password">Senha</label>
                <input type="password" pattern=".{8,}" required title="A senha deve ter pelo menos 8 caracteres" name="password">
                <a style="margin-top: 1rem " href="/">Ja e Registrado?</a>
                <input class="login-submit"  type="submit" value="Confirmar">
        </form>
        </div>
    </body>
</html>
