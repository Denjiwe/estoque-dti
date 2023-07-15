<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrega;
use App\Models\Solicitacao;
use App\Models\Usuario;
use App\Models\Produto;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $entregas = Entrega::count();
        $solicitacoes = Solicitacao::count();
        $usuarios = Usuario::count();
        $produtos = Produto::count();

        return view('home', compact('entregas', 'solicitacoes', 'usuarios', 'produtos'));
    }
}
