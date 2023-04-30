<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Diretoria;
use App\Models\Divisao;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function __construct(Usuario $usuario) {
        $this->usuario = $usuario;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = $this->usuario->with('diretoria')->with('divisao')->paginate(10);
        

        $data = [
            'usuarios' => $usuarios, 
            'titulo' => 'Cadastro de Usuários',
        ];

        return view('usuario.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $diretorias = Diretoria::get();
        $divisoes = Divisao::get();

        $data = [
            'diretorias' => $diretorias,
            'divisoes' => $divisoes
        ];

        return view('usuario.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->usuario->rules(), $this->usuario->feedback());

        $data = $request->except('senha');
        $data['senha'] = bcrypt($request->senha);

        if ($data['divisao_id'] == 0) {
            unset($data['divisao_id']);
        }
        
        $usuario= $this->usuario->create($data);

        return redirect()->route('usuarios.index', ['sucesso' => "Usuário $usuario->nome criado com sucesso!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = $this->usuario->find($id);

        $usuario->delete();

        return redirect()->route('usuarios.index');
    }
}
