<?php

namespace App\Http\Controllers;

use App\Models\Divisao;
use App\Models\Usuario;
use App\Models\Diretoria;
use Carbon\Carbon;
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
        $divisoes = $this->divisao->with('diretoria')->get();
        $diretorias = Diretoria::orderBy('nome')->get();

        $heads = [
            'ID',
            'Nome',
            'Diretoria',
            'Status',
            'Data de Criação',
            'Data de Edição',
            ['label' => 'Ações', 'no-export' => true, 'width' => '10'],
        ];

        foreach ($divisoes as $divisao) 
        {
            $dataCriacao = date('d/m/Y',strtotime($divisao->created_at));
            $dataEdicao = date('d/m/Y',strtotime($divisao->updated_at));

            $btnEdit = '<button data-bs-toggle="modal" data-bs-target="#editarModal'.$divisao->id.'" class="btn btn-sm btn-default text-primary mx-1 shadow" type="button" title="Editar">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>';
            $btnDelete ='<form action="'.route("divisao.destroy", ["divisao" => $divisao->id]).'" method="POST" id="form_'.$divisao->id.'" style="display:inline">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <button class="btn btn-sm btn-default text-danger mx-1 shadow" type="button" onclick="excluir('.$divisao->id.')" title="Excluir">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                            </form>';
            $btnDetails = '<a href="'.route("divisao.show", ["divisao" => $divisao->id]).'"><button class="btn btn-sm btn-default text-teal mx-1 shadow" title="Detalhes">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </button></a>';

            $data[] = [
                $divisao->id,
                $divisao->nome,
                $divisao->diretoria->nome,
                ucfirst(strtolower($divisao->status)),
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

        return view('divisao.index', ['heads' => $heads, 'config' => $config, 'divisoes' => $divisoes, 'titulo' => 'Divisões Cadastradas', 'diretorias' => $diretorias]);
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

        try {
            $divisao = $this->divisao->create($request->all());
        } catch (\Exception $e) {
            session()->flash('mensagem', 'Erro ao cadastrar a Divisão');
            session()->flash('color', 'danger');
            return redirect()->route('divisao.index');
        }

        session()->flash('mensagem', 'Divisão cadastrada com sucesso!');
        session()->flash('color', 'success');
        return redirect()->route('divisao.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Divisao  $divisao
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $divisao = $this->divisao->with(['diretoria','usuarios'])->find($id);

        if($divisao == null) {
            session()->flash('mensagem', 'Divisão não encontrada.');
            session()->flash('color', 'warning');
            return redirect()->route('divisao.index');
        }

        return view('divisao.show', ['divisao' => $divisao]);
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

        if($divisao == null) {
            session()->flash('mensagem', 'Divisão não encontrada.');
            session()->flash('color', 'warning');
            return redirect()->route('divisao.index');
        }

        try {
            $divisao->update($request->all());
        } catch (\Exception $e) {
            session()->flash('mensagem', 'Erro ao atualizar a Divisão.');
            session()->flash('color', 'danger');
            return redirect()->route('divisao.index');
        }

        session()->flash('mensagem', 'Divisão atualizada com sucesso!');
        session()->flash('color', 'success');
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
            session()->flash('mensagem', 'Divisão não encontrada.');
            session()->flash('color', 'warning');
            return redirect()->route('divisao.index');
        }

        try {
            $divisao->delete();
        } catch (\Exception $e) {
            session()->flash('mensagem', 'Erro ao excluir a Divisão.');
            session()->flash('color', 'danger');
            return redirect()->route('divisao.index');
        }

        session()->flash('mensagem', 'Divisão excluída com sucesso!');
        session()->flash('color', 'success');
        return redirect()->route('divisao.index');
    }

    public function pesquisa(Request $request) {
        switch (true) {
            case isset($request->id):
                $divisoes = $this->divisao->where('id', $request->id)->paginate(10);
                $resposta = 'Resultado da Pesquisa pelo ID '.$request->id;
                break;
            case isset($request->nome):
                $divisoes = $this->divisao->where('nome', 'like', '%'.$request->nome.'%')->paginate(10);
                $resposta = 'Resultado da Pesquisa por Nome: '.$request->nome;
                break;
            case isset($request->status):
                $divisoes = $this->divisao->where('status', $request->status)->paginate(10);
                $resposta = 'Resultado da Pesquisa por Status '.ucfirst(strtolower($request->status));
                break;
            case isset($request->data_criacao_inicio):
                if(!isset($request->data_criacao_fim)) {
                    $timestamp = Carbon::createFromFormat('Y-m-d', $request->data_criacao_inicio)->startOfDay();
                    $divisoes = $this->divisao->whereDate('created_at', $timestamp)->paginate(10);
                } else {
                    $divisoes = $this->divisao->whereBetween('created_at', [$request->data_criacao_inicio, $request->data_criacao_fim])->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Data de Criação';
                break;
            case isset($request->data_edicao_inicio):
                if(!isset($request->data_edicao_fim)) {
                    $timestamp = Carbon::createFromFormat('Y-m-d', $request->data_edicao_inicio)->startOfDay();
                    $divisoes = $this->divisao->whereDate('updated_at', $timestamp)->paginate(10);
                } else {
                    $divisoes = $this->divisao->whereBetween('updated_at', [$request->data_edicao_inicio, $request->data_edicao_fim])->paginate(10);
                }
                $resposta = 'Resultado da Pesquisa por Data de Atualização';
                break;
            default:
                return redirect()->back()->withErrors('Erro ao pesquisar, tente novamente.');
                break;
        }

        $diretorias = Diretoria::get();

        return view('divisao.pesquisa', ['divisoes' => $divisoes, 'titulo' => $resposta, 'diretorias' => $diretorias]);
    }
}