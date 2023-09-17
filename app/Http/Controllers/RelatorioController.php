<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Diretoria;
use App\Models\Divisao;
use App\Models\Entrega;
use App\Models\LocalImpressora;
use App\Models\Produto;
use App\Models\Orgao;
use App\Models\Suprimento;
use App\Models\Solicitacao;
use Barryvdh\DomPDF\Facade\PDF;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\RelatorioExport;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function index() {
        return view('relatorio.index');
    }

    public function pesquisa(Request $request) {
        $item = $request->item;
        $tipo = $request->tipo;
        $campo = $request->campo;
        if (isset($request->valor)) {
            $valor = $request->valor;
        } else {
            $valor = null;
        }
        $data = $request->data;
        if($data == 'personalizado') {
            $data_inicial = $request->data_inicial;
            $data_final = $request->data_final;
        } else {
            $data_inicial = null;
            $data_final = null;
        }
        $formato = $request->formato;

        switch ($item) {
            case 'entregas':
                $dados = Entrega::with('produto');

                $dados = $this->filtroData($request, $dados);

                switch ($tipo) {
                    case 'Orgao':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('solicitacao.orgao', function ($query) use ($campo, $valor) {
                                $query->where('orgaos.'.$campo, $valor);
                            })->get();                        
                        } 

                        $dados = $dados->groupBy(function ($entrega) {
                            return $entrega->solicitacao->orgao->nome;
                        });

                        if($dados->toArray() == []) {
                            session()->flash('mensagem', 'Nenhum resultado encontrado.');
                            session()->flash('color', 'warning');
                            return redirect()->route('relatorios.index');
                        }
                        break;
                    case 'Diretoria':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('solicitacao.diretoria', function ($query) use ($campo, $valor) {
                                $query->where('diretorias.'.$campo, $valor);
                            })->get();                        
                        } 

                        $dados = $dados->groupBy(function ($entrega) {
                            return $entrega->solicitacao->diretoria->nome;
                        });

                        if($dados->toArray() == []) {
                            session()->flash('mensagem', 'Nenhum resultado encontrado.');
                            session()->flash('color', 'warning');
                            return redirect()->route('relatorios.index');
                        }
                        break;
                    case 'Divisao':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('solicitacao.divisao', function ($query) use ($campo, $valor) {
                                $query->where('divisoes.'.$campo, $valor);
                            })->get();                        
                        } 

                        $dados = $dados->groupBy(function ($entrega) {
                            return $entrega->solicitacao->divisao->nome;
                        });

                        if($dados->toArray() == []) {
                            session()->flash('mensagem', 'Nenhum resultado encontrado.');
                            session()->flash('color', 'warning');
                            return redirect()->route('relatorios.index');
                        }
                        break;
                    case 'Usuario':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('solicitacao.usuario', function ($query) use ($campo, $valor) {
                                $query->where('usuario.'.$campo, $valor);
                            })->get();                        
                        } 

                        $dados = $dados->groupBy(function ($entrega) {
                            return $entrega->solicitacao->usuario->nome;
                        });

                        if($dados->toArray() == []) {
                            session()->flash('mensagem', 'Nenhum resultado encontrado.');
                            session()->flash('color', 'warning');
                            return redirect()->route('relatorios.index');
                        }
                        break;
                    case 'Solicitacao':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('solicitacao', function ($query) use ($campo, $valor) {
                                $query->where('solicitacoes.'.$campo, $valor);
                            })->get();                        
                        } 

                        $dados = $dados->groupBy(function ($entrega) {
                            return '#'.$entrega->solicitacao->id;
                        });

                        if($dados->toArray() == []) {
                            session()->flash('mensagem', 'Nenhum resultado encontrado.');
                            session()->flash('color', 'warning');
                            return redirect()->route('relatorios.index');
                        }
                        break;
                    case 'Produto':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('produto', function ($query) use ($campo, $valor) {
                                $query->where('produtos.'.$campo, $valor);
                            })->get();                        
                        } 

                        $dados = $dados->groupBy(function ($entrega) {
                            return $entrega->produtos->modelo_produto;
                        });

                        if($dados->toArray() == []) {
                            session()->flash('mensagem', 'Nenhum resultado encontrado.');
                            session()->flash('color', 'warning');
                            return redirect()->route('relatorios.index');
                        }
                        break;
                }
                break;
            case 'impressoras':
                break;
            case 'produtos':
                break;
            case 'usuarios':
                break;
            case 'solicitacoes':
                break;
            default:
                break;
        }
        dd($dados->toArray());
    }

    public function filtroData(Request $request, $dados) {
        switch ($request->data) {
            case 'qualquer':
                break;
            case 'hoje':
                $dados = $dados->whereDate('created_at', date('Y-m-d'));
                break;
            case 'ontem':
                $dados = $dados->whereDate('created_at', date('Y-m-d', strtotime('-1 days')));
                break;
            case 'semana':
                $dados = $dados->whereDate('created_at', '>=', date('Y-m-d', strtotime('-7 days')));
                break;
            case 'mes':
                $dados = $dados->whereDate('created_at', '>=', date('Y-m-d', strtotime('-30 days')));
                break;
            case 'ultimo_mes':
                $dados = $dados->whereMonth('created_at', date('m'));
                break;
            case 'personalizado':
                if($request->data_inicio > $request->data_final) {
                    session()->flash('mensagem', 'A data inicial deve ser menor que a data final!');
                    session()->flash('color', 'danger');
                    return redirect()->route('relatorios.index');
                }

                $dados = $dados->whereBetween('created_at', [$request->data_inicio, $request->data_final]);
                break;
            default:
                session()->flash('mensagem', 'Informe uma data válida.');
                session()->flash('color', 'danger');
                return redirect()->route('relatorios.index');
                break;
        }

        return $dados;
    }
}
