<?php

namespace App\Services\FiltrosRelatorio\FiltroUsuarios;

class FiltroOrgao implements FiltrosUsuarioInterface
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
        $dadosAgrupados = $dados->groupBy(function ($usuario) {
            return $usuario->diretoria->orgao->nome;
        });

        $resposta = new \stdClass();
        $resposta->filtro = $filtro;
        $resposta->dadosAgrupados = $dadosAgrupados;
        $resposta->dados = $dados;

        return $resposta;
    }
}