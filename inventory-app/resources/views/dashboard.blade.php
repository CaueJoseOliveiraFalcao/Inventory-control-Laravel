<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <script src='./jquery.js'></script>
        <meta name="_token" content="{{ csrf_token() }}">

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
            .logout-button{
                cursor: pointer;
                margin: 1rem 0;
                padding: 1rem;
                background-color: red;
                color: white;
                transition: background-color 0.3s ease, box-shadow 0.3s ease;
                border-style: none;
            }
            .logout-button:hover{
                box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
            }
            .save-changes-button{
                cursor: pointer;
                margin: 1rem 0;
                padding: 1rem;
                background-color: blue;
                color: white;
                transition: background-color 0.3s ease, box-shadow 0.3s ease;
                border-style: none;
            }
        </style>
    </head>
    <body class="antialiased">
        <h1 class="app-logo">Control App</h1>
        <h2>Dashboard</h2>

        <form method='POST' action="/logout">
            @csrf
            <input class='logout-button' type="submit" value="Sair">
        </form>
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
        <form>
            @csrf
            <div class="container-itens">
            @foreach ($items as $item) 
                <div class="item">
                    <p class="item-title"'>{{ $item->itemName }}</p>
                    <p class="item-quantity" id="quantity-{{ $item->id }}">{{ $item->itemQuantity  }}</p>
                    <button type='button' class="item-sum" onclick="incrementQuantity({{ $item->id }})"> ➕ </button>
                    <button type='button' class="item-subtraction" onclick="decrementQuantity({{ $item->id }})"> ➖ </button>
                    <input type="hidden" id="itemData" value="{{ $item->id }}">
                    <input type="hidden" id="itemQuantity" value="{{ $item->itemQuantity }}">
                    <button class="item-delete"> 🗑️ </button>
                </div>
            @endforeach
            <a onclick='submit()'>enviar</a>
            </div>
        </form>
        <script>
            $
            const incrementQuantity = (itemId) => {
                const quantityElement = document.getElementById(`quantity-${itemId}`);
                let currentQuantity = parseInt(quantityElement.textContent);
                currentQuantity++;
                quantityElement.textContent = currentQuantity;
                updateInputValue(itemId , currentQuantity);
            }
            const decrementQuantity = (itemId) => {
                const quantityElement = document.getElementById(`quantity-${itemId}`);
                let currentQuantity = parseInt(quantityElement.textContent);
                if(currentQuantity > 0){
                    currentQuantity--;
                    quantityElement.textContent = currentQuantity;
                    updateInputValue(itemId , currentQuantity);
                }
            }
            const updateInputValue = (itemId , newQuantity) => {
                const inputElement = document.getElementById(`quantity-${itemId}`);
                inputElement.value = newQuantity;
            }
            const submit = () => {
                const allQuantity = document.querySelectorAll('.item-quantity');
                const itemsId = document.querySelectorAll('#itemData');
                const ArrayItems = []

                for (let index = 0; index < allQuantity.length; index++) {
                    let QuantityEach = allQuantity[index].textContent;
                    let IdEach = itemsId[index].value

                    const obj = {
                        'quantidade' : QuantityEach,
                        'Id' : IdEach
                    };
                    ArrayItems.push(obj);
                }
                console.log(ArrayItems);

                var _token = $('meta[name="_token"]').attr('content');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': _token
                        }
                    });
                        $.ajax({
                            url: '/alterQuantity',
                            type: 'POST',
                            data: {ArrayItems : ArrayItems},
                            dataType: 'JSON',

                            success: function(data){
                                console.log(data);
                            }
                        });
                        return false;
                    };
    </script>
    </body>
    
</html>
