<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrega;
use App\Models\Solicitacao;
use App\Models\Usuario;
use App\Models\Produto;
use App\Models\ItensSolicitacao;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $entregasEncerradasUser = Entrega::whereHas('solicitacao', function($query) {
            $query->where('status', 'ENCERRADO');
        })->where('entregas.usuario_id', auth()->user()->id)->get();
        $entregasUser = Entrega::where('usuario_id', auth()->user()->id)->get();
        $entregasUserCount = $entregasUser->count();
        $solicitacoesUser = array();
        foreach($entregasEncerradasUser as $entrega) {
            if(!in_array($entrega->solicitacao, $solicitacoesUser)) {
                array_push($solicitacoesUser, $entrega->solicitacao);
            }
        }
        $solicitacoesUserCount = count($solicitacoesUser);

        $solicitacoesChart = "";

        for ($i = 30; $i >= 0; $i--) {
            $data = Carbon::now()->subDays($i)->startOfDay()->format('Y-m-d');

            $solicitacoesAguardando = Solicitacao::where('status', 'AGUARDANDO')->whereDate('updated_at', $data)->count();

            $solicitacoesLiberadas = Solicitacao::where('status', 'LIBERADO')->whereDate('updated_at', $data)->count();

            $solicitacoesAbertas = Solicitacao::where('status', 'ABERTO')->whereDate('updated_at', $data)->count();

            $solicitacoesEncerradas = Solicitacao::where('status', 'ENCERRADO')->whereDate('updated_at', $data)->count();
                
            $ano = explode('-', $data)[0];
            $mes = explode('-', $data)[1] - 1;
            $dia = explode('-', $data)[2];
            
            $solicitacoesChart .= "[new Date(".$ano.",".$mes.",".$dia."), ".$solicitacoesAbertas.", ".$solicitacoesLiberadas.", ".$solicitacoesAguardando.", ".$solicitacoesEncerradas."],";
            
        }

        $produtosEntregues = ItensSolicitacao::withCount(['entregas as total_qntde' => function ($query) {
            $query->select(DB::raw('sum(qntde)'))
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        }])
        ->with('produto')
        ->orderBy('total_qntde', 'desc')
        ->take(10)
        ->get();

        $entregasChart = array();
        foreach ($produtosEntregues as $key => $produto) {
            if (array_key_exists($produto->produto->modelo_produto, $entregasChart)) {
                $entregasChart[$produto->produto->modelo_produto] += $produto->total_qntde;
            } else {
                $entregasChart[$produto->produto->modelo_produto] = $produto->total_qntde;
            }
        }

        $entregasFormatadas = "";

        foreach ($entregasChart as $key => $entrega) {
            if ($entrega == null) $entrega = 0;
            $entregasFormatadas .= "['".$key."', ".$entrega."],";
        }

        $entregasFormatadas = substr($entregasFormatadas, 0, -1);
        
        return view('home', compact('entregas', 'solicitacoes', 'usuarios', 'produtos', 'entregasUserCount', 'solicitacoesUserCount', 'solicitacoesChart', 'entregasFormatadas'));
    }
}
