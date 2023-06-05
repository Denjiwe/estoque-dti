<?php

namespace App\Http\Controllers;

use App\Models\Divisao;
use App\Models\Usuario;
use App\Models\Diretoria;
use Illuminate\Http\Request;

class DivisaoController extends Controller
{
    public function __construct(Divisao $divisao) {
        $this->divisao = $divisao;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisoes = $this->divisao->with('diretoria')->paginate(10);
        $diretorias = Diretoria::get();

        return view('divisao.index', ['divisoes' => $divisoes, 'titulo' => 'Divisões Cadastradas', 'diretorias' => $diretorias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = 0;
        $request->validate($this->divisao->rules($id), $this->divisao->feedback());

        $divisao = $this->divisao->create($request->all());
        return redirect()->route('divisao.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Divisao  $divisao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->divisao->rules($id), $this->divisao->feedback());

        $divisao = $this->divisao->find($id);
        $divisao->update($request->all());

        return redirect()->route('divisao.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Divisao  $divisao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $divisao = $this->divisao->find($id);

        if($divisao == null) {
            return redirect()->route('divisao.index');
        }

        $divisao->delete();
        return redirect()->route('divisao.index');
    }
}