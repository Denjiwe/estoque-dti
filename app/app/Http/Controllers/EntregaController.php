<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use App\Models\Usuario;
use App\Models\Produto;
use Illuminate\Http\Request;

class EntregaController extends Controller
{
    public function __construct(Entrega $entrega, Produto $produto) {
        $this->entrega = $entrega;
        $this->produto = $produto;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entregas = $this->entrega->with(['usuario', 'itens_solicitacao', 'solicitacao'])->paginate(10);

        foreach($entregas as $entrega) {
            $usuarioSolicitante = Usuario::find($entrega->solicitacao->usuario_id);

            $entrega->solicitacao->usuario = $usuarioSolicitante;
        }

        return view('entrega.index', ['entregas' => $entregas, 'titulo' => 'Entregas']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
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
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entrega = $this->entrega->with(['usuario', 'itens_solicitacao', 'solicitacao'])->find($id);

        return view('entrega.show', ['entrega' => $entrega, 'titulo' => 'Visualizar Entrega '.$entrega->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function edit(Entrega $entrega)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entrega $entrega)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entrega = $this->entrega->with('produto')->find($id);

        $produtoEstoque = $this->produto->find($entrega->produto->id);
        $produtoEstoque->qntde_estoque += $entrega->qntde;
        $produtoEstoque->save();

        $entrega->delete();

        return redirect()->route('entregas.index');
    }
}
