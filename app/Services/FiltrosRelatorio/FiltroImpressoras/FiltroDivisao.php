<?php

namespace App\Services\FiltrosRelatorio\FiltroImpressoras;

class FiltroDivisao implements FiltrosImpressoraInterface
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
        $dadosAgrupados = $dados->groupBy(function ($impressora) {
            if ($impressora->divisao->id == null) return 'N/D';
            return $impressora->divisao->nome;
        });

        $resposta = new \stdClass();
        $resposta->filtro = $filtro;
        $resposta->dadosAgrupados = $dadosAgrupados;
        $resposta->dados = $dados;

        return $resposta;
    }
}