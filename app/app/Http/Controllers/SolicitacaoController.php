<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;
use App\Models\ItensSolicitacao;
use App\Models\Produto;
use App\Models\Usuario;
use App\Models\Divisao;
use App\Models\Diretoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SolicitacaoController extends Controller
{
    public function __construct(Solicitacao $solicitacao, Produto $produto, ItensSolicitacao $itemSolicitacao)
    {
        $this->solicitacao = $solicitacao;
        $this->produto = $produto;
        $this->itemSolicitacao = $itemSolicitacao;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitacoes = $this->solicitacao->paginate(10);

        foreach($solicitacoes as $solicitacao) 
        {
            $solicitacao->nome_usuario = Usuario::find($solicitacao->usuario_id)->nome;
            if($solicitacao->divisao_id != null)
            {
                $solicitacao->nome_divisao = Divisao::find($solicitacao->divisao_id)->nome;
            }
            $solicitacao->nome_diretoria = Diretoria::find($solicitacao->diretoria_id)->nome;
        }

        return view('solicitacao.index', ['solicitacoes' => $solicitacoes, 'titulo' => 'Solicitações Cadastradas']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuario = new \stdClass;
        $usuario->id = auth()->user()->id;
        $usuario->nome = auth()->user()->nome;
        $usuario->diretoria_id = auth()->user()->diretoria_id;
        $usuario->divisao_id = auth()->user()->divisao_id;

        if(auth()->user()->user_interno == 'NAO') {
            $impressoras = $this->produto
                ->select('produtos.id', 'modelo_produto')
                ->where([['tipo_produto', 'IMPRESSORA'],['status', 'ATIVO']])
                ->join('local_impressoras','produtos.id', '=', 'produto_id');

            if(auth()->user()->divisao_id != null)
            {
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

        $divisoes = Divisao::where([['status', 'ATIVO'],['diretoria_id', $usuario->diretoria_id]])->orderBy('nome')->get();
        $diretorias = Diretoria::where('status', 'ATIVO')->orderBy('nome')->get();
        $usuarios = Usuario::where('status', 'ATIVO')->orderBy('nome')->get();

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
        $request->validate($this->solicitacao->rules(),$this->solicitacao->feedback());
        if($request->produto == null || $request->quantidade == null) {
            return redirect()->back()->withErrors('Insira pelo menos um produto para criar uma solicitação');
        }

        if(!isset($request->usuario_id)) {
            $divisao = auth()->user()->divisao_id;
            $diretoria = auth()->user()->diretoria_id;
            $usuario = auth()->user()->id;
        } else {
            $divisao = $request->divisao_id != 0 ? $request->divisao_id : null;
            $diretoria = $request->diretoria_id;
            $usuario = $request->usuario_id;
        }

        $solicitacao = $this->solicitacao->create([
            'status'       => 'ABERTO',
            'observacao'   => $request->observacao,
            'usuario_id'   => $usuario, 
            'divisao_id'   => $divisao, 
            'diretoria_id' => $diretoria, 
        ]);

        foreach ($request->produto as $i => $produto) {
            $dados = array('produto_id' => $produto, 'qntde' => $request->quantidade[$i], 'solicitacao_id' => $solicitacao->id);

            $validacao = Validator::make($dados, $this->itemSolicitacao->rules(), $this->itemSolicitacao->feedback());

            if($validacao->fails())
            {
                return redirect()->back()->withErrors($validacao->errors())->withInput();
            }

            $itemSolicitacao = $this->itemSolicitacao->create($dados);

            $totalSolicitado = $this->itemSolicitacao->where('produto_id', $dados->produto_id)->sum('qntde');
            $totalEstoque = $this->produto->find($dados->produto_id)->qntde_estoque;

            if($totalSolicitado > $totalEstoque)
            {
                $solicitacao->status = 'AGUARDANDO';
                $solicitacao->save();
            }
        }

        return redirect()->route('solicitacoes.index');
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
