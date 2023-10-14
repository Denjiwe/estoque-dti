<?php

namespace App\Http\Controllers;

use App\Models\LocalImpressora;
use App\Models\Produto;
use App\Models\Divisao;
use App\Models\Diretoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        try {
            for($i = 0;$i < count($request->diretoria); $i++)
            {
                $request->validate($this->local->rules($request->divisao[$i], $request->diretoria[$i]), $this->local->feedback($i));

                if ($request->diretoria[$i] != null)
                {
                    $this->local->create(
                        [
                            'produto_id' => $produto->id,
                            'diretoria_id' => $request->diretoria[$i],
                            'divisao_id' => $request->divisao[$i],
                            'ip' => $request->ip[$i]
                        ]
                    );
                }
            }

            $produto->qntde_estoque = count($this->local->where('produto_id', $produto->id)->get());
            $produto->save();
        } catch (\Exception $e) {
            Log::channel('erros')->error($e->getMessage().' - Na linha: '.$e->getLine().' - No arquivo: '.$e->getFile());
            session()->flash('mensagem', 'Erro ao cadastrar locais.');
            session()->flash('color', 'danger');
            return redirect()->back();
        }

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

        try {
            for($i = 0;$i < count($request->divisao); $i++)
            {
                $request->validate($this->local->rules($request->divisao[$i], $request->diretoria[$i], $request->ip[$i]), $this->local->feedback($i));
            }

            $divisoes = $request->divisao;
            $pDivisoes = array();

            $diretorias = $request->diretoria;
            $pDiretorias = array();

            $ips = $request->ip;
            $pIps = array();

            foreach($produto->locais->toArray() as $local)
            {
                if($local['divisao_id'] != null) $local['divisao_id'] = strval($local['divisao_id']); else $local['divisao_id'] = null;
                $pDivisoes['divisao_id'][] = $local['divisao_id'];
                $pDivisoes['id'][] = $local['id'];

                if($local['diretoria_id'] != null) $local['diretoria_id'] = strval($local['diretoria_id']);
                $pDiretorias['diretoria_id'][] = $local['diretoria_id'];
                $pDiretorias['id'][] = $local['id'];

                $pIps['id'][] = $local['id'];
                $pIps['ip'][] = $local['ip'];
            }

            $divisoesExcluidas = array_diff_assoc($pDivisoes['divisao_id'], $divisoes);
            $divisoesNovas = array_diff_assoc($divisoes, $pDivisoes['divisao_id']);

            $diretoriasExcluidas = array_diff_assoc($pDiretorias['diretoria_id'], $diretorias);
            $diretoriasNovas = array_diff_assoc($diretorias, $pDiretorias['diretoria_id']);

            $ipsAlterados = array_diff_assoc($pIps['ip'], $ips);
            $ipsNovos = array_diff_assoc($ips, $pIps['ip']);

            if($diretoriasExcluidas != [])
            {
                foreach($diretoriasExcluidas as $index => $diretoriaExcluida) {
                    if($diretoriaExcluida != null) {
                        $local = $this->local->find($pDiretorias['id'][$index]);
                        $local->delete();
                    }
                }
            }

            if ($divisoesExcluidas != []) {
                foreach ($divisoesExcluidas as $index => $divisaoExcluida) {
                    if (isset($divisoesNovas[$index]) && $divisoesNovas[$index] !== null) {
                        $local = $this->local->find($pDivisoes['id'][$index]);
                        if ($local != null) {
                            $local->divisao_id = $divisoesNovas[$index];
                            $local->save();
                        }
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
                            'divisao_id' => $divisoesNovas[$index],
                            'ip' => $ipsNovos[$index] != null ? $ipsNovos[$index] : null
                        ]);
                    }
                }
            }

            if($ipsAlterados != [])
            {
                foreach($ipsAlterados as $index => $ipAlterado)
                {
                    if(isset($pIps['id'][$index])) {
                        $local = $this->local->find($pIps['id'][$index]);
                        if($local != null) {
                            $local->ip = $ipAlterado;
                            $local->save();
                        }
                    }
                }
            }

            if($ipsNovos != [])
            {
                foreach($ipsNovos as $index => $ipNovo)
                {
                    if(isset($pIps['id'][$index])) {
                        $local = $this->local->find($pIps['id'][$index]);
                        if($local != null) {
                            $local->ip = $ipNovo;
                            $local->save();
                        }
                    }
                }
            }

            $produto->qntde_estoque = count($this->local->where('produto_id', $produto->id)->get());
            $produto->save();
        } catch (\Exception $e) {
            Log::channel('erros')->error($e->getMessage().' - Na linha: '.$e->getLine().' - No arquivo: '.$e->getFile());
            session()->flash('mensagem', 'Erro ao atualizar locais.');
            session()->flash('color', 'danger');
            return redirect()->back();
        }

        return redirect()->route('suprimentos.create', ['id' => $produto->id]);
    }
}
