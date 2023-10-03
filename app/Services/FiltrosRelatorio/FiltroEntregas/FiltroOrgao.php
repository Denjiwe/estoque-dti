<?php

namespace App\Services\FiltrosRelatorio\FiltroEntregas;

class FiltroOrgao implements FiltroEntregasInterface
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

        return new \stdClass([
            'filtro' => $filtro,
            'dadosAgrupados' => $dadosAgrupados,
            'dados' => $dados
        ]);
    }
}