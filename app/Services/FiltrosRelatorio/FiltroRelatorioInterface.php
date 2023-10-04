<?php

namespace App\Services\FiltrosRelatorio;

use Illuminate\Http\Request;

interface FiltroRelatorioInterface
{
    public function filtroItem(string $item, string $tipo, string $campo, $valor, Request $request);
}