<?php

namespace App\Http\Controllers;

use App\Models\Diretoria;
use App\Models\Orgao;
use Illuminate\Http\Request;

class DiretoriaController extends Controller
{
    public function __construct(Diretoria $diretoria) {
        $this->diretoria = $diretoria;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diretorias = $this->diretoria->with('orgao')->paginate(10);
        $orgaos = Orgao::get();

        return view('diretoria.index', ['diretorias' => $diretorias, 'titulo' => 'Diretorias Cadastradas', 'orgaos' => $orgaos]);
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
        $request->validate($this->diretoria->rules($id), $this->diretoria->feedback());

        $diretoria = $this->diretoria->create($request->all());
        return redirect()->route('diretorias.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Diretoria  $diretoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->diretoria->rules($id), $this->diretoria->feedback());

        $diretoria = $this->diretoria->find($id);
        $diretoria->update($request->all());

        return redirect()->route('diretorias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Diretoria  $diretoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $diretoria = $this->diretoria->find($id);

        if($diretoria == null) {
            return redirect()->route('diretorias.index');
        }

        $diretoria->delete();
        return redirect()->route('diretorias.index');
    }
}
