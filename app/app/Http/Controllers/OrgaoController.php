<?php

namespace App\Http\Controllers;

use App\Models\Orgao;
use Illuminate\Http\Request;

class OrgaoController extends Controller
{
    public function __construct(Orgao $orgao) {
        $this->orgao = $orgao;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orgaos = $this->orgao->with('diretorias')->paginate(10);

        return view('orgao.index', ['orgaos' => $orgaos, 'titulo' => 'Órgãos Cadastrados']);
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
        $request->validate($this->orgao->rules($id), $this->orgao->feedback());

        $orgao = $this->orgao->create($request->all());
        return redirect()->route('orgaos.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Orgao  $orgao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->orgao->rules($id), $this->orgao->feedback());

        $orgao = $this->orgao->find($id);
        $orgao->update($request->all());

        return redirect()->route('orgaos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orgao  $orgao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orgao = $this->orgao->find($id);

        if($orgao == null) {
            return redirect()->route('orgaos.index');
        }

        $orgao->delete();
        return redirect()->route('orgaos.index');
    }
}
