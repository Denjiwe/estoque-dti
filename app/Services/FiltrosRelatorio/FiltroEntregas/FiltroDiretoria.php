<?php

namespace App\Services\FiltrosRelatorio\FiltroEntregas;

class FiltroDiretoria implements FiltroEntregasInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
        $filtro = 'Diretoria';
        if ($campo == 'todos') {
            $dados = $dados->get();
        } else {
            $dados = $dados->whereHas('solicitacao.diretoria', function ($query) use ($campo, $valor) {
                $query->where('diretorias.'.$campo, $valor);
            })->get();
        }

        $dadosAgrupados = $dados->groupBy(function ($entrega) {
            return $entrega->solicitacao->diretoria->nome;
        });

        return new \stdClass([
            'filtro' => $filtro,
            'dadosAgrupados' => $dadosAgrupados,
            'dados' => $dados
        ]);
    }
}