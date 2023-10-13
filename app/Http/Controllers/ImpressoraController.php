<?php

namespace App\Http\Controllers;

use App\Models\Suprimento;
use App\Models\Produto;
use App\Models\Divisao;
use App\Models\Diretoria;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ImpressoraController extends Controller
{
    public function __construct(Produto $produto, Suprimento $suprimento) 
    {
        $this->suprimento = $suprimento;
        $this->produto = $produto;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $produto = $this->produto->with('suprimentos')->find($id);

        $toners = $this->produto->where([['status', 'ATIVO'],['tipo_produto', 'TONER']])->get();
        $cilindros = $this->produto->where([['status', 'ATIVO'],['tipo_produto', 'CILINDRO']])->get();

        if ($produto == null) {
            session()->flash('mensagem', 'Produto não encontrado.');
            session()->flash('color', 'warning');
            return redirect()->route('produtos.index');
        }

        return view('produto.suprimento', ['produto' => $produto, 'toners' => $toners, 'cilindros' => $cilindros]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $produto = $this->produto->find($id);
        // $suprimentos[$i] sempre será correspondente a $emUsos[$i] quando vem da request
        $tipos = $request->tipo;
        $suprimentos = $request->suprimento;
        $emUsos = $request->em_uso;
        try {
            for($i = 0;$i < count($suprimentos); $i++)
            {
                if($suprimentos[$i] != null)
                {
                    $this->suprimento->create(
                        [
                            'produto_id' => $produto->id,
                            'suprimento_id' => $suprimentos[$i],
                            'em_uso' => $emUsos[$i],
                            'tipo_suprimento' => $tipos[$i]
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            Log::channel('erros')->error($e->getMessage().' - Na linha: '.$e->getLine().' - No arquivo: '.$e->getFile());
            session()->flash('mensagem', 'Erro ao cadastrar impressora.');
            session()->flash('color', 'danger');
            return redirect()->route('produtos.index');
        }

        session()->flash('mensagem', 'Impressora cadastrada com sucesso!');
        session()->flash('color', 'success');
        return redirect()->route('produtos.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItensProduto  $itensProduto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produto = $this->produto->with('suprimentos')->find($id);
        
        $tipos = $request->tipo;
        $suprimentos = $request->suprimento;
        $emUsos = $request->em_uso;

        $pSuprimentos = array();
        $pEmUsos = array();
        $pTipos = array();

        foreach($produto->suprimentos->toArray() as $suprimento)
        {
            $suprimento['suprimento_id'] = strval($suprimento['suprimento_id']);
            array_push($pSuprimentos,$suprimento['suprimento_id']);

            array_push($pTipos,$suprimento['tipo_suprimento']);

            array_push($pEmUsos,$suprimento['em_uso']);
        }

        $suprimentosNovos = array_diff_assoc($suprimentos, $pSuprimentos);
        $tiposNovos = array_diff_assoc($tipos, $pTipos);
        $emUsosNovos = array_diff_assoc($emUsos, $pEmUsos);
        $suprimentosExcluidos = array_diff_assoc($pSuprimentos, $suprimentos);
        
        try{
            if($suprimentosExcluidos != [])
            {
                foreach($suprimentosExcluidos as $suprimentoExcluido)
                {
                    $suprimento = $this->suprimento->where('suprimento_id', $suprimentoExcluido);
                    $suprimento->delete();
                }
            }
            
            if($suprimentosNovos != [])
            {
                foreach($suprimentosNovos as $i => $suprimentoNovo)
                {
                    if($suprimentoNovo != null)
                    {
                        $dados = [
                            'produto_id' => $produto->id,
                            'suprimento_id' => $suprimentoNovo
                        ];
                        
                        if(isset($tiposNovos[$i]))
                        {
                            $dados['tipo_suprimento'] = $tiposNovos[$i];
                        } else {
                            $dados['tipo_suprimento'] = $tipos[$i];
                        }

                        if(isset($emUsosNovos[$i])) {
                            $dados['em_uso'] = $emUsosNovos[$i];
                        } else {
                            $dados['em_uso'] = $emUsos[$i];
                        }
                        $suprimento = $this->suprimento->create($dados);
                    }
                }
            }

            if($emUsosNovos != [] && count($emUsosNovos) > count($suprimentosNovos)) {
                foreach ($emUsosNovos as $i => $emUsoNovo) {
                    $suprimento = $this->suprimento->where('suprimento_id', $suprimentos[$i])->first();
                    $suprimento->em_uso = $emUsoNovo;
                    $suprimento->save();
                }
            }
        } catch (\Exception $e) {
            Log::channel('erros')->error($e->getMessage().' - Na linha: '.$e->getLine().' - No arquivo: '.$e->getFile());
            session()->flash('mensagem', 'Erro ao atualizar impressora.');
            session()->flash('color', 'danger');
            return redirect()->route('produtos.index');
        }

        session()->flash('mensagem', 'Impressora atualizada com sucesso!');
        session()->flash('color', 'success');
        return redirect()->route('produtos.index');   
    }
}