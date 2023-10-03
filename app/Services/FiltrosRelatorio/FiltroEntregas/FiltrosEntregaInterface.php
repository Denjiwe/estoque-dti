<?php

namespace App\Services\FiltrosRelatorio\FiltroEntregas;

interface FiltroEntregaInterface
{
    public function filtroTipo(string $campo, $valor, $dados);
}