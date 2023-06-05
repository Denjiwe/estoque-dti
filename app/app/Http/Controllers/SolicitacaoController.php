<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;
use App\Models\Produto;
use App\Models\Usuario;
use App\Models\Divisao;
use App\Models\Diretoria;
use Illuminate\Http\Request;

class SolicitacaoController extends Controller
{
    public function __construct(Solicitacao $solicitacao, Produto $produto)
    {
        $this->solicitacao = $solicitacao;
        $this->produto = $produto;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuario = new \stdClass;
        $usuario->diretoria_id = auth()->user()->diretoria_id;
        $usuario->id = auth()->user()->id;
        $usuario->nome = auth()->user()->nome;

        if(auth()->user()->user_interno == 'NAO') {
            $impressoras = $this->produto
                ->select('produtos.id', 'modelo_produto')
                ->where([['tipo_produto', 'IMPRESSORA'],['status', 'ATIVO']])
                ->join('local_impressoras','produtos.id', '=', 'produto_id');

            if(auth()->user()->divisao_id != null)
            {
                $usuario->divisao_id = auth()->user()->divisao_id;
                $impressoras = $impressoras->where('divisao_id', $usuario->divisao_id)->get();
                
            } else {
                $impressoras = $impressoras->where('diretoria_id', $usuario->diretoria_id)->get();
            }
        } else {
            $impressoras = $this->produto
                ->select('produtos.id', 'modelo_produto')
                ->where([['tipo_produto', 'IMPRESSORA'],['status', 'ATIVO']])
                ->get();
        }

        $divisoes = Divisao::where('status', 'ATIVO')->get();
        $diretorias = Diretoria::where('status', 'ATIVO')->get();
        $usuarios = Usuario::where('status', 'ATIVO')->get();

        return view('solicitacao.create', ['impressoras' => $impressoras, 'usuario' => $usuario, 'usuarios' => $usuarios, 'diretorias' => $diretorias, 'divisoes' => $divisoes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Solicitacao  $solicitacao
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitacao $solicitacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Solicitacao  $solicitacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Solicitacao $solicitacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Solicitacao  $solicitacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitacao $solicitacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Solicitacao  $solicitacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Solicitacao $solicitacao)
    {
        //
    }

    public function minhasSolicitacoes() {
        return view('solicitacao.minhas-solicitacoes');
    }
}
