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

                            $id = $solicitacao->id;

                            $usuarioEmail = Usuario::find($solicitacao->usuario_id)->email;
                            Mail::raw("$saudacao, $primeiroNome! sua solicitação #$id foi liberada e está disponível para retirada.
                                    \n\n Atenciosamente, \n Equipe de TI", function ($message) use ($usuarioEmail, $id) {
                                $message->to($usuarioEmail)
                                ->subject("Solicitação #$id Liberada!");
                            });

                            $diretoriaEmail = Diretoria::find($solicitacao->diretoria_id)->email;
                            if ($diretoriaEmail != null && $diretoriaEmail != $usuarioEmail) {
                                Mail::raw("$saudacao, $nomeDir! sua solicitação #$id foi liberada e está disponível para retirada.
                                    \n\n Atenciosamente, \n Equipe de TI", function ($message) use ($diretoriaEmail, $id) {
                                    $message->to($diretoriaEmail)
                                    ->subject("Solicitação #$id liberada!");
                                });
                            }
                        
                            if ($solicitacao->divisao_id != null) {
                                $divisaoEmail = Divisao::find($solicitacao->divisao_id)->email;
                                if ($divisaoEmail != null && $divisaoEmail != $diretoriaEmail && $divisaoEmail != $usuarioEmail) {
                                    Mail::raw("$saudacao, $nomeDiv! sua solicitação #$id foi liberada e está disponível para retirada.
                                        \n\n atenciosamente \n Equipe de TI", function ($message) use ($divisaoEmail, $id) {
                                        $message->to($divisaoEmail)
                                        ->subject("Solicitação #$id liberada!");
                                    });
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
}