<?php

namespace App\Services\FiltrosRelatorio\FiltroSolicitacoes;

class FiltroOrgao implements FiltrosSolicitacaoInterface
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
        $dadosAgrupados = $dados->groupBy(function ($solicitacao) {
            return $solicitacao->diretoria->orgao->nome;
        });

        $resposta = new \stdClass();
        $resposta->filtro = $filtro;
        $resposta->dadosAgrupados = $dadosAgrupados;
        $resposta->dados = $dados;

        return $resposta;
    }
}