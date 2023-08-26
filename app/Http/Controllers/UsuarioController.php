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
        $usuarios = $this->usuario->with(['diretoria', 'divisao'])->get();

        $heads = [
            'ID',
            'Nome',
            'Status',
            'Usuário Interno',
            'Diretoria',
            'Divisão',
            'Data de Criação',
            'Data de Edição',
            ['label' => 'Ações', 'no-export' => true, 'width' => '10'],
        ];

        foreach ($usuarios as $usuario) 
        {
            $dataCriacao = date('d/m/Y',strtotime($usuario->created_at));
            $dataEdicao = date('d/m/Y',strtotime($usuario->updated_at));

            $btnEdit = '<a href="'.route("usuarios.edit", ["usuario" => $usuario->id]).'"><button class="btn btn-xs btn-default text-primary mx-1 shadow" type="button" title="Editar">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button></a>';
            $btnDelete = 
                            '<button class="btn btn-xs btn-default text-danger mx-1 shadow" type="button" onclick="excluir('.$usuario->id.')" title="Excluir">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>'
                        ;
            $btnDetails = '<a href="'.route("usuarios.show", ["usuario" => $usuario->id]).'"><button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Detalhes">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </button></a>';

            $data[] = [
                $usuario->id,
                $usuario->nome,
                $usuario->status,
                $usuario->user_interno == 'SIM' ? 'Sim' : 'Não',
                $usuario->diretoria->nome,
                $usuario->divisao ? $usuario->divisao->nome : 'Nenhuma',
                $dataCriacao,
                $dataEdicao,
                '<nobr>'.$btnEdit.$btnDetails.$btnDelete.'</nobr>'
            ];
        }

        $config = [
            'data' => $data,
            'dom' => '<"row" <"col-sm-12 d-flex justify-content-start" f>>t<"row" <"col-sm-6 d-flex justify-content-start" i> <"col-sm-6 d-flex justify-content-end" p>>',
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, null, null, null, ['orderable' => false]],
            "bLengthChange" => false,
            'language' => [
                'sEmptyTable' => "Nenhum registro encontrado",
                'sInfo' =>	"Mostrando de _START_ até _END_ de _TOTAL_ registros",
                'sInfoEmpty' =>	"Mostrando 0 até 0 de 0 registros",
                'sInfoFiltered' =>	"(Filtrados de _MAX_ registros)",
                "sInfoThousands" => ".",
                "sLengthMenu" => "_MENU_ resultados por página",
                "sLoadingRecords" => "Carregando...",
                "sProcessing" => "Processando...",
                "sZeroRecords" => "Nenhum registro encontrado",
                "sSearch" => "Pesquisa rápida: ",
                "oPaginate" => [
                    "sNext" => "Próximo",
                    "sPrevious" =>	"Anterior",
                    "sFirst" =>	"Primeiro",
                    "sLast" =>	"Último"
                ],
            ]
        ];

        $itens = [
            'heads' => $heads,
            'config' => $config,
            'usuarios' => $usuarios, 
            'titulo' => 'Cadastro de Usuários',
        ];

        return view('usuario.index', $itens);
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

        $data = $request->except('senha_provisoria');
        $data['senha_provisoria'] = bcrypt($request->senha_provisoria);

        if ($data['divisao_id'] == 0) {
            unset($data['divisao_id']);
        }
        
        try {
            $usuario = $this->usuario->create($data);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors();
        }

        $mensagem = 'Usuário cadastrado com sucesso!';
        $color = 'success';
        return redirect()->route('usuarios.index', compact('mensagem', 'color'));
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
            $mensagem = 'Usuário não encontrado!';
            $color = 'warning';
            return redirect()->route('usuarios.index', compact('mensagem', 'color'));
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
            $mensagem = 'Usuário não encontrado!';
            $color = 'warning';
            return redirect()->route('usuarios.index', compact('mensagem', 'color'));
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
            $mensagem = 'Usuário não encontrado!';
            $color = 'warning';
            return redirect()->route('usuarios.index', compact('mensagem', 'color'));
        }

        if ($request->divisao_id == 0) {
            $request['divisao_id'] = null;
        }

        $data = $request->except('senha_provisoria');

        if ($request->senha_provisoria != '') {
            $data['senha_provisoria'] = bcrypt($request->senha_provisoria);
        }

        try {
            $usuario->update($data);
        } catch (\Exception $e) {
            $mensagem = 'Erro ao alterar o usuário.';
            $color = 'danger';
            return redirect()->route('usuarios.index', compact('mensagem', 'color'));
        }

        $mensagem = 'Usuário alterado com sucesso!';
        $color = 'success';
        return redirect()->route('usuarios.index', compact('mensagem', 'color'));
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

        if ($usuario == null) {
            $mensagem = 'Usuário não encontrado!';
            $color = 'warning';
            return redirect()->route('usuarios.index', compact('mensagem', 'color'));
        }

        if ($usuario->id == auth()->user()->id) {
            $mensagem = 'Voce não pode excluir seu próprio usuário!';
            $color = 'danger';
            return redirect()->route('usuarios.index', compact('mensagem', 'color'));
        }

        try {
            $usuario->delete();
        } catch (\Exception $e) {
            $mensagem = 'Erro ao excluir o usuário.';
            $color = 'danger';
            return redirect()->route('usuarios.index', compact('mensagem', 'color'));
        }

        $mensagem = 'Usuário excluído com sucesso!';
        $color = 'success';
        return redirect()->route('usuarios.index', compact('mensagem', 'color'));
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

    public function pesquisa(Request $request) {
        switch (true) {
            case isset($request->id):
                $usuarios = $this->usuario->where('id', $request->id)->paginate(10);
                $resposta = 'Resultado da Pesquisa pelo ID '.$request->id;
                break;
            case isset($request->nome):
                $usuarios = $this->usuario->where('nome', 'like', '%'.$request->nome.'%')->paginate(10);
                $resposta = 'Resultado da Pesquisa por Nome: '.$request->nome;
                break;
            case isset($request->diretoria):
                $usuarios = $this->usuario->whereHas('diretoria', function($query) use ($request) {
                    $query->where('nome', 'like', '%'.$request->diretoria.'%');
                })->paginate(10);
                $resposta = 'Resultado da Pesquisa pelo nome da diretoria: '.$request->diretoria;
                break;
            case isset($request->divisao):
                $usuarios = $this->usuario->whereHas('divisao', function($query) use ($request) {
                    $query->where('nome', 'like', '%'.$request->divisao.'%');
                })->paginate(10);
                if($request->divisao == 'Nenhuma') {
                    $usuarios = $this->usuario->where('divisao_id', null)->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa pelo nome da divisão: '.$request->divisao;
                break;
            case isset($request->status):
                $usuarios = $this->usuario->where('status', $request->status)->paginate(10);
                $resposta = 'Resultado da Pesquisa por Status '.ucfirst(strtolower($request->status));
                break;
            case isset($request->data_criacao_inicio):
                if(!isset($request->data_criacao_fim)) {
                    $timestamp = Carbon::createFromFormat('Y-m-d', $request->data_criacao_inicio)->startOfDay();
                    $usuarios = $this->usuario->whereDate('created_at', $timestamp)->paginate(10);
                } else {
                    $usuarios = $this->usuario->whereBetween('created_at', [$request->data_criacao_inicio, $request->data_criacao_fim])->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Data de Criação';
                break;
            case isset($request->data_edicao_inicio):
                if(!isset($request->data_edicao_fim)) {
                    $timestamp = Carbon::createFromFormat('Y-m-d', $request->data_edicao_inicio)->startOfDay();
                    $usuarios = $this->usuario->whereDate('updated_at', $timestamp)->paginate(10);
                } else {
                    $usuarios = $this->usuario->whereBetween('updated_at', [$request->data_edicao_inicio, $request->data_edicao_fim])->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Data de Atualização';
                break;
            default:
                return redirect()->back()->withErrors('Erro ao pesquisar, tente novamente.');
                break;
        }

        return view('usuario.pesquisa', ['usuarios' => $usuarios, 'titulo' => $resposta]);
    }
}
