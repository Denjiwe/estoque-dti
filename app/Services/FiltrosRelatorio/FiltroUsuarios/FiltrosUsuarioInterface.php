<?php

namespace App\Services\FiltrosRelatorio\FiltroUsuarios;

interface FiltrosUsuarioInterface
{
    public function filtroTipo(string $campo, $valor, $dados);
}