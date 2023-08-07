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
        </style>
    </head>
    <body class="antialiased">
        <h1 class="app-logo">Control App</h1>
        <div class="login-card">
            <h1>Faça seu Registro</h1>
            <label  for="email">Email</label>
            <input type="email" name="email">
            <label style="margin-top: 1rem;"  for="password">Senha</label>
            <input type="password" name="password">
            <a style="margin-top: 1rem " href="">Não e Registrado?</a>
            <input class="login-submit" type="submit" value="Confirmar">
        </div>
    </body>
</html>
