<?php

namespace App\Services\FiltrosRelatorio\FiltroEntregas;

class FiltroUsuario implements FiltrosEntregaInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
        $filtro = '';
        if ($campo == 'todos') {
            $dados = $dados->get();
        } else {
            $dados = $dados->whereHas('solicitacao.usuario', function ($query) use ($campo, $valor) {
                $query->where('usuarios.'.$campo, $valor);
            })->get();
        }

        $dadosAgrupados = $dados->groupBy(function ($entrega) {
            return $entrega->solicitacao->usuario->nome;
        });

        $resposta = new \stdClass();
        $resposta->filtro = $filtro;
        $resposta->dadosAgrupados = $dadosAgrupados;
        $resposta->dados = $dados;

        return $resposta;
    }
}