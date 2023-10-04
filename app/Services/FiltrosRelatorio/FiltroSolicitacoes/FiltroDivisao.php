<?php

namespace App\Services\FiltrosRelatorio\FiltroSolicitacoes;

class FiltroDivisao implements FiltrosSolicitacaoInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
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
            if($solicitacao->divisao == null) return 'N/D';
            return $solicitacao->divisao->nome;
        });

        $resposta = new \stdClass();
        $resposta->filtro = $filtro;
        $resposta->dadosAgrupados = $dadosAgrupados;
        $resposta->dados = $dados;

        return $resposta;
    }
}