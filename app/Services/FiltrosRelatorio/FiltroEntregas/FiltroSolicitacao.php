<?php

namespace App\Services\FiltrosRelatorio\FiltroEntregas;

class FiltroSolicitacao implements FiltrosEntregaInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
        $filtro = 'Solicitação';
        if ($campo == 'todos') {
            $dados = $dados->get();
        } else {
            $dados = $dados->whereHas('solicitacao', function ($query) use ($campo, $valor) {
                $query->where('solicitacoes.'.$campo, $valor);
            })->get();
        }

        $dadosAgrupados = $dados->groupBy(function ($entrega) {
            return '#'.$entrega->solicitacao->id;
        });

        $resposta = new \stdClass();
        $resposta->filtro = $filtro;
        $resposta->dadosAgrupados = $dadosAgrupados;
        $resposta->dados = $dados;

        return $resposta;
    }
}