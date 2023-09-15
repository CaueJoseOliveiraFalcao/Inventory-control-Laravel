<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function ShowLoginForm()
    {
        return view('auth.login');
    }
    public function ShowRegisterForm()
    {
        return view('auth.registe');
    }
    public function ShowDashboard()
    {
        if (!Auth::check()) {
             redirect()->route('login')->withErrors('error', 'Você precisa estar logado para acessar a página de dashboard.')->withInput();
        }
        $user = Auth::user();  
        return view('dashboard')->with('user', $user);
    }
    public function sort(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|max:255|unique:users',
                'password' => 'required|min:8',
            ]);
            $name = $request -> name;
            $email = $request -> email;
            $password = $request -> password;

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password)
            ]);
            return redirect()->route('login')->with('success', 'Registro bem-sucedido. Faça o login');
        } catch (ValidationException $exception){
            return redirect()->route("register")->withErrors($exception->validator)->withInput();
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $items = $user->items; // Recupera todos os itens associados ao usuário
            
            return view('dashboard', ['items' => $items])->with('success', 'Login Bem Sucedido');
        } else {
            return redirect()->back()->withInput()->withErrors(['email' => 'As credenciais fornecidas são inválidas.']);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Deslogado com sucesso');
    }
    public function addItemtoUser(Request $request)
    {   
        try {
            $validated = $request->validate([
                'itemName' => 'required|max:255',
                'itemQuantity' => 'required|max:255',
                'userId' => 'required',
            ]);
    
            $ItemName = $request->itemName;
            $ItemQuantity = $request->itemQuantity;
            $UserId = $request->userId;
            $user = User::find($UserId);
    
            if ($user) {
                $existingItem = $user->items()->where('itemName', $ItemName)->first();
    
                if (!$existingItem) {
                    $item = new Item([
                        'itemName' => $ItemName,
                        'itemQuantity' => $ItemQuantity,
                        'user_id' => $UserId
                    ]);
                    $user->items()->save($item);
                    $items = $user->items;
                    return view('dashboard', ['items' => $items])->with('success', 'Login Bem Sucedido');
                } else { 
                    return response()->json(['message' => 'Esse item já existe na sua lista.'], 400);
                }
            } else {
                return response()->json(['message' => 'Usuário não encontrado.'], 404);
            }
        }
        catch (ValidationException $exception) {
            return redirect()->route("dashboard")->withErrors($exception->validator)->withInput();
        }
    }
    public function alteritem(Request $request)
    {
        $itemId = $request->itemData;
        $NewItemQuantity = $request->itemQuantity;
        $item = Item::find($itemId);

    }
}
