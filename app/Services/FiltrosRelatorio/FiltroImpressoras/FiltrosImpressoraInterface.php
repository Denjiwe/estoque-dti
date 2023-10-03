<?php

namespace App\Services\FiltrosRelatorio\FiltroImpressoras;

interface FiltroImpressoraInterface
{
    public function filtroTipo(string $campo, $valor, $dados);
}