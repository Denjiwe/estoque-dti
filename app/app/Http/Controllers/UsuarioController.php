<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Diretoria;
use App\Models\Divisao;
use App\Models\Solicitacao;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Http;
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
        
        $usuario = $this->usuario->create($data);

        return redirect()->route('usuarios.index', ['sucesso' => "Usuário $usuario->nome criado com sucesso!"]);
    }

    /**
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = $this->usuario->with(['diretoria', 'divisao'])->find($id);
        
        if ($usuario == null) {
            return redirect()->route('usuarios.index', ['error' => 'Usuário não encontrado!']);
        }

        $solicitacoes = Solicitacao::where('usuario_id', $usuario->id)->paginate(10);

        return view('usuario.detalhes', ['usuario' => $usuario, 'solicitacoes' => $solicitacoes]);
    }   

    /**
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = $this->usuario->with(['diretoria', 'divisao'])->find($id);

        if ($usuario == null) {
            return redirect()->route('usuarios.index', ['error' => 'Usuário não encontrado!']);
        }

        $diretorias = Diretoria::get();
        $divisoes = Divisao::where('diretoria_id', $usuario->diretoria_id)->get();

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

        $data = $request->except('senha_provisoria');

        if ($request->senha_provisoria != '') {
            $data['senha_provisoria'] = bcrypt($request->senha_provisoria);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index', ['sucesso' => "Usuário $usuario->nome alterado com sucesso!"]);
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

    public function senhaEdit($usuarioId) {
        $usuario = $this->usuario->find($usuarioId);

        if ($usuario == null) {
            return redirect()->back();
        }

        if ($usuario->senha_provisoria == null) {
            return redirect()->back()->withErrors(['error' => 'Usuário não possui senha provisória!']);
        }

        return view('auth.alterar-senha', ['usuario' => $usuario]);
    }

    public function senhaUpdate(Request $request, $usuarioId) {
        $usuario = $this->usuario->find($usuarioId);

        if ($usuario == null) {
            return redirect()->back();
        }

        if($request->password != $request->password_confirmation) {
            return redirect()->back()->withErrors(['error' => 'As senhas não conferem!']);
        }

        $usuario->update([
            'senha' => bcrypt($request->password),
            'senha_provisoria' => null
        ]);

        return redirect()->route('login', ['sucesso' => 'Senha alterada com sucesso!']);
    }

    public function dadosPorUsuario($usuarioId)
    {
        $usuario = $this->usuario->select('diretoria_id', 'divisao_id')->find($usuarioId);

        if($usuario === null)
        {
            return response()->json(['erro' => 'Usuário não encontrado!'], 422);
        }

        $usuario->divisoes = Divisao::select('id', 'nome')->where('diretoria_id', $usuario->diretoria_id)->get();

        return response()->json($usuario);
    }
}
