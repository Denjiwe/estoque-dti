<?php

namespace App\Http\Controllers;

use App\Models\Suprimento;
use App\Models\Produto;
use Illuminate\Http\Request;

class ImpressoraController extends Controller
{
    public function __construct(Suprimento $suprimento, Produto $produto)
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
        $produto = $this->produto->find($id);

        $suprimentos = $this->suprimento->where('suprimento_id',$id)->get();
        foreach ($suprimentos as $key => $suprimento) {
            $nome = $this->produto->select('modelo_produto')->find($suprimento->suprimento_id);
            $suprimento['nome_produto'] = $nome['modelo_produto'];
        }

        $impressoras = $this->produto->where([['status', 'ATIVO'],['tipo_produto', 'IMPRESSORA']])->get();

        if ($produto == null) {
            return redirect()->route('produtos.index');
        }

        return view('produto.impressora', ['produto' => $produto, 'suprimentos' => $suprimentos, 'impressoras' => $impressoras]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $suprimento = $this->produto->find($id);
        $tipo = $suprimento->tipo_produto;
        $impressoras = $request->impressora;
        $emUsos = $request->em_uso;
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

        return redirect()->route('produtos.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suprimento  $suprimento
     * @return \Illuminate\Http\Response
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

        return redirect()->route('produtos.index');
    }
}