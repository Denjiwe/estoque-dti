<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Divisao;
use App\Models\Usuario;
use App\Models\Suprimento;
use App\Models\Diretoria;
use App\Models\ItensSolicitacao;
use App\Models\Solicitacao;
use App\Mail\SolicitacaoLiberadaMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProdutoController extends Controller
{
    public function __construct(Produto $produto) {
        $this->produto = $produto;
    }

    // /======================================== Funções Resource ========================================/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = $this->produto->paginate(10);

        return view('produto.index', ['produtos' => $produtos, 'titulo' => 'Produtos Cadastrados']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->produto->rules($request, 0), $this->produto->feedback());

        $produto = $this->produto->create($request->all());

        // return response()->json($produto, 201);
        switch ($request->proximo) {
            case 'locais':
                // caso seja uma impressora
                return redirect()->route('locais.create', ['id' => $produto->id]);
                break;
            case 'impressoras':
                // caso seja um toner ou cilíndro
                return redirect()->route('impressoras.create', ['id' => $produto->id]);
                break;
            case 'nenhum':
                // caso seja outros
                return redirect()->route('produtos.index');
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = $this->produto->with(['suprimentos'])->find($id);

        if ($produto == null) {
            return redirect()->route('produtos.index');
        }

        if($produto->tipo_produto == 'TONER' || $produto->tipo_produto == 'CILINDRO') {
            $produto->qntde_solicitada = intval(ItensSolicitacao::where('produto_id', $produto->id)->sum('qntde'));
        }

        $diretorias = Diretoria::where('status', 'ATIVO')->get();
        $divisoes = Divisao::where('status', 'ATIVO')->get();
        $suprimentos = Suprimento::where('suprimento_id',$id)->get();
        foreach ($suprimentos as $key => $suprimento) {
            $nome = $this->produto->select('modelo_produto')->find($suprimento->suprimento_id);
            $suprimento['nome_produto'] = $nome['modelo_produto'];
        }
        $toners = $this->produto->where([['status', 'ATIVO'],['tipo_produto', 'TONER']])->get();
        $cilindros = $this->produto->where([['status', 'ATIVO'],['tipo_produto', 'CILINDRO']])->get();
        $impressoras = $this->produto->where([['status', 'ATIVO'],['tipo_produto', 'IMPRESSORA']])->get();

        return view('produto.detalhes', [
            'produto' => $produto, 
            'diretorias' => $diretorias, 
            'divisoes' => $divisoes, 
            'suprimentos' => $suprimentos, 
            'toners' => $toners, 
            'cilindros' => $cilindros,
            'impressoras' => $impressoras
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produto = $this->produto->find($id);

        if ($produto == null) {
            return redirect()->route('produtos.index');
        }

        return view('produto.edit', ['produto' => $produto]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produto = $this->produto->find($id);

        if ($produto == null) {
            return redirect()->route('produtos.index');
        }

        $request->validate($this->produto->rules($request, $produto->id), $this->produto->feedback());

        if(($produto->tipo_produto == 'TONER' || $produto->tipo_produto == 'CILINDRO') && $request->qntde_estoque > $produto->qntde_estoque){
            if($produto->qntde_solicitada <= $request->qntde_estoque){
                $solicitacoes = Solicitacao::where('status', 'AGUARDANDO')->with(['produtos', 'usuario', 'divisao', 'diretoria'])->get();

                foreach ($solicitacoes as $solicitacao) {
                    if ($solicitacao->produtos->contains($produto->id)) {
                        $solicitacao->status = 'LIBERADO';
                        $solicitacao->save();

                        try {
                            $primeiroNome = explode(' ', $solicitacao->usuario->nome)[0];
                            $nomeDir = $solicitacao->diretoria->nome;
                            $nomeDiv = $solicitacao->divisao->nome;

                            $horario = date('G');

                            switch(true) {
                                case $horario >= 0 && $horario < 12:
                                    $saudacao = 'Bom dia';
                                    break;
                                case $horario >= 12 && $horario < 18:
                                    $saudacao = 'Boa tarde';
                                    break;
                                case $horario >= 18 && $horario < 24:
                                    $saudacao = 'Boa noite';
                                    break;
                            }

                            $usuarioEmail = Usuario::find($solicitacao->usuario_id)->email;
                            Mail::to($usuarioEmail)->send(new SolicitacaoLiberadaMail($solicitacao, $primeiroNome, $saudacao));

                            $diretoriaEmail = Diretoria::find($solicitacao->diretoria_id)->email;
                            if ($diretoriaEmail != null && $diretoriaEmail != $usuarioEmail) {
                                Mail::to($diretoriaEmail)->send(new SolicitacaoLiberadaMail($solicitacao, $nomeDir, $saudacao));
                            }
                        
                            if ($solicitacao->divisao_id != null) {
                                $divisaoEmail = Divisao::find($solicitacao->divisao_id)->email;
                                if ($divisaoEmail != null && $divisaoEmail != $diretoriaEmail && $divisaoEmail != $usuarioEmail) {
                                    Mail::to($divisaoEmail)->send(new SolicitacaoLiberadaMail($solicitacao, $nomeDiv, $saudacao));
                                }
                            }
                        } catch (\Throwable $th) {
                            throw $th;
                        }
                    }
                }
            }
        }

        $produto->update($request->all());

        // return response()->json($produto, 201);
        switch ($request->proximo) {
            case 'locais':
                // caso seja uma impressora
                return redirect()->route('locais.create', ['id' => $produto->id]);
                break;
            case 'impressoras':
                // caso seja um toner ou cilíndro
                return redirect()->route('impressoras.create', ['id' => $produto->id]);
                break;
            case 'nenhum':
                // caso seja outros
                return redirect()->route('produtos.index');
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = $this->produto->find($id);

        $produto->delete();

        return redirect()->route('produtos.index');
    }

    // /======================================== Funções Manuais ========================================/

    public function toners()
    {
        $toners = $this->produto->select('id','modelo_produto', 'qntde_estoque')->where([['tipo_produto', 'TONER'], ['status', 'ATIVO']])->get();

        return response()->json($toners, 200);
    }
    
    public function cilindros()
    {
        $cilindros = $this->produto->select('id','modelo_produto', 'qntde_estoque')->where([['tipo_produto', 'CILINDRO'], ['status', 'ATIVO']])->get();

        return response()->json($cilindros, 200);
    }

    public function tonerPorImpressora($impressoraId) {

        $toner = $this->produto
            ->select('produtos.id', 'modelo_produto', 'qntde_estoque')
            ->where([['tipo_produto', 'TONER'], ['status', 'ATIVO']])
            ->join('suprimentos', 'produtos.id', '=', 'suprimento_id')
            ->where([['produto_id', $impressoraId],['em_uso', 'SIM']])
            ->orderBy('qntde_estoque', 'desc')->first();

        return response()->json($toner, 200);
    }

    public function cilindroPorImpressora($impressoraId) {
        $cilindro = $this->produto
            ->select('produtos.id', 'modelo_produto', 'qntde_estoque')
            ->where([['tipo_produto', 'CILINDRO'], ['status', 'ATIVO']])
            ->join('suprimentos', 'produtos.id', '=', 'suprimento_id')
            ->where([['produto_id', $impressoraId],['em_uso', 'SIM']])
            ->orderBy('qntde_estoque', 'desc')->first();

        return response()->json($cilindro, 200);
    }       

    public function pesquisa(Request $request) {
        switch (true) {
            case isset($request->id):
                $produtos = $this->produto->where('id', $request->id)->paginate(10);
                $resposta = 'Resultado da Pesquisa pelo ID '.$request->id;
                break;
            case isset($request->tipo):
                $produtos = $this->produto->where('tipo_produto', $request->tipo)->paginate(10);
                $resposta = 'Resultado da Pesquisa pelo tipo '.ucfirst(strtolower($request->tipo));
                break;
            case isset($request->modelo):
                $produtos = $this->produto->where('modelo_produto', 'like', '%'.$request->modelo.'%')->paginate(10);
                $resposta = 'Resultado da Pesquisa pelo modelo: '.$request->modelo;
                break;
            case isset($request->quantidade):
                $produtos = $this->produto->where('qntde_estoque', $request->quantidade)->paginate(10);
                $resposta = 'Resultado da Pesquisa pela quantidade '.$request->quantidade;
                break;
            case isset($request->status):
                $produtos = $this->produto->where('status', $request->status)->paginate(10);
                $resposta = 'Resultado da Pesquisa pelo status '.ucfirst(strtolower($request->status));
                break;
            case isset($request->data_criacao_inicio):
                if(!isset($request->data_criacao_fim)) {
                    $timestamp = Carbon::createFromFormat('Y-m-d', $request->data_criacao_inicio)->startOfDay();
                    $produtos = $this->produto->whereDate('created_at', $timestamp)->paginate(10);
                } else {
                    $produtos = $this->produto->whereBetween('created_at', [$request->data_criacao_inicio, $request->data_criacao_fim])->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Data de Criação';
                break;
            case isset($request->data_edicao_inicio):
                if(!isset($request->data_edicao_fim)) {
                    $timestamp = Carbon::createFromFormat('Y-m-d', $request->data_edicao_inicio)->startOfDay();
                    $produtos = $this->produto->whereDate('updated_at', $timestamp)->paginate(10);
                } else {
                    $produtos = $this->produto->whereBetween('updated_at', [$request->data_edicao_inicio, $request->data_edicao_fim])->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Data de Atualização';
                break;
            default:
                return redirect()->back()->withErrors('Erro ao pesquisar, tente novamente.');
                break;
        }

        return view('produto.pesquisa', ['produtos' => $produtos, 'titulo' => $resposta]);
    }
}