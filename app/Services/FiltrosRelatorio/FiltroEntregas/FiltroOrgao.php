<?php

namespace App\Services\FiltrosRelatorio\FiltroEntregas;

class FiltroOrgao implements FiltrosEntregaInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
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

        $resposta = new \stdClass();
        $resposta->filtro = $filtro;
        $resposta->dadosAgrupados = $dadosAgrupados;
        $resposta->dados = $dados;

        return $resposta;
    }
}