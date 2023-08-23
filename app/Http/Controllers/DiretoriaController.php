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
        $orgaos = Orgao::orderBy('nome')->get();

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

        try {
            $diretoria = $this->diretoria->create($request->all());
        } catch (\Exception $e) {
            $mensagem = 'Erro ao cadastrar Diretoria.';
            $color = 'danger';
            return redirect()->route('diretorias.index', compact('mensagem', 'color'));
        }

        $mensagem = 'Diretoria cadastrada com sucesso!';
        $color = 'success';
        return redirect()->route('diretorias.index', compact('mensagem', 'color'));
    }

    public function show($id) {
        $diretoria = $this->diretoria->with(['divisoes', 'usuarios'])->find($id);

        if($diretoria == null) {
            $mensagem = 'Diretoria não encontrada.';
            $color = 'warning';
            return redirect()->route('diretorias.index', compact('mensagem', 'color'));
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
            $mensagem = 'Diretoria não encontrada.';
            $color = 'warning';
            return redirect()->route('diretorias.index');
        }

        try {
            $diretoria->update($request->all());
        } catch (\Exception $e) {
            $mensagem = 'Erro ao atualizar a diretoria.';
            $color = 'danger';
            return redirect()->route('diretorias.index', compact('mensagem', 'color'));
        }

        $mensagem = 'Diretoria atualizada com sucesso!';
        $color = 'success';
        return redirect()->route('diretorias.index', compact('mensagem', 'color'));
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
            $mensagem = 'Diretoria não encontrada.';
            $color = 'warning';
            return redirect()->route('diretorias.index', compact('mensagem', 'color'));
        }

        try {
            $diretoria->delete();
        } catch (\Exception $e) {
            $mensagem = 'Erro ao excluir a diretoria.';
            $color = 'danger';
            return redirect()->route('diretorias.index', compact('mensagem', 'color'));
        }

        $mensagem = 'Diretoria excluida com sucesso!';
        $color = 'success';
        return redirect()->route('diretorias.index', compact('mensagem', 'color'));
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
