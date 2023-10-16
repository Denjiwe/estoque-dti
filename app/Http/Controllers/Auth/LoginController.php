<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
// use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
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
            'cpf' => 'required|max:14',
            'password' => 'required|min:4'
        ];

        $feedback = [
            'cpf.required' => 'O CPF deve ser preenchido',
            'cpf.max' => 'O CPF deve conter no máximo 14 caracteres',
            'password.required' => 'A senha deve ser preenchida',
            'password.min' => 'A senha deve possuir no mínimo 4 caracteres'
        ];

        $request->validate($rules, $feedback);

        $cpf = str_replace(['.', '-'], '', $request->cpf);

        try {
            $user = Usuario::where('cpf', $cpf)->first();

            if(!$user) {
                return redirect()->route('login')->withErrors(['error' => 'CPF ou senha incorretos.']);
            }

            if($user->senha_provisoria != null) {
                if(!Hash::check($request->password, $user->senha_provisoria)) {
                    return redirect()->route('login')->withErrors(['error' => 'CPF ou senha incorretos.']);
                }

                return redirect()->route('alterar-senha', ['usuarioId' => $user->id]);
            }

            if(!Hash::check($request->password, $user->senha)) {
                return redirect()->route('login')->withErrors(['error' => 'CPF ou senha incorretos.']);
            }

            if($user->status == 'INATIVO') {
                return redirect()->route('login')->withErrors(['error' => 'Usuário inativo.']);
            }
            
            Auth::loginUsingId($user->id);

            if ($user->user_interno == 'SIM') {
                return redirect()->route('home');
            } else {
                return redirect()->route('minhas-solicitacoes.index');
            }
        } catch (\Exception $e) {
            Log::channel('erros')->error($e->getMessage().' - Na linha: '.$e->getLine().' - No arquivo: '.$e->getFile());
            return redirect()->route('login')->withErrors(['error' => 'Erro ao realizar login.']);
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
