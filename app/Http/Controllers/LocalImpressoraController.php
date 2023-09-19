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

        if ($produto == null) {
            session()->flash('mensagem', 'Produto não encontrado.');
            session()->flash('color', 'warning');
            return redirect()->route('produtos.index');
        }

        for($i = 0;$i < count($request->diretoria); $i++)
        {
            $request->validate($this->local->rules($request->divisao[$i], $request->diretoria[$i]), $this->local->feedback($i));

            if ($request->diretoria[$i] != null)
            {
                $this->local->create(
                    [
                        'produto_id' => $produto->id,
                        'diretoria_id' => $request->diretoria[$i],
                        'divisao_id' => $request->divisao[$i]
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

        if ($produto == null) {
            session()->flash('mensagem', 'Produto não encontrado.');
            session()->flash('color', 'warning');
            return redirect()->route('produtos.index');
        }

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
            if($local['divisao_id'] != null) $local['divisao_id'] = strval($local['divisao_id']); else $local['divisao_id'] = null;
            array_push($pDivisoes,$local['divisao_id']);

            if($local['diretoria_id'] != null) $local['diretoria_id'] = strval($local['diretoria_id']);
            array_push($pDiretorias,$local['diretoria_id']);
        }

        $divisoesExcluidas = array_diff_assoc($pDivisoes, $divisoes); // verifica quais elementos não estão mais presentes comparando as divs do produto com o que veio na request e os remove
        $divisoesNovas = array_diff_assoc($divisoes, $pDivisoes); // verifica quais elementos são novos comparando as divs do produto com o que veio na request e os adiciona

        $diretoriasExcluidas = array_diff($pDiretorias, $diretorias); // verifica quais elementos não estão mais presentes comparando as dirs do produto com o que veio na request e os remove
        $diretoriasNovas = array_diff($diretorias, $pDiretorias); // verifica quais elementos são novos comparando as divs do produto com o que veio na request e os adiciona

        if($diretoriasExcluidas != [])
        {
            foreach($diretoriasExcluidas as $index => $diretoriaExcluida)
            {
                if($diretoriaExcluida != null)
                {
                    $local = $this->local->where([['diretoria_id', $diretoriaExcluida],['divisao_id', $divisoesExcluidas[$index]],['produto_id', $produto->id]])->first();
                    $local->delete();
                }
            }
        }

        if($diretoriasNovas != [])
        {
            foreach($diretoriasNovas as $index => $diretoriaNova)
            {
                if($diretoriaNova != null)
                {
                    $this->local->create([
                        'produto_id' => $produto->id,
                        'diretoria_id' => $diretoriaNova,
                        'divisao_id' => $divisoesNovas[$index]
                    ]);
                }
            }
        }

        $produto->qntde_estoque = count($this->local->where('produto_id', $produto->id)->get());
        $produto->save();

        return redirect()->route('suprimentos.create', ['id' => $produto->id]);
    }
}
