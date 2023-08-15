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
            .success p{
                background-color: #00b300;
                color: white;
                padding: 1rem;
                border-radius: 10px
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
            .item{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: row;
                padding: 1rem;
                border-style: solid;
                border-radius: 10px;
           }
           .item-title{
            margin-right: 1rem;
            color: #00b300;
           }
           .item-quantity{
            margin-right: 1rem;
            color: blue
           }
           button{
            margin: 0 0.6rem
           }
           .container-add-itens{
                display: flex;
                flex-direction: column;
                margin-bottom: 1rem;
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
            form {
                display: flex;
                flex-direction: column;
            }

        </style>
    </head>
    <body class="antialiased">
        <h1 class="app-logo">Control App</h1>
        <h2>Dashboard</h2>
        @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="success">
            @if (session('success'))
                <p>{{session("success")}}</p>
            @endif
        </div>
        <div class="container-add-itens">
            <form action="{{route('additem')}}" method="POST">
                @csrf
                <h1>Adicione um Item</h1>
                <label  for="itemName">Nome do Item</label>
                <input type="text" name="itemName">
                <label style="margin-top: 1rem;"  for="ItemQuantity">Quantidade</label>
                <input type="number" name="itemQuantity">
                <input type="hidden" name="userId" value="{{ auth()->user()->id }}">
                <input class="login-submit" type="submit" value="Confirmar">
            </form>
        </div>
        <div class="container-itens">
            <div class="item">
                <p class="item-title">Morango</p>
                <p class="item-quantity">Quantidade = 1</p>
                <button class="item-sum"> ➕ </button>
                <button class="item-subtraction"> ➖ </button>
                <button class="item-delete"> 🗑️ </button>
            </div>
        </div>
    </body>
</html>