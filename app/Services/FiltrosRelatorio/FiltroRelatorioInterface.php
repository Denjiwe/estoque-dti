<?php

namespace App\Services\FiltrosRelatorio;

interface FiltroRelatorioInterface
{
    public function filtroItem(string $item, string $tipo, string $campo, $valor, $dados);
}