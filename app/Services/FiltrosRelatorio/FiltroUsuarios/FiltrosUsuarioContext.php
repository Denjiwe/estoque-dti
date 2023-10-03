<?php

namespace App\Services\FiltrosRelatorio\FiltroUsuarios;

class FiltrosUsuarioContext
{
    private FiltrosUsuarioInterface $strategy;

    public function __construct(string $tipo)
    {
        $this->strategy = match($tipo) {
            'Orgao'       => new FiltroOrgao(),
            'Diretoria'   => new FiltroDiretoria(),
            'Divisao'     => new FiltroDivisao(),
            default       => new FiltroDefault(),
        };
    }

    public function filtroTipo(string $campo, $valor, $dados)
    {
        return $this->strategy->filtroTipo($campo, $valor, $dados);
    }
}