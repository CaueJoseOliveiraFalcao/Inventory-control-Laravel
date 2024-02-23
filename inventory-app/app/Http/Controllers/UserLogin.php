<?php

namespace App\Http\Controllers;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class UserLogin extends Controller
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
    public function ShowReset()
    {
        return view('resetpassword');
    }
    public function ShowInsertReset()
    {
        return view('insertresetcode');
    }
    public function ShowConfirmCode()
    {
        return view('confirmcode');
    }
    public function ShowNewPassword (User $user)
    {
        Session::forget('password_reset_code');
        return view('newpassword', compact('user'));
    }
    public function sort(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'email:rfc,dns|required',
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
            session(['items' , $items]);
            return redirect()->intended(RouteServiceProvider::DASHBOARD);

        } else {
            return redirect()->back()->withInput()->withErrors(['email' => 'As credenciais fornecidas são inválidas.']);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Deslogado com sucesso');
    }
    public function SendReset(Request $request)
    {
        $email = $request -> email;
        $user = User::where('email', $email)->first();
        $randomCode = mt_rand(10000, 99999);
        if ($user) {
            $user->password_reset_code = $randomCode;
            $user->save();
            Mail::to($email)->send(new ResetPasswordMail($randomCode));
            return redirect()->route('confirmcode')->with('success', 'Email enviado com sucesso! Verifique seu email para o código de recuperação.');
        } else {
            return "Email nao registrado";
        }
    }
    public function CheckCode(Request $request)
    {
        $usercode = $request -> code;
        $existcode = User::where('password_reset_code', $usercode)->first();
        if ($existcode) {
            return redirect()->route('shonewpassword', ['user' => $existcode])->with('success', 'Digite sua nova senha');

        } else {
            return "codigo incorreto";
        }
    }
    public function InsetNewPassword(Request $request)
    {
        $id = $request->id;
        $newPassword = $request->password;

        $user = User::find($id);

        if ($user) {
            $user->password_reset_code = bcrypt($newPassword);
            $user->save();

            return redirect()->route('login')->with('success', 'Senha Alterada');
        } else {
            return "Usuário não encontrado";
        }
    }

}
