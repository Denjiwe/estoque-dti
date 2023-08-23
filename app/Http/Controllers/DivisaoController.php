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
        $divisoes = $this->divisao->with('diretoria')->paginate(10);
        $diretorias = Diretoria::orderBy('nome')->get();

        return view('divisao.index', ['divisoes' => $divisoes, 'titulo' => 'Divisões Cadastradas', 'diretorias' => $diretorias]);
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
            $mensagem = 'Erro ao cadastrar a Divisão';
            $color = 'danger';
            return redirect()->route('divisao.index', compact('mensagem', 'color'));
        }

        $mensagem = 'Divisão cadastrada com sucesso!';
        $color = 'success';
        return redirect()->route('divisao.index', compact('mensagem', 'color'));
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
            $mensagem = 'Divisão não encontrada.';
            $color = 'warning';
            return redirect()->route('divisao.index', compact('mensagem', 'color'));
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
            $mensagem = 'Divisão não encontrada.';
            $color = 'warning';
            return redirect()->route('divisao.index', compact('mensagem', 'color'));
        }

        try {
            $divisao->update($request->all());
        } catch (\Exception $e) {
            $mensagem = 'Erro ao atualizar a Divisão.';
            $color = 'danger';
            return redirect()->route('divisao.index', compact('mensagem', 'color'));
        }

        $mensagem = 'Divisão atualizada com sucesso!';
        $color = 'success';
        return redirect()->route('divisao.index', compact('mensagem', 'color'));
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
            $mensagem = 'Divisão não encontrada.';
            $color = 'warning';
            return redirect()->route('divisao.index', compact('mensagem', 'color'));
        }

        try {
            $divisao->delete();
        } catch (\Exception $e) {
            $mensagem = 'Erro ao excluir a Divisão.';
            $color = 'danger';
            return redirect()->route('divisao.index', compact('mensagem', 'color'));
        }

        $mensagem = 'Divisão excluída com sucesso!';
        $color = 'success';
        return redirect()->route('divisao.index', compact('mensagem', 'color'));
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