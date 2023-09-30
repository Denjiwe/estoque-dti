<?php

namespace App\Http\Controllers;

use App\Models\Orgao;
use Carbon\Carbon;
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
        $orgaos = $this->orgao->with('diretorias')->get();

        $heads = [
            'ID',
            'Nome',
            'Status',
            'Data de Criação',
            'Data de Edição',
            ['label' => 'Ações', 'width' => '10'],
        ];

        foreach ($orgaos as $orgao)
        {
            $dataCriacao = date('d/m/Y',strtotime($orgao->created_at));
            $dataEdicao = date('d/m/Y',strtotime($orgao->updated_at));

            $btnEdit = '<button data-toggle="modal" data-target="#editarModal'.$orgao->id.'" class="btn btn-sm btn-default text-primary mx-1 shadow" type="button" title="Editar">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>';
            $btnDelete = '<form action="'.route("orgaos.destroy", ["orgao" => $orgao->id]).'" method="POST" id="form_'.$orgao->id.'" style="display:inline">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <button class="btn btn-sm btn-default text-danger shadow" type="button" onclick="excluir('.$orgao->id.')" title="Excluir">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                            </form>';
            $btnDetails = '<a href="'.route("orgaos.show", ["orgao" => $orgao->id]).'"><button class="btn btn-sm btn-default text-teal mx-1 shadow" title="Detalhes">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </button></a>';

            $data[] = [
                $orgao->id,
                $orgao->nome,
                ucfirst(strtolower($orgao->status)),
                $dataCriacao,
                $dataEdicao,
                '<nobr>'.$btnEdit.$btnDetails.$btnDelete.'</nobr>'
            ];
        }

        $config = [
            'data' => $data,
            'dom' => '<"row" <"col-sm-12 d-flex justify-content-start" f>>t<"row" <"col-sm-6 d-flex justify-content-start" i> <"col-sm-6 d-flex justify-content-end" p>>',
            'order' => [[0, 'asc']],
            'columns' => [null, null, null, null, null, ['orderable' => false]],
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

        return view('orgao.index', ['heads' => $heads, 'config' => $config, 'orgaos' => $orgaos, 'titulo' => 'Órgãos Cadastrados']);
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

        try {
            $orgao = $this->orgao->create($request->all());
        } catch (\Exception $e) {
            session()->flash('mensagem',  'Erro ao cadastrar o órgão.');
            session()->flash('color',  'danger');
            return redirect()->route('orgaos.index');
        }

        session()->flash('mensagem',  'Órgão cadastrado com sucesso!');
        session()->flash('color',  'success');
        return redirect()->route('orgaos.index');
    }

    public function show($id) {
        $orgao = $this->orgao->with('diretorias')->find($id);

        if($orgao == null) {
            session()->flash('mensagem',  'Órgão não encontrado.');
            session()->flash('color',  'warning');
            return redirect()->route('orgaos.index');
        }

        return view('orgao.show', ['orgao' => $orgao]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IlluminateHttp\Request  $request
     * @param  \App\Models\Orgao  $orgao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->orgao->rules($id), $this->orgao->feedback());

        $orgao = $this->orgao->find($id);

        if($orgao == null) {
            session()->flash('mensagem',  'Órgão não encontrado.');
            session()->flash('color',  'warning');
            return redirect()->route('orgaos.index');
        }

        try {
            $orgao->update($request->all());
        } catch (\Exception $e) {
            session()->flash('mensagem',  'Erro ao atualizar o órgão.');
            session()->flash('color',  'danger');
            return redirect()->route('orgaos.index');
        }

        session()->flash('mensagem',  'Órgão atualizado com sucesso!');
        session()->flash('color',  'success');
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
            session()->flash('mensagem',  'Órgão não encontrado.');
            session()->flash('color',  'warning');
            return redirect()->route('orgaos.index');
        }

        try {
            $orgao->delete();
        } catch (\Exception $e) {
            session()->flash('mensagem',  'Erro ao excluir o órgão.');
            session()->flash('color',  'danger');
            return redirect()->route('orgaos.index');
        }

        session()->flash('mensagem',  'Órgão excluído com sucesso!');
        session()->flash('color',  'success');
        return redirect()->route('orgaos.index');
    }

    public function pesquisa(Request $request) {
        switch (true) {
            case isset($request->id):
                $orgaos = $this->orgao->where('id', $request->id)->paginate(10);
                $resposta = 'Resultado da Pesquisa pelo ID '.$request->id;
                break;
            case isset($request->nome):
                $orgaos = $this->orgao->where('nome', 'like', '%'.$request->nome.'%')->paginate(10);
                $resposta = 'Resultado da Pesquisa por Nome: '.$request->nome;
                break;
            case isset($request->status):
                $orgaos = $this->orgao->where('status', $request->status)->paginate(10);
                $resposta = 'Resultado da Pesquisa por Status '.ucfirst(strtolower($request->status));
                break;
            case isset($request->data_criacao_inicio):
                if(!isset($request->data_criacao_fim)) {
                    $timestamp = Carbon::createFromFormat('Y-m-d', $request->data_criacao_inicio)->startOfDay();
                    $orgaos = $this->orgao->whereDate('created_at', $timestamp)->paginate(10);
                } else {
                    $orgaos = $this->orgao->whereBetween('created_at', [$request->data_criacao_inicio, $request->data_criacao_fim])->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Data de Criação';
                break;
            case isset($request->data_edicao_inicio):
                if(!isset($request->data_edicao_fim)) {
                    $timestamp = Carbon::createFromFormat('Y-m-d', $request->data_edicao_inicio)->startOfDay();
                    $orgaos = $this->orgao->whereDate('updated_at', $timestamp)->paginate(10);
                } else {
                    $orgaos = $this->orgao->whereBetween('updated_at', [$request->data_edicao_inicio, $request->data_edicao_fim])->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Data de Atualização';
                break;
            default:
                return redirect()->back()->withErrors('Erro ao pesquisar, tente novamente.');
                break;
        }

        return view('orgao.pesquisa', ['orgaos' => $orgaos, 'titulo' => $resposta]);
    }
}
