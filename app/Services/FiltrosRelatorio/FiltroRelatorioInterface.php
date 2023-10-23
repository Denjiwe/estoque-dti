<?php

namespace App\Services\FiltrosRelatorio;

use Illuminate\Http\Request;

interface FiltroRelatorioInterface
{
    /**
     * Realiza o instanciamento para a estratégia de filtro necessária
     */
    public function filtroItem(string $item, string $tipo, string $campo, $valor, Request $request);
}