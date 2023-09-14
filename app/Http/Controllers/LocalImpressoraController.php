<?php

namespace App\Http\Controllers;

use App\Models\LocalImpressora;
use App\Models\Produto;
use App\Models\Divisao;
use App\Models\Diretoria;
use Illuminate\Http\Request;

class LocalImpressoraController extends Controller
{
    public function __construct(LocalImpressora $local, Produto $produto, Divisao $divisao, Diretoria $diretoria)
    {
        $this->local = $local;
        $this->produto = $produto;
        $this->divisao = $divisao;
        $this->diretoria = $diretoria;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $produto = $this->produto->with('locais')->find($id);

        $diretorias = $this->diretoria->where('status', 'ATIVO')->get();
        $divisoes = $this->divisao->where('status', 'ATIVO')->get();

        if ($produto == null) {
            return redirect()->route('produtos.index');
        }

        return view('produto.local', ['produto' => $produto, 'diretorias' => $diretorias, 'divisoes' => $divisoes]);
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

        for($i = 0;$i < count($request->divisao); $i++)
        {
            $request->validate($this->local->rules($request->divisao[$i], $request->diretoria[$i]), $this->local->feedback($i));
            if ($request->divisao[$i] != null)
            {
                $this->local->create(
                    [
                        'produto_id' => $produto->id,
                        'divisao_id' => $request->divisao[$i]
                    ]
                );
            }

            if ($request->diretoria[$i] != null && $request->divisao[$i] == null)
            {
                $this->local->create(
                    [
                        'produto_id' => $produto->id,
                        'diretoria_id' => $request->diretoria[$i]
                    ]
                );
            }
        }

        $produto->qntde_estoque = count($this->local->where('produto_id', $produto->id)->get());
        $produto->save();

        return redirect()->route('suprimentos.create', ['id' => $produto->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Local  $local
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produto = $this->produto->with('locais')->find($id);

        for($i = 0;$i < count($request->divisao); $i++)
        {
            $request->validate($this->local->rules($request->divisao[$i], $request->diretoria[$i]), $this->local->feedback($i));
        }

        $divisoes = $request->divisao;
        $pDivisoes = array(); // recebe as divisões atualmente cadastradas no produto

        $diretorias = $request->diretoria;
        $pDiretorias = array(); // recebe as diretorias atualmente cadastradas no produto

        foreach($produto->locais->toArray() as $local) // faz com que as divisões e diretorias sejam um array para serem comparados
        {
            if($local['divisao_id'] != null) $local['divisao_id'] = strval($local['divisao_id']);
            array_push($pDivisoes,$local['divisao_id']);

            if($local['diretoria_id'] != null) $local['diretoria_id'] = strval($local['diretoria_id']);
            array_push($pDiretorias,$local['diretoria_id']);
        }

        $divisoesExcluidas = array_diff($pDivisoes, $divisoes); // verifica quais elementos não estão mais presentes comparando as divs do produto com o que veio na request e os remove
        if($divisoesExcluidas != [])
        {
            foreach($divisoesExcluidas as $divisaoExcluida)
            {
                if($divisaoExcluida != null)
                {
                    $local = $this->local->where('divisao_id', $divisaoExcluida);
                    $local->delete();
                }
            }
        }
        $divisoesNovas = array_diff($divisoes, $pDivisoes); // verifica quais elementos são novos comparando as divs do produto com o que veio na request e os adiciona
        if($divisoesNovas != [])
        {
            foreach($divisoesNovas as $divisaoNova)
            {
                if($divisaoNova != null)
                {
                    $this->local->create([
                        'produto_id' => $produto->id,
                        'divisao_id' => $divisaoNova
                    ]);
                }
            }
        }

        $diretoriasExcluidas = array_diff($pDiretorias, $diretorias); // verifica quais elementos não estão mais presentes comparando as dirs do produto com o que veio na request e os remove
        if($diretoriasExcluidas != [])
        {
            foreach($diretoriasExcluidas as $diretoriaExcluida)
            {
                if($diretoriaExcluida != null)
                {
                    $local = $this->local->where('diretoria_id', $diretoriaExcluida);
                    $local->delete();
                }
            }
        }
        $diretoriasNovas = array_diff($diretorias, $pDiretorias); // verifica quais elementos são novos comparando as divs do produto com o que veio na request e os adiciona
        dd($diretoriasNovas, $diretorias, $pDiretorias);
        if($diretoriasNovas != [])
        {
            foreach($diretoriasNovas as $diretoriaNova)
            {
                if($diretoriaNova != null)
                {
                    $this->local->create([
                        'produto_id' => $produto->id,
                        'diretoria_id' => $diretoriaNova
                    ]);
                }
            }
        }

        $produto->qntde_estoque = count($this->local->where('produto_id', $produto->id)->get());
        $produto->save();

        return redirect()->route('suprimentos.create', ['id' => $produto->id]);
    }
}
