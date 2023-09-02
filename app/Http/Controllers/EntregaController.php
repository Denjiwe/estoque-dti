<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use App\Models\Usuario;
use App\Models\Solicitacao;
use App\Models\Diretoria;
use App\Models\Divisao;
use App\Models\Produto;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EntregaController extends Controller
{
    public function __construct(Entrega $entrega, Produto $produto) {
        $this->entrega = $entrega;
        $this->produto = $produto;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entregas = $this->entrega->with(['usuario', 'itens_solicitacao', 'solicitacao'])->orderBy('created_at', 'desc')->paginate(10);

        foreach($entregas as $entrega) {
            $usuarioSolicitante = Usuario::find($entrega->solicitacao->usuario_id);

            $entrega->solicitacao->usuario = $usuarioSolicitante;
        }

        return view('entrega.index', ['entregas' => $entregas, 'titulo' => 'Entregas']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entrega = $this->entrega->with(['usuario', 'itens_solicitacao', 'solicitacao'])->find($id);

        if ($entrega == null) {
            session::flash('mensagem', 'Entrega não encontrada!');
            session::flash('color', 'danger');
            return redirect()->route('entregas.index');
        }

        return view('entrega.show', ['entrega' => $entrega, 'titulo' => 'Visualizar Entrega '.$entrega->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function edit(Entrega $entrega)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entrega $entrega)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entrega = $this->entrega->with('produto')->find($id);

        $produtoEstoque = $this->produto->find($entrega->produto->id);
        $produtoEstoque->qntde_estoque += $entrega->qntde;
        $produtoEstoque->save();

        $entrega->delete();

        session::flash('mensagem', 'Entrega excluída com sucesso!');
        session::flash('color', 'success');
        return redirect()->route('entregas.index');
    }

    public function pesquisa(Request $request) {
        switch (true) {
            case isset($request->id): // id
                $entregas = $this->entrega->where('id', $request->id)->paginate(10);
                $resposta = 'Resultado da Pesquisa pelo ID '.$request->id;
                break;
            case isset($request->solicitacao): // código da solicitação
                $entregas = $this->entrega->whereHas('solicitacao', function($query) use ($request) {
                    $query->where('solicitacoes.id', $request->solicitacao);
                })->paginate(10);
                $resposta = 'Resultado da Pesquisa pelo código da solicitação: '.$request->solicitacao;
                break;
            case isset($request->interno):
                $entregas = $this->entrega->whereHas('usuario', function($query) use ($request) {
                    $query->where('usuarios.nome', $request->interno);
                })->paginate(10);

                $resposta = 'Resultado da Pesquisa pelo nome do usuário interno: '.$request->interno;
                break;
            case isset($request->solicitante):
                $usuarios = Usuario::where('nome', 'like', '%'.$request->solicitante.'%')->get();
                if($usuarios->isEmpty()) {
                    $entregas = $this->entrega->where('id', 0)->paginate(10);
                } 
                $pesquisa = new Collection();
                foreach($usuarios as $usuario) {
                    $solicitacoes = Solicitacao::with('itens_solicitacoes')->where('usuario_id', $usuario->id)->get();
                    foreach($solicitacoes as $solicitacao) {
                        foreach($solicitacao->itens_solicitacoes as $itemSolicitacao) {
                            $entregas = $this->entrega->where('itens_solicitacao_id', $itemSolicitacao->id)->paginate(10);

                            $pesquisa = $pesquisa->concat($entregas);
                        }
                    }
                }
                $entregas = new LengthAwarePaginator(
                    $pesquisa, 
                    count($pesquisa),
                    $entregas->perPage(),
                    $entregas->currentPage(),
                    ['path' => $request->url(), 'pageName' => 'page']
                );

                $resposta = 'Resultado da Pesquisa pelo nome do usuário solicitante: '.$request->solicitante;
                break;
            case isset($request->diretoria): // nome da diretoria
                $diretorias = Diretoria::where('nome', 'like', '%'.$request->diretoria.'%')->get();
                if($diretorias->isEmpty()) {
                    $entregas = $this->entrega->where('id', 0)->paginate(10);
                }
                $pesquisa = new Collection();
                foreach($diretorias as $diretoria) {
                    $solicitacoes = Solicitacao::with('itens_solicitacoes')->where('diretoria_id', $diretoria->id)->get();
                    foreach($solicitacoes as $solicitacao) {
                        foreach($solicitacao->itens_solicitacoes as $itemSolicitacao) {
                            $entregas = $this->entrega->where('itens_solicitacao_id', $itemSolicitacao->id)->paginate(10);

                            $pesquisa = $pesquisa->concat($entregas);
                        }
                    }
                }
                $entregas = new LengthAwarePaginator(
                    $pesquisa, 
                    count($pesquisa),
                    $entregas->perPage(),
                    $entregas->currentPage(),
                    ['path' => $request->url(), 'pageName' => 'page']
                );

                $resposta = 'Resultado da Pesquisa pelo nome da diretoria: '.$request->diretoria;
                break;
            case isset($request->divisao): // nome da divisão
                $divisoes = Divisao::where('nome', 'like', '%'.$request->divisao.'%')->get();
                if($divisoes->isEmpty()) {
                    $entregas = $this->entrega->where('id', 0)->paginate(10);
                }
                $pesquisa = new Collection();
                foreach($divisoes as $divisao) {
                    $solicitacoes = Solicitacao::with('itens_solicitacoes')->where('divisao_id', $divisao->id)->get();
                    foreach($solicitacoes as $solicitacao) {
                        foreach($solicitacao->itens_solicitacoes as $itemSolicitacao) {
                            $entregas = $this->entrega->where('itens_solicitacao_id', $itemSolicitacao->id)->paginate(10);

                            $pesquisa = $pesquisa->concat($entregas);
                        }
                    }
                }
                $entregas = new LengthAwarePaginator(
                    $pesquisa, 
                    count($pesquisa),
                    $entregas->perPage(),
                    $entregas->currentPage(),
                    ['path' => $request->url(), 'pageName' => 'page']
                );

                if($request->divisao == 'Nenhuma') {
                    $entregas = $this->entrega->where('divisao_id', null)->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa pelo nome da divisão: '.$request->divisao;
                break;
            case isset($request->produto): 
                $entregas = $this->entrega->whereHas('produto', function($query) use ($request) {
                    $query->where('produtos.modelo_produto', 'like', '%'.$request->produto.'%');
                })->paginate(10);
                $resposta = 'Resultado da Pesquisa pelo nome do Produto: '.$request->produto;
                break;
            case isset($request->data_criacao_inicio): // data de entrega
                if(!isset($request->data_criacao_fim)) {
                    $timestamp = Carbon::createFromFormat('Y-m-d', $request->data_criacao_inicio)->startOfDay();
                    $entregas = $this->entrega->whereDate('created_at', $timestamp)->paginate(10);
                } else {
                    $entregas = $this->entrega->whereBetween('created_at', [$request->data_criacao_inicio, $request->data_criacao_fim])->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Data de Criação';
                break;
            default:
                return redirect()->back()->withErrors('Erro ao pesquisar, tente novamente.');
                break;
        }

        return view('entrega.pesquisa', ['entregas' => $entregas, 'titulo' => $resposta]);
    }
}
