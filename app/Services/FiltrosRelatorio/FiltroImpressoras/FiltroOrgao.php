<?php

namespace App\Services\FiltrosRelatorio\FiltroImpressoras;

class FiltroOrgao implements FiltrosImpressoraInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
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

        $resposta = new \stdClass();
        $resposta->filtro = $filtro;
        $resposta->dadosAgrupados = $dadosAgrupados;
        $resposta->dados = $dados;

        return $resposta;
    }
}