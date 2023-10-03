<?php

namespace App\Services\FiltrosRelatorio\FiltroEntregas;

use App\Models\Entrega;

class FiltroProduto implements FiltroEntregasInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
        $filtro = 'Produto';
        if ($campo == 'todos') {
            $dados = $dados->get();
        } else {
            $dados = $dados->whereHas('produto', function ($query) use ($campo, $valor) {
                $query->where('produtos.'.$campo, $valor);
            })->get();
        }

        $dadosAgrupados = $dados->groupBy(function ($entrega) {
            return $entrega->produto->modelo_produto;
        });

        return new \stdClass([
            'filtro' => $filtro,
            'dadosAgrupados' => $dadosAgrupados,
            'dados' => $dados
        ]);
    }
}