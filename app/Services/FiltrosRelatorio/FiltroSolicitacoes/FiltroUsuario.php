<?php

namespace App\Services\FiltrosRelatorio\FiltroSolicitacoes;

class FiltroUsuario implements FiltrosSolicitacaoInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
        $filtro = '';
        if ($campo == 'todos') {
            $dados = $dados->get();
        } else {
            $dados = $dados->whereHas('usuario', function ($query) use ($campo, $valor) {
                $query->where('usuarios.'.$campo, $valor);
            })->get();
        }
        $dadosAgrupados = $dados->groupBy(function ($solicitacao) {
            return $solicitacao->usuario->nome;
        });

        $resposta = new \stdClass();
        $resposta->filtro = $filtro;
        $resposta->dadosAgrupados = $dadosAgrupados;
        $resposta->dados = $dados;

        return $resposta;
    }
}