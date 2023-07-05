<?php

namespace App\Http\Controllers;

use App\Models\Diretoria;
use App\Models\Divisao;
use App\Models\Usuario;
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

    public function show($id) {
        $diretoria = $this->diretoria->with(['divisoes', 'usuarios'])->find($id);

        if($diretoria == null) {
            return redirect()->route('diretorias.index');
        }

        foreach($diretoria->usuarios as $usuario) {
            if ($usuario->divisao_id != null) {
                $usuario->divisao = Divisao::select('id','nome')->find($usuario->divisao_id);
            }
        }

        return view('diretoria.show', ['diretoria' => $diretoria]);
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

    public function dadosPorDiretoria($diretoriaId) 
    {
        $divisoes = Divisao::select('id','nome')->where([['status', 'ATIVO'],['diretoria_id', $diretoriaId]])->get();
        $diretoriaNome = $this->diretoria::select('nome')->find($diretoriaId)->nome;
        $divisoes->diretoria_nome = $diretoriaNome;

        $usuariosDivisao = Usuario::select('id','nome')->where([['status', 'ATIVO'],['diretoria_id', $diretoriaId]])->orderBy('nome')->get();
        $usuarios = Usuario::select('id','nome')->where('status', 'ATIVO')->orderBy('nome')->get();
        $usuarios = $usuarios->diff($usuariosDivisao);

        return response()->json([$divisoes,$usuariosDivisao,$usuarios], 200);
    }
}
