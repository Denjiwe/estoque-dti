<?php

namespace App\Services\FiltrosRelatorio;

use App\Models\Solicitacao;
use Illuminate\Http\Request;
use App\Services\FiltrosData\FiltroDataContext;
use App\Services\FiltrosRelatorio\FiltroSolicitacoes\FiltrosSolicitacaoContext;

class FiltroSolicitacoes implements FiltroRelatorioInterface
{
    public function filtroItem(string $item, string $tipo, string $campo, $valor, Request $request) {
        $dados = Solicitacao::with(['diretoria', 'divisao', 'usuario', 'produtos']);

        $filtroData = new FiltroDataContext($request->data);
        $dados = $filtroData->filtroData($request, $dados);
        if ($dados instanceof \Illuminate\Http\RedirectResponse) {
            return $dados;
        }

        $nome = 'Solicitações';
        $nomeFile = 'solicitacoes';

        $filtroTipo = new FiltrosSolicitacaoContext($tipo);

        $filtroTipo = $filtroTipo->filtroTipo($campo, $valor, $dados);

        if ($filtroTipo instanceof \Illuminate\Http\RedirectResponse) {
            return $filtroTipo;
        }

        $dados = $filtroTipo->dados;
        $dadosAgrupados = $filtroTipo->dadosAgrupados;
        $filtro = $filtroTipo->filtro;

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

        $resposta = new \stdClass();
        $resposta->nome = $nome;
        $resposta->nomeFile = $nomeFile;
        $resposta->headers = $headers;
        $resposta->dadosExcel = $dadosExcel;
        $resposta->dadosAgrupados = $dadosAgrupados;
        $resposta->filtro = $filtro;

        return $resposta;
    }
}