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
        $id=0;
        $request->validate($this->usuario->rules($id), $this->usuario->feedback());

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
    public function edit($id)
    {
        $usuario = $this->usuario->with('diretoria')->with('divisao')->find($id);

        $diretorias = Diretoria::get();
        $divisoes = Divisao::get();

        $data = [
            'usuario' => $usuario,
            'diretorias' => $diretorias,
            'divisoes' => $divisoes
        ];

        return view('usuario.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->usuario->rulesUpdate($request, $id), $this->usuario->feedback());

        $usuario = $this->usuario->find($id);

        if($usuario == null) {
            return redirect()->route('usuarios.index', ['erro' => 'Usuário não encontrado!']);
        }

        if ($request->divisao_id == 0) {
            $request['divisao_id'] = null;
        }

        if ($request->senha == '') {
            $request['senha'] = $usuario->senha;
        }

        $usuario->update($request->all());

        return redirect()->route('usuarios.index', ['sucesso' => "Usuário $usuario->nome alterado com sucesso!" ]);
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
