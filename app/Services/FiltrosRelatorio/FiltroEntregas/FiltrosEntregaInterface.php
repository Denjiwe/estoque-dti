<?php

namespace App\Services\FiltrosRelatorio\FiltroEntregas;

interface FiltrosEntregaInterface
{
    public function filtroTipo(string $campo, $valor, $dados);
}