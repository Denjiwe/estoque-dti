<?php

namespace App\Http\Controllers;

use App\Models\Orgao;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
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

        try {
            $orgao = $this->orgao->create($request->all());
        } catch (\Exception $e) {
            $mensagem = 'Erro ao cadastrar o órgão.';
            $color = 'danger';
            return redirect()->route('orgaos.index', compact('mensagem', 'color'));
        }

        $mensagem = 'Órgão cadastrado com sucesso!';
        $color = 'success';
        return redirect()->route('orgaos.index', compact('mensagem', 'color'));
    }

    public function show($id) {
        $orgao = $this->orgao->with('diretorias')->find($id);

        if($orgao == null) {
            $mensagem = 'Órgão não encontrado.';
            $color = 'warning';
            return redirect()->route('orgaos.index', compact('mensagem', 'color'));
        }

        return view('orgao.show', ['orgao' => $orgao]);
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

        if($orgao == null) {
            $messagem = 'Órgão não encontrado.';
            $color = 'warning';
            return redirect()->route('orgaos.index', compact('messagem', 'color'));
        }

        try {
            $orgao->update($request->all());
        } catch (\Exception $e) {
            $mensagem = 'Erro ao atualizar o órgão.';
            $color = 'danger';
            return redirect()->route('orgaos.index', compact('mensagem', 'color'));
        }

        $mensagem = 'Órgão atualizado com sucesso!';
        $color = 'success';
        return redirect()->route('orgaos.index', compact('mensagem', 'color'));
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
            $mensagem = 'Órgão não encontrado.';
            $color = 'warning';
            return redirect()->route('orgaos.index', compact('mensagem', 'color'));
        }

        try {
            $orgao->delete();
        } catch (\Exception $e) {
            $mensagem = 'Erro ao excluir o órgão.';
            $color = 'danger';
            return redirect()->route('orgaos.index', compact('mensagem', 'color'));
        }
        
        $mensagem = 'Órgão excluído com sucesso!';
        $color = 'success';
        return redirect()->route('orgaos.index', compact('mensagem', 'color'));
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
