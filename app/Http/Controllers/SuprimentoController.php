<?php

namespace App\Http\Controllers;

use App\Models\Suprimento;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SuprimentoController extends Controller
{
    /**
     * Método construtor da classe
     */
    public function __construct(Suprimento $suprimento, Produto $produto)
    {
        $this->suprimento = $suprimento;
        $this->produto = $produto;
    }

    /**
     * Exibe o formulário de criação de novos suprimentos
     */
    public function create($id)
    {
        $produto = $this->produto->find($id);

        $suprimentos = $this->suprimento->where('suprimento_id',$id)->get();
        foreach ($suprimentos as $key => $suprimento) {
            $nome = $this->produto->select('modelo_produto')->find($suprimento->suprimento_id);
            $suprimento['nome_produto'] = $nome['modelo_produto'];
        }

        $impressoras = $this->produto->where([['status', 'ATIVO'],['tipo_produto', 'IMPRESSORA']])->get();

        if ($produto == null) {
            session()->flash('mensagem', 'Produto não encontrado.');
            session()->flash('color', 'warning');
            return redirect()->route('produtos.index');
        }

        return view('produto.impressora', ['produto' => $produto, 'suprimentos' => $suprimentos, 'impressoras' => $impressoras]);
    }

    /**
     * Realiza a criação de suprimentos
     */
    public function store(Request $request, $id)
    {
        $suprimento = $this->produto->find($id);
        $tipo = $suprimento->tipo_produto;
        $impressoras = $request->impressora;
        $emUsos = $request->em_uso;

        try{
            for($i = 0;$i < count($impressoras); $i++)
            {
                if($impressoras[$i] != null)
                {
                    $this->suprimento->create(
                        [
                            'produto_id' => $impressoras[$i],
                            'suprimento_id' => $suprimento->id,
                            'em_uso' => $emUsos[$i],
                            'tipo_suprimento' => $tipo
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            Log::channel('erros')->error($e->getMessage().' - Na linha: '.$e->getLine().' - No arquivo: '.$e->getFile());
            session()->flash('mensagem', 'Erro ao cadastrar suprimento.');
            session()->flash('color', 'danger');
            return redirect()->route('produtos.index');
        }

        session()->flash('mensagem', 'Suprimento cadastrado com sucesso!');
        session()->flash('color', 'success');
        return redirect()->route('produtos.index');
    }

    /**
     * Realiza a atualização dos dados de um suprimento, adicionando ou excluindo
     */
    public function update(Request $request, $id)
    {
        $suprimento = $this->produto->find($id);

        $produtos = $this->suprimento->select('tipo_suprimento','produto_id','suprimento_id','em_uso')->where('suprimento_id', $suprimento->id)->get();
        $produtos = $produtos->toArray();

        $tipo = $suprimento->tipo_produto;
        $impressoras = $request->impressora;
        $emUsos = $request->em_uso;

        $pImpressoras = array();
        $pEmUsos = array();
        $pTipos = array();

        foreach($produtos as $produto)
        {
            $produto['produto_id'] = strval($produto['produto_id']);
            array_push($pImpressoras,$produto['produto_id']);

            array_push($pTipos,$produto['tipo_suprimento']);

            array_push($pEmUsos,$produto['em_uso']);
        }
        
        $impressorasNovas = array_diff_assoc($impressoras, $pImpressoras);
        $emUsosNovos = array_diff_assoc($emUsos, $pEmUsos);
        $impressorasExcluidas = array_diff_assoc($pImpressoras, $impressoras);
        
        try {
            if($impressorasExcluidas != [])
            {
                foreach($impressorasExcluidas as $impressoraExcluida)
                {
                    $suprimentoExcluido = $this->suprimento->where('produto_id', $impressoraExcluida);
                    $suprimentoExcluido->delete();
                }
            }
            
            if($impressorasNovas != [])
            {
                foreach($impressorasNovas as $i => $impressoraNova)
                {
                    if($impressoraNova != null)
                    {
                        $dados = [
                            'produto_id' => $impressoraNova,
                            'suprimento_id' => $suprimento->id,
                            'tipo_suprimento' => $tipo
                        ];

                        if(isset($emUsosNovos[$i])) {
                            $dados['em_uso'] = $emUsosNovos[$i];
                        } else {
                            $dados['em_uso'] = $emUsos[$i];
                        }
                        $this->suprimento->create($dados);
                    }
                }
            }

            if($emUsosNovos != [] && count($emUsosNovos) > count($impressorasNovas)) {
                foreach ($emUsosNovos as $i => $emUsoNovo) {
                    $emUsoMudado = $this->suprimento->where([['produto_id', $impressoras[$i]], ['suprimento_id', $suprimento->id]])->first();
                    $emUsoMudado->em_uso = $emUsoNovo;
                    $emUsoMudado->save();
                }
            }
        } catch (\Exception $e) {
            Log::channel('erros')->error($e->getMessage().' - Na linha: '.$e->getLine().' - No arquivo: '.$e->getFile());
            session()->flash('mensagem', 'Erro ao atualizar suprimento.');
            session()->flash('color', 'danger');
            return redirect()->route('produtos.index');
        }

        session()->flash('mensagem', 'Suprimento atualizado com sucesso!');
        session()->flash('color', 'success');
        return redirect()->route('produtos.index');
    }
}