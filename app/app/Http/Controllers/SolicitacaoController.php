<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;
use App\Models\ItensSolicitacao;
use App\Models\Entrega;
use App\Models\Produto;
use App\Models\Usuario;
use App\Models\Divisao;
use App\Models\Diretoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SolicitacaoController extends Controller
{
    public function __construct(Solicitacao $solicitacao, Produto $produto, ItensSolicitacao $itemSolicitacao, Entrega $entrega)
    {
        $this->solicitacao = $solicitacao;
        $this->produto = $produto;
        $this->itemSolicitacao = $itemSolicitacao;
        $this->entrega = $entrega;
    }
    
    public function abertas() {
        if (!Route::currentRouteNamed('minhas-solicitacoes.abertas')) {
            $solicitacoesAbertas = $this->solicitacao->with(['produtos', 'usuario', 'divisao', 'diretoria'])->where('status', 'ABERTO')->orWhere('status', 'LIBERADO')->orderBy('created_at', 'desc')->paginate(8);
            $rota = 'todas';
        } else {
            $solicitacoesAbertas = $this->solicitacao->with(['produtos', 'usuario', 'divisao', 'diretoria'])->where([['status', 'ABERTO'], ['usuario_id', auth()->user()->id]])->orWhere([['status', 'LIBERADO'],['usuario_id', auth()->user()->id]])->orderBy('created_at', 'desc')->paginate(8);
            $rota = 'minhas';
        }

        return view('solicitacao.index', ['solicitacoes' => $solicitacoesAbertas, 'titulo' => 'Solicitações Abertas', 'ativo' => 'abertas', 'rota' => $rota]);
    }

    public function aguardando() {
        if (!Route::currentRouteNamed('minhas-solicitacoes.aguardando')) {
            $solicitacoesAguardando = $this->solicitacao->with(['produtos', 'usuario', 'divisao', 'diretoria'])->where('status', 'AGUARDANDO')->orderBy('created_at', 'desc')->paginate(8);
            $rota = 'todas';
        } else {
            $solicitacoesAguardando = $this->solicitacao->with(['produtos', 'usuario', 'divisao', 'diretoria'])->where([['status', 'AGUARDANDO'], ['usuario_id', auth()->user()->id]])->orderBy('created_at', 'desc')->paginate(8);
            $rota = 'minhas';
        }

        return view('solicitacao.index', ['solicitacoes' => $solicitacoesAguardando, 'titulo' => 'Solicitações Aguardando', 'ativo' => 'aguardando', 'rota' => $rota]);
    }

    public function encerradas() {
        if (!Route::currentRouteNamed('minhas-solicitacoes.encerradas')) {
            $solicitacoesEncerradas = $this->solicitacao->with(['produtos', 'usuario', 'divisao', 'diretoria'])->where('status', 'ENCERRADO')->orderBy('created_at', 'desc')->paginate(8);
            $rota = 'todas';
        } else {
            $solicitacoesEncerradas = $this->solicitacao->with(['produtos', 'usuario', 'divisao', 'diretoria'])->where([['status', 'ENCERRADO'], ['usuario_id', auth()->user()->id]])->orderBy('created_at', 'desc')->paginate(8);
            $rota = 'minhas';
        }

        return view('solicitacao.index', ['solicitacoes' => $solicitacoesEncerradas, 'titulo' => 'Solicitações Encerradas', 'ativo' => 'encerradas', 'rota' => $rota]);
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

            $totalSolicitado = intval($this->itemSolicitacao->where('produto_id', $dados['produto_id'])->sum('qntde'));
            $totalEstoque = $this->produto->find($dados['produto_id'])->qntde_estoque;

            if($totalSolicitado > $totalEstoque)
            {
                $solicitacao->status = 'AGUARDANDO';
                $solicitacao->save();
            }
        }

        return redirect()->route('solicitacoes.abertas');
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
    public function edit($id)
    {
        $solicitacao = $this->solicitacao->with(['produtos', 'usuario', 'divisao', 'diretoria', 'entregas'])->find($id);

        if($solicitacao === null) {
            return redirect()->back();
        }

        foreach($solicitacao->entregas as $entrega) {
            if($entrega->observacao != null) {
                $solicitacao->observacaoEntrega = $entrega->observacao;
            }
        }
        return view('solicitacao.edit', ['solicitacao' => $solicitacao]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Solicitacao  $solicitacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $solicitacao = $this->solicitacao->with(['produtos', 'usuario', 'divisao', 'diretoria', 'entregas'])->find($id);

        if($solicitacao === null) {
            return redirect()->back();
        } 

        DB::beginTransaction();

        try {
            $solicitacao->status = $request->status;

            $solicitacao->save();

            foreach ($request->produto as $key => $produto) {
                $produtoEstoque = $this->produto->find($produto);

                if($produtoEstoque->qntde_estoque < $request->qntde_atendida[$key]) {
                    $ordem = $key + 1;
                    DB::rollBack();
                    return redirect()->back()->withErrors("Não é possível atender a solicitação pois o ".$ordem."º produto não possui estoque suficiente.");
                }
                
                if(isset($solicitacao->entregas[$key])) {
                    $entrega = $this->entrega->find($solicitacao->entregas[$key]->id);

                    if($request->qntde_atendida[$key] == 0) {
                        $produtoEstoque->qntde_estoque += $entrega->qntde;

                        $entrega->delete();
                    } else {
                        if($entrega->qntde > $request->qntde_atendida[$key]) {
                            $produtoEstoque->qntde_estoque += $entrega->qntde - $request->qntde_atendida[$key];
                        } else {
                            $produtoEstoque->qntde_estoque -= $request->qntde_atendida[$key] - $entrega->qntde;
                        }

                        $entrega->qntde = $request->qntde_atendida[$key];
                        $entrega->observacao = $request->observacao;

                        $entrega->save();
                    }
                } else {
                    if($request->qntde_atendida[$key] != 0) {
                        $itemSolicitacao = $this->itemSolicitacao->where([['solicitacao_id', $solicitacao->id], ['produto_id', $produto]])->first();

                        $solicitacao->produtos[$key]->qntde_estoque -= $request->qntde_atendida[$key];

                        $produtoEstoque->qntde_estoque -= $request->qntde_atendida[$key];

                        $entrega= $this->entrega->create([
                            'solicitacao_id' => $solicitacao->id,
                            'itens_solicitacao_id' => $itemSolicitacao->id,
                            'qntde' => $request->qntde_atendida[$key],
                            'observacao' => $request->observacao,
                            'usuario_id' => auth()->user()->id,
                        ]);
                    }
                }
                $produtoEstoque->save();
            }

            DB::commit();
            return redirect()->route('solicitacoes.abertas');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Solicitacao  $solicitacao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $solicitacao = $this->solicitacao->with(['produtos', 'entregas', 'itens_solicitacoes'])->find($id);

        if($solicitacao === null) {
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            if($solicitacao->entregas != null) {
                foreach($solicitacao->entregas as $entrega) {
                    $itemSolicitacao = ItensSolicitacao::with('produto')->find($entrega->itens_solicitacao_id);
                    $produto = $itemSolicitacao->produto;
                    $produto->qntde_estoque += $entrega->qntde;
                    $produto->save();

                    $entrega->delete();
                }
            }

            if($solicitacao->itens_solicitacoes != null) {
                foreach($solicitacao->itens_solicitacoes as $itemSolicitacao) {
                    $itemSolicitacao->delete();
                }
            }
            $solicitacao->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }

        DB::commit();
        return redirect()->route('solicitacoes.abertas');
    }
}
