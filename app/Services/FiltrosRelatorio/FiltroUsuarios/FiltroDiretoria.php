<?php

namespace App\Services\FiltrosRelatorio\FiltroUsuarios;

class FiltroDiretoria implements FiltroUsuarioInterface
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
        $dadosAgrupados = $dados->groupBy(function ($usuario) {
            return $usuario->diretoria->nome;
        });

        return new \stdClass([
            'filtro' => $filtro,
            'dadosAgrupados' => $dadosAgrupados,
            'dados' => $dados
        ]);
    }
}