<?php

namespace App\Services\FiltrosRelatorio\FiltroEntregas;

use App\Models\Entrega;

class FiltroUsuario implements FiltroEntregasInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
        $filtro = '';
        if ($campo == 'todos') {
            $dados = $dados->get();
        } else {
            $dados = $dados->whereHas('solicitacao.usuario', function ($query) use ($campo, $valor) {
                $query->where('usuario.'.$campo, $valor);
            })->get();
        }

        $dadosAgrupados = $dados->groupBy(function ($entrega) {
            return $entrega->solicitacao->usuario->nome;
        });

        return new \stdClass([
            'filtro' => $filtro,
            'dadosAgrupados' => $dadosAgrupados,
            'dados' => $dados
        ]);
    }
}