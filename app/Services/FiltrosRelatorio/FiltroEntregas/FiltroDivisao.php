<?php

namespace App\Services\FiltrosRelatorio\FiltroEntregas;

class FiltroDivisao implements FiltrosEntregaInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
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
            if ($entrega->solicitacao->divisao_id == null) return 'N/D';
            return $entrega->solicitacao->divisao->nome;
        });

        $resposta = new \stdClass();
        $resposta->filtro = $filtro;
        $resposta->dadosAgrupados = $dadosAgrupados;
        $resposta->dados = $dados;

        return $resposta;
    }
}