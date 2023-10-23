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
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProdutoController extends Controller
{
    /**
     * Método construtor da classe
     */
    public function __construct(Produto $produto) {
        $this->produto = $produto;
    }

    /**
     * Realiza a listagem dos produtos em uma view
     */
    public function index()
    {
        $produtos = $this->produto->get();

        $heads = [
            'ID',
            'Tipo',
            'Modelo',
            'Quantidade',
            'Status',
            'Data de Criação',
            'Data de Edição',
            ['label' => 'Ações', 'no-export' => true, 'width' => '10'],
        ];

        foreach ($produtos as $produto)
        {
            $dataCriacao = date('d/m/Y',strtotime($produto->created_at));
            $dataEdicao = date('d/m/Y',strtotime($produto->updated_at));

            $btnEdit = '<a href="'.route("produtos.edit", ["produto" => $produto->id]).'"><button class="btn btn-sm btn-default text-primary mx-1 shadow" type="button" aria-label="Editar" title="Editar">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button></a>';
            $btnDelete = '<form action="'.route("produtos.destroy", ["produto" => $produto->id]).'" method="POST" id="form_'.$produto->id.'" style="display:inline">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <button class="btn btn-sm btn-default text-danger shadow" type="button" onclick="excluir('.$produto->id.')" aria-label="Excluir" title="Excluir">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                            </form>';
            $btnDetails = '<a href="'.route("produtos.show", ["produto" => $produto->id]).'"><button class="btn btn-sm btn-default text-teal mx-1 shadow" aria-label="Detalhes" title="Detalhes">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </button></a>';

            $data[] = [
                $produto->id,
                ucfirst(strtolower($produto->tipo_produto)),
                $produto->modelo_produto,
                $produto->qntde_estoque,
                ucfirst(strtolower($produto->status)),
                $dataCriacao,
                $dataEdicao,
                '<nobr>'.$btnEdit.$btnDetails.$btnDelete.'</nobr>'
            ];
        }

        $config = [
            'data' => $data,
            'dom' => '<"row" <"col-sm-12 d-flex justify-content-start" f>>t<"row" <"col-sm-6 d-flex justify-content-start" i> <"col-sm-6 d-flex justify-content-end" p>>',
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, null, null, ['orderable' => false]],
            "bLengthChange" => false,
            'language' => [
                'sEmptyTable' => "Nenhum registro encontrado",
                'sInfo' =>	"Mostrando de _START_ até _END_ de _TOTAL_ registros",
                'sInfoEmpty' =>	"Mostrando 0 até 0 de 0 registros",
                'sInfoFiltered' =>	"(Filtrados de _MAX_ registros)",
                "sInfoThousands" => ".",
                "sLengthMenu" => "_MENU_ resultados por página",
                "sLoadingRecords" => "Carregando...",
                "sProcessing" => "Processando...",
                "sZeroRecords" => "Nenhum registro encontrado",
                "sSearch" => "Pesquisa rápida: ",
                "oPaginate" => [
                    "sNext" => "Próximo",
                    "sPrevious" =>	"Anterior",
                    "sFirst" =>	"Primeiro",
                    "sLast" =>	"Último"
                ],
            ]
        ];

        return view('produto.index', ['heads' => $heads, 'config' => $config, 'produtos' => $produtos, 'titulo' => 'Produtos Cadastrados']);
    }

    /**
     * Mostra o formulário para cadastrar um novo produto
     */
    public function create()
    {
        return view('produto.create');
    }

    /**
     * Realiza o armazenamento do novo produto
     */
    public function store(Request $request)
    {
        $request->validate($this->produto->rules($request, 0), $this->produto->feedback());

        try{
            $produto = $this->produto->create($request->all());
        } catch (\Exception $e) {
            Log::channel('erros')->error($e->getMessage().' - Na linha: '.$e->getLine().' - No arquivo: '.$e->getFile());
            session()->flash('mensagem', 'Erro ao cadastrar o produto.');
            session()->flash('color', 'danger');
            return redirect()->route('produtos.index');
        }

        switch ($request->proximo) {
            case 'locais':
                return redirect()->route('locais.create', ['id' => $produto->id]);
                break;
            case 'impressoras':
                return redirect()->route('impressoras.create', ['id' => $produto->id]);
                break;
            case 'nenhum':
                session()->flash('mensagem', 'Produto cadastrado com sucesso!');
                session()->flash('color', 'success');
                return redirect()->route('produtos.index');
                break;
        }
    }

    /**
     * Exibe os dados de um produto
     */
    public function show($id)
    {
        $produto = $this->produto->with(['suprimentos'])->find($id);

        if ($produto == null) {
            session()->flash('mensagem', 'Produto não encontrado.');
            session()->flash('color', 'warning');
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
     * Mostra o formulário para editar um produto
     */
    public function edit($id)
    {
        $produto = $this->produto->find($id);

        if ($produto == null) {
            session()->flash('mensagem', 'Produto não encontrado.');
            session()->flash('color', 'warning');
            return redirect()->route('produtos.index');
        }

        return view('produto.edit', ['produto' => $produto]);
    }

    /**
     * Realiza a atualização de um produto
     */
    public function update(Request $request, $id)
    {
        $produto = $this->produto->find($id);

        if ($produto == null) {
            session()->flash('mensagem', 'Produto não encontrado.');
            session()->flash('color', 'warning');
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

                            $usuarioEmail = $solicitacao->usuario->email;
                            Mail::to($usuarioEmail)->send(new SolicitacaoLiberadaMail($solicitacao, $primeiroNome, $saudacao));

                            if ($solicitacao->divisao_id != null) {
                                $nomeDiv = $solicitacao->divisao->nome;
                                $divisaoEmail = Divisao::find($solicitacao->divisao_id)->email;
                                if ($divisaoEmail != null && $divisaoEmail != $usuarioEmail) {
                                    Mail::to($divisaoEmail)->send(new SolicitacaoLiberadaMail($solicitacao, $nomeDiv, $saudacao));
                                }
                            }

                            $diretoriaEmail = Diretoria::find($solicitacao->diretoria_id)->email;
                            if ($diretoriaEmail != null && $diretoriaEmail != $usuarioEmail && ($divisaoEmail == null || $divisaoEmail != null && $divisaoEmail != $diretoriaEmail)) {
                                Mail::to($diretoriaEmail)->send(new SolicitacaoLiberadaMail($solicitacao, $nomeDir, $saudacao));
                            }

                        } catch (\Exception $e) {
                            Log::channel('erros')->error($e->getMessage().' - Na linha: '.$e->getLine().' - No arquivo: '.$e->getFile());
                            session()->flash('mensagem', 'Erro ao enviar e-mails.');
                            session()->flash('color', 'danger');
                            return redirect()->route('produtos.index');
                        }
                    }
                }
            }
        }

        try {
            $produto->update($request->all());
        } catch (\Exception $e) {
            Log::channel('erros')->error($e->getMessage().' - Na linha: '.$e->getLine().' - No arquivo: '.$e->getFile());
            session()->flash('mensagem', 'Erro ao atualizar o produto.');
            session()->flash('color', 'danger');
            return redirect()->route('produtos.index');
        }

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
                session()->flash('mensagem', 'Produto alterado com sucesso!');
                session()->flash('color', 'success');
                return redirect()->route('produtos.index');
                break;
        }
    }

    /**
     * Remove o produto
     */
    public function destroy($id)
    {
        $produto = $this->produto->find($id);

        if($produto == null) {
            session()->flash('mensagem', 'Produto não encontrado.');
            session()->flash('color', 'warning');
            return redirect()->route('produtos.index');
        }

        try {
            $produto->delete();
        } catch (\Exception $e) {
            Log::channel('erros')->error($e->getMessage().' - Na linha: '.$e->getLine().' - No arquivo: '.$e->getFile());
            $mensagem = 'Erro ao excluir o produto. Provavelmente este produto está vinculado a uma solicitação ou entrega. Por favor, inative o produto ou exclua a(s) solicitação(ões) ou entrega(s).';
            session()->flash('mensagem', $mensagem);
            session()->flash('color', 'danger');
            return redirect()->route('produtos.index');
        }

        session()->flash('mensagem', 'Produto excluído com sucesso!');
        session()->flash('color', 'success');
        return redirect()->route('produtos.index');
    }

    /**
     * Retorna os toners cadastrados
     */
    public function toners()
    {
        $toners = $this->produto->select('id','modelo_produto', 'qntde_estoque')->where([['tipo_produto', 'TONER'], ['status', 'ATIVO']])->get();

        return response()->json($toners, 200);
    }

    /**
     * Retorna os cilindros cadastrados
     */
    public function cilindros()
    {
        $cilindros = $this->produto->select('id','modelo_produto', 'qntde_estoque')->where([['tipo_produto', 'CILINDRO'], ['status', 'ATIVO']])->get();

        return response()->json($cilindros, 200);
    }

    /**
     * Retorna um toner de acordo com o id da impressora
     */
    public function tonerPorImpressora($impressoraId) {

        $toner = $this->produto
            ->select('produtos.id', 'modelo_produto', 'qntde_estoque')
            ->where([['tipo_produto', 'TONER'], ['status', 'ATIVO']])
            ->join('suprimentos', 'produtos.id', '=', 'suprimento_id')
            ->where([['produto_id', $impressoraId],['em_uso', 'SIM']])
            ->orderBy('qntde_estoque', 'desc')->first();

        return response()->json($toner, 200);
    }

    /**
     * Retorna um cilindro de acordo com o id da impressora
     */
    public function cilindroPorImpressora($impressoraId) {
        $cilindro = $this->produto
            ->select('produtos.id', 'modelo_produto', 'qntde_estoque')
            ->where([['tipo_produto', 'CILINDRO'], ['status', 'ATIVO']])
            ->join('suprimentos', 'produtos.id', '=', 'suprimento_id')
            ->where([['produto_id', $impressoraId],['em_uso', 'SIM']])
            ->orderBy('qntde_estoque', 'desc')->first();

        return response()->json($cilindro, 200);
    }

    /**
     * Retorna um toner e um cilindro de acordo com o id da impressora
     */
    public function conjuntoPorImpressora($impressoraId) {
        $cilindro = $this->cilindroPorImpressora($impressoraId);
        $toner = $this->tonerPorImpressora($impressoraId);

        return response()->json([$toner, $cilindro], 200);
    }

    /**
     * Realiza a pesquisa por produto de acordo com os dados passados
     */
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
