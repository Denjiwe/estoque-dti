<?php

namespace App\Services\FiltrosRelatorio\FiltroSolicitacoes;

class FiltroDiretoria implements FiltrosSolicitacaoInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
        $filtro = 'Diretoria';
        if ($campo == 'todos') {
            $dados = $dados->get();
        } else {
            $dados = $dados->whereHas('diretoria', function ($query) use ($campo, $valor) {
                $query->where('diretorias.'.$campo, $valor);
            })->get();
        }
        $dadosAgrupados = $dados->groupBy(function ($solicitacao) {
            return $solicitacao->diretoria->nome;
        });

        $resposta = new \stdClass();
        $resposta->filtro = $filtro;
        $resposta->dadosAgrupados = $dadosAgrupados;
        $resposta->dados = $dados;

        return $resposta;
    }
}