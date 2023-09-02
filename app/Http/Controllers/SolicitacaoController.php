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

        try {
            $solicitacao = $this->solicitacao->create([
                'status'       => 'ABERTO',
                'observacao'   => $request->observacao,
                'usuario_id'   => $usuario, 
                'divisao_id'   => $divisao, 
                'diretoria_id' => $diretoria, 
            ]);

            foreach ($request->produto as $i => $produtoId) {
                $dados = array('produto_id' => $produtoId, 'qntde' => $request->quantidade[$i], 'solicitacao_id' => $solicitacao->id);

                $validacao = Validator::make($dados, $this->itemSolicitacao->rules(), $this->itemSolicitacao->feedback());

                if($validacao->fails())
                {
                    return redirect()->back()->withErrors($validacao->errors())->withInput();
                }

                $itemSolicitacao = $this->itemSolicitacao->create($dados);

                $produto = $this->produto->find($produtoId);
                $produto->qntde_solicitada += $request->quantidade[$i];
                $produto->save();

                if($produto->qntde_solicitada > $produto->qntde_estoque)
                {
                    $solicitacao->status = 'AGUARDANDO';
                    $solicitacao->save();
                }
            }
        } catch (\Exception $e) {
            session()->flash('mensagem', 'Erro ao cadastrar solicitação!');
            session()->flash('color', 'danger');
            if (auth()->user()->user_interno == 'NAO') {
                return redirect()->route('minhas-solicitacoes.abertas');
            } else {
                return redirect()->route('solicitacoes.abertas');
            }
        }

        $mensagem = 'Solicitação #'.$solicitacao->id.' cadastrada com sucesso!';
        session()->flash('mensagem', $mensagem);
        session()->flash('color', 'success');
        if (auth()->user()->user_interno == 'NAO') {
            return redirect()->route('minhas-solicitacoes.abertas');
        } else {
            return redirect()->route('solicitacoes.abertas');
        }
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
            session()->flash('mensagem', 'Solicitação não encontrada!');
            session()->flash('color', 'warning');
            return redirect()->route('solicitacoes.abertas');
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
        $solicitacao = $this->solicitacao->with(['produtos', 'usuario', 'divisao', 'diretoria', 'entregas', 'itens_solicitacoes'])->find($id);

        if($solicitacao === null) {
            session()->flash('mensagem', 'Solicitação não encontrada!');
            session()->flash('color', 'warning');
            return redirect()->route('solicitacoes.abertas');
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
                            $produtoEstoque->qntde_solicitada += $entrega->qntde - $request->qntde_atendida[$key];
                        } else {
                            $produtoEstoque->qntde_estoque -= $request->qntde_atendida[$key] - $entrega->qntde;
                            $produtoEstoque->qntde_solicitada -= $request->qntde_atendida[$key] - $entrega->qntde;
                        }

                        $entrega->qntde = $request->qntde_atendida[$key];
                        $entrega->observacao = $request->observacao;

                        $entrega->save();
                    }
                } else {
                    if($request->qntde_atendida[$key] != 0) {
                        $itemSolicitacao = $this->itemSolicitacao->where([['solicitacao_id', $solicitacao->id], ['produto_id', $produto]])->first();

                        $produtoEstoque->qntde_estoque -= $request->qntde_atendida[$key];
                        
                        $produtoEstoque->qntde_solicitada -= $request->qntde_atendida[$key];

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
            $mensagem = 'Solicitação #'.$solicitacao->id.' atualizada com sucesso!';
            session()->flash('mensagem', $mensagem);
            session()->flash('color', 'success');
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
            session()->flash('mensagem', 'Solicitação não encontrada!');
            session()->flash('color', 'warning');
            return redirect()->route('solicitacoes.abertas');
        }

        DB::beginTransaction();
        try {
            if(count($solicitacao->entregas) != 0) {
                foreach($solicitacao->entregas as $entrega) {
                    $itemSolicitacao = ItensSolicitacao::with('produto')->find($entrega->itens_solicitacao_id);
                    $produto = $itemSolicitacao->produto;
                    $produto->qntde_estoque += $entrega->qntde;
                    $produto->save();

                    $entrega->delete();
                    $itemSolicitacao->delete();
                }
            } else {
                foreach($solicitacao->itens_solicitacoes as $itemSolicitacao) {
                    $produto = $this->produto->find($itemSolicitacao->produto->id);
                    $produto->qntde_solicitada -= $itemSolicitacao->qntde;
                    $produto->save();

                    $itemSolicitacao->delete();
                }
            }

            $solicitacao->delete();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('mensagem', 'Erro ao excluir a solicitação.');
            session()->flash('color', 'danger');
            return redirect()->route('solicitacoes.abertas');
        }

        DB::commit();
        $mensagem = 'Solicitação #'.$id.' excluída com sucesso!';
        session()->flash('mensagem', $mensagem);
        session()->flash('color', 'success');
        return redirect()->route('solicitacoes.abertas');
    }

    public function pesquisa(Request $request) {
        switch (true) {
            case isset($request->id):
                $solicitacoes = $this->solicitacao->where('id', $request->id)->paginate(10);
                $resposta = 'Resultado da Pesquisa pelo ID '.$request->id;
                break;
            case isset($request->nome):
                $solicitacoes = $this->solicitacao->whereHas('usuario', function($query) use ($request) {
                    $query->where('nome', 'like', '%'.$request->nome.'%');
                })->paginate(10);
                $resposta = 'Resultado da Pesquisa por Nome: '.$request->nome;
                break;
            case isset($request->status):
                $solicitacoes = $this->solicitacao->where('status', $request->status)->paginate(10);
                $resposta = 'Resultado da Pesquisa por Status '.ucfirst(strtolower($request->status));
                break;
            case isset($request->diretoria):
                $solicitacoes = $this->solicitacao->whereHas('diretoria', function($query) use ($request) {
                    $query->where('nome', 'like', '%'.$request->diretoria.'%');
                })->paginate(10);
                $resposta = 'Resultado da Pesquisa por Nome da Diretoria: '.$request->diretoria;
                break;
            case isset($request->divisao):
                $solicitacoes = $this->solicitacao->whereHas('divisao', function($query) use ($request) {
                    $query->where('nome', 'like', '%'.$request->divisao.'%');
                })->paginate(10);
                if($request->divisao == 'Nenhuma' || $request->divisao == 'nenhuma') {
                    $solicitacoes = $this->solicitacao->where('divisao_id', null)->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Nome da Divisão: '.$request->divisao;
                break;
            case isset($request->data_criacao_inicio):
                if(!isset($request->data_criacao_fim)) {
                    $timestamp = Carbon::createFromFormat('Y-m-d', $request->data_criacao_inicio)->startOfDay();
                    $solicitacoes = $this->solicitacao->whereDate('created_at', $timestamp)->paginate(10);
                } else {
                    $solicitacoes = $this->solicitacao->whereBetween('created_at', [$request->data_criacao_inicio, $request->data_criacao_fim])->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Data de Criação';
                break;
            case isset($request->data_edicao_inicio):
                if(!isset($request->data_edicao_fim)) {
                    $timestamp = Carbon::createFromFormat('Y-m-d', $request->data_edicao_inicio)->startOfDay();
                    $solicitacoes = $this->solicitacao->whereDate('updated_at', $timestamp)->paginate(10);
                } else {
                    $solicitacoes = $this->solicitacao->whereBetween('updated_at', [$request->data_edicao_inicio, $request->data_edicao_fim])->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Data de Atualização';
                break;
            default:
                return redirect()->back()->withErrors('Erro ao pesquisar, tente novamente.');
                break;
        }

        return view('solicitacao.pesquisa', ['solicitacoes' => $solicitacoes, 'titulo' => $resposta]);
    }
}
