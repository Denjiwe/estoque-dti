<?php

namespace App\Services\FiltrosRelatorio\FiltroImpressoras;

interface FiltrosImpressoraInterface
{
    public function filtroTipo(string $campo, $valor, $dados);
}