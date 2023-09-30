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
        $diretorias = $this->diretoria->with('orgao')->get();
        $orgaos = Orgao::orderBy('nome')->get();

        $heads = [
            'ID',
            'Nome',
            'Órgão',
            'Status',
            'Data de Criação',
            'Data de Edição',
            ['label' => 'Ações', 'no-export' => true, 'width' => '10'],
        ];

        foreach ($diretorias as $diretoria)
        {
            $dataCriacao = date('d/m/Y',strtotime($diretoria->created_at));
            $dataEdicao = date('d/m/Y',strtotime($diretoria->updated_at));

            $btnEdit = '<button data-toggle="modal" data-target="#editarModal'.$diretoria->id.'" class="btn btn-sm btn-default text-primary mx-1 shadow" type="button" title="Editar">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>';
            $btnDelete = '<form action="'.route("diretorias.destroy", ["diretoria" => $diretoria->id]).'" method="POST" id="form_'.$diretoria->id.'" style="display:inline">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <button class="btn btn-sm btn-default text-danger shadow" type="button" onclick="excluir('.$diretoria->id.')" title="Excluir">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                            </form>'
                        ;
            $btnDetails = '<a href="'.route("diretorias.show", ["diretoria" => $diretoria->id]).'"><button class="btn btn-sm btn-default text-teal mx-1 shadow" title="Detalhes">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </button></a>';

            $data[] = [
                $diretoria->id,
                $diretoria->nome,
                $diretoria->orgao->nome,
                ucfirst(strtolower($diretoria->status)),
                $dataCriacao,
                $dataEdicao,
                '<nobr>'.$btnEdit.$btnDetails.$btnDelete.'</nobr>'
            ];
        }

        $config = [
            'data' => $data,
            'dom' => '<"row" <"col-sm-12 d-flex justify-content-start" f>>t<"row" <"col-sm-6 d-flex justify-content-start" i> <"col-sm-6 d-flex justify-content-end" p>>',
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, null, ['orderable' => false]],
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

        return view('diretoria.index', ['heads' => $heads, 'config' => $config, 'diretorias' => $diretorias, 'titulo' => 'Diretorias Cadastradas', 'orgaos' => $orgaos]);
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

        try {
            $diretoria = $this->diretoria->create($request->all());
        } catch (\Exception $e) {
            session()->flash('mensagem',  'Erro ao cadastrar Diretoria.');
            session()->flash('color',  'danger');
            return redirect()->route('diretorias.index');
        }

        session()->flash('mensagem',  'Diretoria cadastrada com sucesso!');
        session()->flash('color',  'success');
        return redirect()->route('diretorias.index');
    }

    public function show($id) {
        $diretoria = $this->diretoria->with(['divisoes', 'usuarios'])->find($id);

        if($diretoria == null) {
            session()->flash('mensagem',  'Diretoria não encontrada.');
            session()->flash('color',  'warning');
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

        if($diretoria == null) {
            session()->flash('mensagem',  'Diretoria não encontrada.');
            session()->flash('color',  'warning');
            return redirect()->route('diretorias.index');
        }

        try {
            $diretoria->update($request->all());
        } catch (\Exception $e) {
            session()->flash('mensagem',  'Erro ao atualizar a diretoria.');
            session()->flash('color',  'danger');
            return redirect()->route('diretorias.index');
        }

        session()->flash('mensagem', 'Diretoria atualizada com sucesso!');
        session()->flash('color', 'success');
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
            session()->flash('mensagem', 'Diretoria não encontrada.');
            session()->flash('color', 'warning');
            return redirect()->route('diretorias.index');
        }

        try {
            $diretoria->delete();
        } catch (\Exception $e) {
            session()->flash('mensagem', 'Erro ao excluir a diretoria.');
            session()->flash('color', 'danger');
            return redirect()->route('diretorias.index');
        }

        session()->flash('mensagem', 'Diretoria excluida com sucesso!');
        session()->flash('color', 'success');
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

    public function pesquisa(Request $request) {
        switch (true) {
            case isset($request->id):
                $diretorias = $this->diretoria->where('id', $request->id)->paginate(10);
                $resposta = 'Resultado da Pesquisa pelo ID '.$request->id;
                break;
            case isset($request->nome):
                $diretorias = $this->diretoria->where('nome', 'like', '%'.$request->nome.'%')->paginate(10);
                $resposta = 'Resultado da Pesquisa por Nome: '.$request->nome;
                break;
            case isset($request->status):
                $diretorias = $this->diretoria->where('status', $request->status)->paginate(10);
                $resposta = 'Resultado da Pesquisa por Status '.ucfirst(strtolower($request->status));
                break;
            case isset($request->data_criacao_inicio):
                if(!isset($request->data_criacao_fim)) {
                    $timestamp = Carbon::createFromFormat('Y-m-d', $request->data_criacao_inicio)->startOfDay();
                    $diretorias = $this->diretoria->whereDate('created_at', $timestamp)->paginate(10);
                } else {
                    $diretorias = $this->diretoria->whereBetween('created_at', [$request->data_criacao_inicio, $request->data_criacao_fim])->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Data de Criação';
                break;
            case isset($request->data_edicao_inicio):
                if(!isset($request->data_edicao_fim)) {
                    $timestamp = Carbon::createFromFormat('Y-m-d', $request->data_edicao_inicio)->startOfDay();
                    $diretorias = $this->diretoria->whereDate('updated_at', $timestamp)->paginate(10);
                } else {
                    $diretorias = $this->diretoria->whereBetween('updated_at', [$request->data_edicao_inicio, $request->data_edicao_fim])->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Data de Atualização';
                break;
            default:
                return redirect()->back()->withErrors('Erro ao pesquisar, tente novamente.');
                break;
        }

        $orgaos = Orgao::get();

        return view('diretoria.pesquisa', ['diretorias' => $diretorias, 'titulo' => $resposta, 'orgaos' => $orgaos]);
    }
}
