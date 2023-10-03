<?php

namespace App\Services\FiltrosRelatorio;

use App\Models\LocalImpressora;
use Illuminate\Http\Request;
use App\Services\FiltrosData\FiltroDataContext;
use App\Services\FiltrosRelatorio\FiltroEntregas\FiltrosImpressoraContext;

class FiltroImpressoras implements FiltroDataInterface
{
    public function filtroItem(string $item, string $tipo, string $campo, $valor, $dados, Request $request) {
        $dados = LocalImpressora::whereHas('produto', function ($query) {
            $query->where('tipo_produto', 'IMPRESSORA');
        })->with('produto', 'divisao', 'diretoria');

        $filtroData = new FiltroDataContext($request->data);
        $dados = $filtroData->filtroData($request, $dados);

        $nome = 'Impressoras';
        $nomeFile = 'impressoras';

        if ($dados instanceof \Illuminate\Http\RedirectResponse) {
            return $dados;
        }

        $filtroTipo = new FiltrosImpressoraContext($tipo);

        $filtroTipo->filtroTipo($campo, $valor, $dados);

        if ($filtroTipo instanceof \Illuminate\Http\RedirectResponse) {
            return $filtroTipo;
        }

        $dados = $filtroTipo->dados;
        $dadosAgrupados = $filtroTipo->dadosAgrupados;
        $filtro = $filtroTipo->filtro;

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

        return new \stdClass([
            'nome' => $nome,
            'nomeFile' => $nomeFile,
            'headers' => $headers,
            'dadosExcel' => $dadosExcel,
            'filtro' => $filtro
        ]);
    }
}