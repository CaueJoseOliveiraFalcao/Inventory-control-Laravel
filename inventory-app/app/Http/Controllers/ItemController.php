<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ItemController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function ShowDashboard()
    {
        
        if (!Auth::check()) {
             redirect()->route('login')->withErrors('error', 'Você precisa estar logado para acessar a página de dashboard.')->withInput();
        }
        $user = Auth::user();  
        $items = $user->items;
        return view('dashboard' , ['items' => $items])->with('success', 'Login Bem Sucedido');
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
    public function alterQuantity(Request $request)
    {
        $itemsJson = $request->input('array');
        $items = json_decode($itemsJson , true);
        foreach ($items as $item) {
            $id = $item['Id']; 
            $quantidade = $item['quantidade'];
            $trashStatus = $item['TrashStatus'];
            $DbItem = Item::find($id);

            if ($trashStatus === true){
                $DbItem->delete();
            }
            else{
                $DbItem->itemQuantity = $quantidade;
                $DbItem->save();
            }
        }
        $user = Auth::user();
        $items = $user->items;
        return view('dashboard', ['items' => $items]);

    }
 
}

?>
