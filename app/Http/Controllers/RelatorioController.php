<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Entrega;
use App\Models\LocalImpressora;
use App\Models\Solicitacao;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RelatorioExport;

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
        $formato = $request->formato;

        switch ($item) {
            case 'entregas':
                $dados = Entrega::with('produto', 'usuario', 'solicitacao.usuario', 'solicitacao.diretoria', 'solicitacao.divisao');

                $dados = $this->filtroData($request, $dados);
                $nome = 'Entregas';
                $nomeFile = 'entregas';

                switch ($tipo) {
                    case 'Orgao':
                        $filtro = 'Órgão';
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('solicitacao.orgao', function ($query) use ($campo, $valor) {
                                $query->where('orgaos.'.$campo, $valor);
                            })->get();
                        }

                        $dadosAgrupados = $dados->groupBy(function ($entrega) {
                            return $entrega->solicitacao->orgao->nome;
                        });
                        break;
                    case 'Diretoria':
                        $filtro = 'Diretoria';
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('solicitacao.diretoria', function ($query) use ($campo, $valor) {
                                $query->where('diretorias.'.$campo, $valor);
                            })->get();
                        }

                        $dadosAgrupados = $dados->groupBy(function ($entrega) {
                            return $entrega->solicitacao->diretoria->nome;
                        });
                        break;
                    case 'Divisao':
                        $filtro = 'Divisão';
                        if ($campo == 'todos') {
                            $dados = $dados->whereHas('solicitacao.divisao', function ($query) {
                                $query->where('divisoes.id', '!=', null);
                            })->get();
                        } else {
                            $dados = $dados->whereHas('solicitacao.divisao', function ($query) use ($campo, $valor) {
                                $query->where('divisoes.'.$campo, $valor);
                            })->get();
                        }

                        $dadosAgrupados = $dados->groupBy(function ($entrega) {
                            if ($entrega->solicitacao->divisao_id != null) {
                                return $entrega->solicitacao->divisao->nome;
                            } else {
                                return 'N/D';
                            }
                        });
                        break;
                    case 'Usuario':
                        $filtro = '';
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('solicitacao.usuario', function ($query) use ($campo, $valor) {
                                $query->where('usuario.'.$campo, $valor);
                            })->get();
                        }

                        $dadosAgrupados = $dados->groupBy(function ($entrega) {
                            return $entrega->solicitacao->usuario->nome;
                        });
                        break;
                    case 'Solicitacao':
                        $filtro = 'Solicitação';
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('solicitacao', function ($query) use ($campo, $valor) {
                                $query->where('solicitacoes.'.$campo, $valor);
                            })->get();
                        }

                        $dadosAgrupados = $dados->groupBy(function ($entrega) {
                            return '#'.$entrega->solicitacao->id;
                        });
                        break;
                    case 'Produto':
                        $filtro = 'Produto';
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('produto', function ($query) use ($campo, $valor) {
                                $query->where('produtos.'.$campo, $valor);
                            })->get();
                        }

                        $dadosAgrupados = $dados->groupBy(function ($entrega) {
                            return $entrega->produto->modelo_produto;
                        });
                        break;
                    default:
                        session()->flash('mensagem', 'Informe um campo de filtro válido.');
                        session()->flash('color', 'warning');
                        break;
                }
                $headers = [
                    'ID',
                    'Código da Solicitação',
                    'Funcionário Interno',
                    'Funcionário Solicitante',
                    'Diretoria Entregue',
                    'Divisão Entregue',
                    'Produto',
                    'Quantidade',
                    'Data de Entrega'
                ];
                $dadosExcel = [];
                foreach($dados as $dado) {
                    $dadosExcel[] = [
                        $dado->id,
                        $dado->solicitacao->id,
                        $dado->usuario->nome,
                        $dado->solicitacao->usuario->nome,
                        $dado->solicitacao->diretoria->nome,
                        $dado->solicitacao->divisao != null ? $dado->solicitacao->divisao->nome : 'Nenhuma',
                        $dado->produto->modelo_produto,
                        $dado->qntde,
                        (date('d/m/Y H:i', strtotime($dado->created_at)))
                    ];
                }
                break;
            case 'impressoras':
                $dados = LocalImpressora::whereHas('produto', function ($query) {
                    $query->where('tipo_produto', 'IMPRESSORA');
                })->with('produto', 'divisao', 'diretoria');

                $dados = $this->filtroData($request, $dados);
                $nome = 'Impressoras';
                $nomeFile = 'impressoras';

                switch ($tipo) {
                    case 'Orgao':
                        $filtro = 'Órgão';
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('diretoria.orgao', function ($query) use ($campo, $valor) {
                                $query->where('orgaos.'.$campo, $valor);
                            })->get();
                        }

                        $dadosAgrupados = $dados->groupBy(function ($impressora) {
                            return $impressora->diretoria->orgao->nome;
                        });
                        break;
                    case 'Diretoria':
                        $filtro = 'Diretoria';
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('diretoria', function ($query) use ($campo, $valor) {
                                $query->where('diretorias.'.$campo, $valor);
                            })->get();
                        }
                        $dadosAgrupados = $dados->groupBy(function ($impressora) {
                            return $impressora->diretoria->nome;
                        });
                        break;
                    case 'Divisao':
                        $filtro = 'Divisão';
                        if ($campo == 'todos') {
                            $dados = $dados->whereHas('divisao', function ($query) {
                                $query->where('divisoes.id', '!=', null);
                            })->get();
                        } else {
                            $dados = $dados->whereHas('divisao', function ($query) use ($campo, $valor) {
                                $query->where('divisoes.'.$campo, $valor);
                            })->get();
                        }
                        $dadosAgrupados = $dados->groupBy(function ($impressora) {
                            return $impressora->divisao->nome;
                        });
                        break;
                    default:
                        session()->flash('mensagem', 'Informe um campo de filtro válido.');
                        session()->flash('color', 'warning');
                        break;
                }
                $headers = [
                    'ID da Impressora',
                    'Modelo',
                    'Diretoria',
                    'Divisão',
                    'Quantidade Total'
                ];
                $dadosExcel = [];
                foreach($dados as $dado) {
                    $dadosExcel[] = [
                        $dado->produto->id,
                        $dado->produto->modelo_produto,
                        $dado->diretoria->nome,
                        $dado->divisao != null ? $dado->divisao->nome : 'Nenhuma',
                        $dado->produto->qntde_estoque,
                    ];
                }
                break;
            case 'usuarios':
                $dados = Usuario::with(['diretoria.orgao', 'divisao']);

                $dados = $this->filtroData($request, $dados);
                $nome = 'Usuários';
                $nomeFile = 'usuarios';

                switch ($tipo) {
                    case 'Orgao':
                        $filtro = 'Órgão';
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('diretoria.orgao', function ($query) use ($campo, $valor) {
                                $query->where('orgaos.'.$campo, $valor);
                            })->get();
                        }
                        $dadosAgrupados = $dados->groupBy(function ($usuario) {
                            return $usuario->diretoria->orgao->nome;
                        });
                        break;
                    case 'Diretoria':
                        $filtro = 'Diretoria';
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('diretoria', function ($query) use ($campo, $valor) {
                                $query->where('diretorias.'.$campo, $valor);
                            });
                        }
                        $dadosAgrupados = $dados->groupBy(function ($usuario) {
                            return $usuario->diretoria->nome;
                        });
                        break;
                    case 'Divisao':
                        $filtro = 'Divisão';
                        if ($campo == 'todos') {
                            $dados = $dados->whereHas('divisao', function ($query) {
                                $query->where('divisoes.id', '!=', null);
                            })->get();
                        } else {
                            $dados = $dados->whereHas('divisao', function ($query) use ($campo, $valor) {
                                $query->where('divisoes.'.$campo, $valor);
                            })->get();
                        }
                        $dadosAgrupados = $dados->groupBy(function ($usuario) {
                            return $usuario->divisao->nome;
                        });
                        break;
                    default:
                        session()->flash('mensagem', 'Informe um campo de filtro válido.');
                        session()->flash('color', 'warning');
                        break;
                }

                $headers = [
                    'ID',
                    'Nome',
                    'Diretoria',
                    'Divisão',
                    'CPF',
                    'Email',
                    'Status',
                    'Data de Cadastro'
                ];
                $dadosExcel = [];
                foreach($dados as $dado) {
                    $dadosExcel[] = [
                        $dado->id,
                        $dado->nome,
                        $dado->diretoria->nome,
                        $dado->divisao != null ? $dado->divisao->nome : 'Nenhuma',
                        chunk_split($dado->cpf, 3, '.') . '-' . substr($dado->cpf, 9),
                        $dado->email,
                        ucfirst(strtolower($dado->status)),
                        (date('d/m/Y H:i', strtotime($dado->created_at)))
                    ];
                }
                break;
            case 'solicitacoes':
                $dados = Solicitacao::with(['diretoria', 'divisao', 'usuario', 'produtos']);

                $dados = $this->filtroData($request, $dados);
                $nome = 'Solicitações';
                $nomeFile = 'solicitacoes';

                switch ($tipo) {
                    case 'Orgao':
                        $filtro = 'Órgão';
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('diretoria.orgao', function ($query) use ($campo, $valor) {
                                $query->where('orgaos.'.$campo, $valor);
                            })->get();
                        }
                        $dadosAgrupados = $dados->groupBy(function ($solicitacao) {
                            return $solicitacao->diretoria->orgao->nome;
                        });
                        break;
                    case 'Diretoria':
                        $filtro = 'Diretoria';
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('diretoria', function ($query) use ($campo, $valor) {
                                $query->where('diretorias.'.$campo, $valor);
                            })->get();
                        }
                        $dadosAgrupados = $dados->groupBy(function ($solicitacao) {
                            return $solicitacao->diretoria->nome;
                        });
                        break;
                    case 'Divisao':
                        $filtro = 'Divisão';
                        if ($campo == 'todos') {
                            $dados = $dados->whereHas('divisao', function ($query) {
                                $query->where('divisoes.id', '!=', null);
                            })->get();
                        } else {
                            $dados = $dados->whereHas('divisao', function ($query) use ($campo, $valor) {
                                $query->where('divisoes.'.$campo, $valor);
                            })->get();
                        }
                        $dadosAgrupados = $dados->groupBy(function ($solicitacao) {
                            return $solicitacao->divisao->nome;
                        });
                        break;
                    case 'Usuario':
                        $filtro = '';
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            $dados = $dados->whereHas('usuario', function ($query) use ($campo, $valor) {
                                $query->where('usuario.'.$campo, $valor);
                            })->get();
                        }
                        $dadosAgrupados = $dados->groupBy(function ($solicitacao) {
                            return $solicitacao->usuario->nome;
                        });
                        break;
                    case 'Produto':
                        $filtro = 'Produto';
                        if ($campo == 'todos') {
                            $dados = $dados->get();
                        } else {
                            if ($campo == 'nome') $campo = 'modelo_produto';
                            $dados = $dados->whereHas('produtos', function ($query) use ($campo, $valor) {
                                $query->where('produtos.'.$campo, $valor);
                            })->get();
                        }
                        $dadosAgrupados = $dados->groupBy(function ($solicitacao) {
                            return $solicitacao->produtos[0]->modelo_produto;
                        });
                        break;
                    default:
                        session()->flash('mensagem', 'Informe um campo de filtro válido.');
                        session()->flash('color', 'warning');
                        break;
                }

                $headers = [
                    'Código',
                    'Diretoria',
                    'Divisão',
                    'Status',
                    'Produto(s)',
                    'Data de Criação'
                ];
                $dadosExcel = [];
                foreach($dados as $dado) {
                    $produtos = '';
                    foreach($dado->produtos as $index => $produto) {
                        if($index == 0) {
                            $produtos .= $produto->modelo_produto.":".$produto->pivot->qntde." \n ";
                        } else {
                            $produtos .= $produto->modelo_produto.":".$produto->pivot->qntde;
                        }
                    }
                    $dadosExcel[] = [
                        $dado->id,
                        $dado->diretoria->nome,
                        $dado->divisao != null ? $dado->divisao->nome : 'Nenhuma',
                        ucfirst(strtolower($dado->status)),
                        $produtos,
                        (date('d/m/Y H:i', strtotime($dado->created_at)))
                    ];
                }
                break;
            default:
                session()->flash('mensagem', 'Informe um item de busca válido.');
                session()->flash('color', 'warning');
                return redirect()->route('relatorios.index');
                break;
        }

        if($dados->count() == 0) {
            session()->flash('mensagem', 'Nenhum resultado encontrado.');
            session()->flash('color', 'warning');
            return redirect()->route('relatorios.index');
        }

        $dataAtual = date('d/m/Y');
        $dataAtualFile = date('d-m-Y');
        $horaAtual = date('H:i:s');
        $horaAtualFile = date('His');

        switch($formato) {
            case 'pdf':
                $pdf = Pdf::loadView('relatorio.pdf', ['dados' =>$dadosAgrupados, 'headers' => $headers, 'nome' => $nome, 'filtro' => $filtro, 'dataAtual' => $dataAtual, 'horaAtual' => $horaAtual])->setPaper('a4', $request->orientacao);
                return $pdf->download('relatorio_'.$nomeFile.'_'.$dataAtualFile.'_'.$horaAtualFile.'.pdf');
                break;
            case 'xslx':
                return Excel::download(new RelatorioExport($dadosExcel, $headers), 'relatorio_'.$nomeFile.'_'.$dataAtualFile.'_'.$horaAtualFile.'.xlsx');
                break;
            case 'csv':
                return Excel::download(new RelatorioExport($dadosExcel, $headers), 'relatorio_'.$nomeFile.'_'.$dataAtualFile.'_'.$horaAtualFile.'.csv', \Maatwebsite\Excel\Excel::CSV);
                break;
        }
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
                if (!isset($request->data_inicio) || !isset($request->data_final)) {
                    session()->flash('mensagem', 'Informe uma data válida.');
                    session()->flash('color', 'danger');
                    return redirect()->route('relatorios.index');
                }

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