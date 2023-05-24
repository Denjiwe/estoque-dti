<?php

namespace App\Http\Controllers;

use App\Models\Suprimento;
use App\Models\Produto;
use App\Models\Divisao;
use App\Models\Diretoria;
use Illuminate\Http\Request;

class SuprimentoController extends Controller
{
    public function __construct(Produto $produto) 
    {
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

        $diretorias = Diretoria::where('status', 'ATIVO')->get();
        $divisoes = Divisao::where('status', 'ATIVO')->get();

        if ($produto == null) {
            return redirect()->route('produtos.index');
        }

        return view('produto.suprimento', ['produto' => $produto, 'diretorias' => $diretorias, 'divisoes' => $divisoes]);
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
     * @param  \App\Models\ItensProduto  $itensProduto
     * @return \Illuminate\Http\Response
     */
    public function show(ItensProduto $itensProduto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItensProduto  $itensProduto
     * @return \Illuminate\Http\Response
     */
    public function edit(ItensProduto $itensProduto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItensProduto  $itensProduto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItensProduto $itensProduto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItensProduto  $itensProduto
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItensProduto $itensProduto)
    {
        //
    }
}
