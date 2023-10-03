<?php

namespace App\Services\FiltrosRelatorio\FiltroSolicitacoes;

class FiltroProduto implements FiltroSolicitacaoInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
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

        return new \stdClass([
            'filtro' => $filtro,
            'dadosAgrupados' => $dadosAgrupados,
            'dados' => $dados
        ]);
    }
}