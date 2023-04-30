<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
// use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function login(Request $request) {
        $rules = [
            'cpf' => 'required|max:11',
            'password' => 'required|min:4'
        ];

        $feedback = [
            'cpf.required' => 'O CPF deve ser preenchido',
            'cpf.max' => 'O CPF deve conter no máximo 11 caracteres',
            'password.required' => 'A senha deve ser preenchida',
            'password.min' => 'A senha deve possuir no mínimo 4 caracteres'
        ];

        $request->validate($rules, $feedback);

        $user = Usuario::where('cpf', $request->cpf)->first();

        if(!$user) {
            return redirect()->route('login')->withErrors(['error' => 'CPF ou senha incorretos']);
        }

        if(!Hash::check($request->password, $user->senha)) {
            return redirect()->route('login')->withErrors(['error' => 'CPF ou senha incorretos']);
        }

        if($user->status == 'INATIVO') {
            return redirect()->route('login')->withErrors(['error' => 'Usuário inativo']);
        }
        
        Auth::loginUsingId($user->id);

        if ($user->user_interno == 'SIM') {
            return redirect()->route('home');
        } else {
            return redirect()->route('minhas-solicitacoes');
        }
    }

    public function logout() {
        Auth::logout();

        return redirect()->route('login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
