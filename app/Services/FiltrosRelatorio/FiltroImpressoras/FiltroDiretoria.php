<?php

namespace App\Services\FiltrosRelatorio\FiltroImpressoras;

class FiltroDiretoria implements FiltrosImpressoraInterface
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
        $dadosAgrupados = $dados->groupBy(function ($impressora) {
            return $impressora->diretoria->nome;
        });

        $resposta = new \stdClass();
        $resposta->filtro = $filtro;
        $resposta->dadosAgrupados = $dadosAgrupados;
        $resposta->dados = $dados;

        return $resposta;
    }
}