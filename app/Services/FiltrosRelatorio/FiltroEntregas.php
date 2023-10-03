<?php

namespace App\Services\FiltrosRelatorio;

use App\Models\Entrega;
use Illuminate\Http\Request;
use App\Services\FiltrosData\FiltroDataContext;
use App\Services\FiltrosRelatorio\FiltroEntregas\FiltrosEntregaContext;

class FiltroEntregas implements FiltroDataInterface
{
    public function filtroItem(string $item, string $tipo, string $campo, $valor, $dados, Request $request) {
        $dados = Entrega::with('produto', 'usuario', 'solicitacao.usuario', 'solicitacao.diretoria', 'solicitacao.divisao');
        $filtroData = new FiltroDataContext($request->data);

        $dados = $filtroData->filtroData($request, $dados);
        $nome = 'Entregas';
        $nomeFile = 'entregas';

        if ($dados instanceof \Illuminate\Http\RedirectResponse) {
            return $dados;
        }

        $filtroTipo = new FiltrosEntregaContext($tipo);

        $filtroTipo->filtroTipo($campo, $valor, $dados);

        if ($filtroTipo instanceof \Illuminate\Http\RedirectResponse) {
            return $filtroTipo;
        }

        $dados = $filtroTipo->dados;
        $dadosAgrupados = $filtroTipo->dadosAgrupados;
        $filtro = $filtroTipo->filtro;

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

        return new \stdClass([
            'nome' => $nome,
            'nomeFile' => $nomeFile,
            'headers' => $headers,
            'dadosExcel' => $dadosExcel,
            'filtro' => $filtro
        ]);
    }
}