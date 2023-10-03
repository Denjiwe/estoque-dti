<?php

namespace App\Services\FiltrosData;

use Illuminate\Http\Request;

class FiltroDataContext
{
    private FiltroDataInterface $strategy;

    public function __construct(string $filtro)
    {
        $this->strategy = match($filtro) {
            'qualquer'      => new FiltroQualquer(),
            'hoje'          => new FiltroHoje(),
            'ontem'         => new FiltroOntem(),
            'semana'        => new FiltroSemana(),
            'mes'           => new FiltroMes(),
            'ultimo_mes'    => new FiltroUltimoMes(),
            'personalizado' => new FiltroPersonalizado(),
            default         => new FiltroDefault(),
        };
    }

    public function filtroData(Request $request, $dados)
    {
        return $this->strategy->filtroData($request, $dados);
    }
}