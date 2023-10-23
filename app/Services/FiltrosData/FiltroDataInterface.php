<?php

namespace App\Services\FiltrosData;

use Illuminate\Http\Request;

interface FiltroDataInterface
{
    /**
     * Realiza o instanciamento para a estratégia de filtro necessária
     */
    public function filtroData(Request $request, $dados);
}