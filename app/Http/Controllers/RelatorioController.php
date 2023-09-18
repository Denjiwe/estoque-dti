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
                        break;
                    case 'Divisao':
                        if ($campo == 'todos') {
                            $dados = $dados->whereHas('solicitacao.divisao', function ($query) {
                                $query->where('divisoes.id', '!=', null);
                            })->get();
                        } else {
                            $dados = $dados->whereHas('solicitacao.divisao', function ($query) use ($campo, $valor) {
                                $query->where('divisoes.'.$campo, $valor);
                            })->get();                        
                        } 

                        $dados = $dados->groupBy(function ($entrega) {
                            if ($entrega->solicitacao->divisao_id != null) {
                                return $entrega->solicitacao->divisao->nome;
                            } else {
                                return 'N/D';
                            }
                        });
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
                            return $entrega->produto->modelo_produto;
                        });
                        break;
                    default:
                        session()->flash('mensagem', 'Informe um campo de filtro válido.');
                        session()->flash('color', 'warning');
                        break;
                }
                break;
            case 'impressoras':
                $dados = LocalImpressora::whereHas('produto', function ($query) {
                    $query->where('tipo_produto', 'IMPRESSORA');
                })->with('produto');

                $dados = $this->filtroData($request, $dados);

                switch ($tipo) {
                    case 'Orgao':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('diretoria.orgao', function ($query) use ($campo, $valor) {
                                $query->where('orgaos.'.$campo, $valor);
                            })->get();                        
                        } 

                        $dados = $dados->groupBy(function ($impressora) {
                            return $impressora->diretoria->orgao->nome;
                        });
                        break;
                    case 'Diretoria':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('diretoria', function ($query) use ($campo, $valor) {
                                $query->where('diretorias.'.$campo, $valor);
                            })->get();                        
                        } 
                        $dados = $dados->groupBy(function ($impressora) {
                            return $impressora->diretoria->nome;
                        });
                        break;
                    case 'Divisao':
                        if ($campo == 'todos') {
                            $dados = $dados->whereHas('divisao', function ($query) {
                                $query->where('divisoes.id', '!=', null);
                            })->get();                        
                        } else {
                            $dados = $dados->whereHas('divisao', function ($query) use ($campo, $valor) {
                                $query->where('divisoes.'.$campo, $valor);
                            })->get();                        
                        } 
                        $dados = $dados->groupBy(function ($impressora) {
                            return $impressora->divisao->nome;
                        });
                        break;
                }
                break;
            case 'usuarios':
                $dados = Usuario::with(['diretoria.orgao', 'divisao']);

                $dados = $this->filtroData($request, $dados);

                switch ($tipo) {
                    case 'Orgao':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('diretoria.orgao', function ($query) use ($campo, $valor) {
                                $query->where('orgaos.'.$campo, $valor);
                            })->get();                        
                        }
                        $dados = $dados->groupBy(function ($usuario) {
                            return $usuario->diretoria->orgao->nome;
                        });
                        break;
                    case 'Diretoria':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('diretoria', function ($query) use ($campo, $valor) {
                                $query->where('diretorias.'.$campo, $valor);
                            });
                        }
                        $dados = $dados->groupBy(function ($usuario) {
                            return $usuario->diretoria->nome;
                        });
                        break;
                    case 'Divisao':
                        if ($campo == 'todos') {
                            $dados = $dados->whereHas('divisao', function ($query) {
                                $query->where('divisoes.id', '!=', null);
                            })->get();
                        } else {
                            $dados = $dados->whereHas('divisao', function ($query) use ($campo, $valor) {
                                $query->where('divisoes.'.$campo, $valor);
                            })->get();
                        }
                        $dados = $dados->groupBy(function ($usuario) {
                            return $usuario->divisao->nome;
                        });
                        break;
                }
                break;
            case 'solicitacoes':
                $dados = Solicitacao::with(['diretoria', 'divisao', 'usuario', 'produtos']);

                $dados = $this->filtroData($request, $dados);

                switch ($tipo) {
                    case 'Orgao':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('diretoria.orgao', function ($query) use ($campo, $valor) {
                                $query->where('orgaos.'.$campo, $valor);
                            })->get();
                        }
                        $dados = $dados->groupBy(function ($solicitacao) {
                            return $solicitacao->diretoria->orgao->nome;
                        });
                        break;
                    case 'Diretoria':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('diretoria', function ($query) use ($campo, $valor) {
                                $query->where('diretorias.'.$campo, $valor);
                            })->get();
                        }
                        $dados = $dados->groupBy(function ($solicitacao) {
                            return $solicitacao->diretoria->nome;
                        });
                        break;
                    case 'Divisao':
                        if ($campo == 'todos') {
                            $dados = $dados->whereHas('divisao', function ($query) {
                                $query->where('divisoes.id', '!=', null);
                            })->get();
                        } else {
                            $dados = $dados->whereHas('divisao', function ($query) use ($campo, $valor) {
                                $query->where('divisoes.'.$campo, $valor);
                            })->get();
                        }
                        $dados = $dados->groupBy(function ($solicitacao) {
                            return $solicitacao->divisao->nome;
                        });
                        break;
                    case 'Usuario':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('usuario', function ($query) use ($campo, $valor) {
                                $query->where('usuario.'.$campo, $valor);
                            })->get();
                        }
                        $dados = $dados->groupBy(function ($solicitacao) {
                            return $solicitacao->usuario->nome;
                        });
                        break;
                    case 'Produto':
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            if ($campo == 'nome') $campo = 'modelo_produto';
                            $dados = $dados->whereHas('produtos', function ($query) use ($campo, $valor) {
                                $query->where('produtos.'.$campo, $valor);
                            })->get();
                        }
                        $dados = $dados->groupBy(function ($solicitacao) {
                            return $solicitacao->produtos[0]->modelo_produto;
                        });
                        break;
                }
                break;
            default:
                break;
        }

        $dados = $dados->toArray();

        if($dados == []) {
            session()->flash('mensagem', 'Nenhum resultado encontrado.');
            session()->flash('color', 'warning');
            return redirect()->route('relatorios.index');
        }

        dd($dados);
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
