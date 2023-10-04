<?php

namespace App\Services\FiltrosRelatorio;

use Illuminate\Http\Request;

class FiltroRelatorioContext
{
    private FiltroRelatorioInterface $strategy;

    public function __construct(string $item)
    {
        $this->strategy = match($item) {
            'entregas'     => new FiltroEntregas(),
            'impressoras'  => new FiltroImpressoras(),
            'solicitacoes' => new FiltroSolicitacoes(),
            'usuarios'     => new FiltroUsuarios(),
            default        => new FiltroDefault(),
        };
    }

    public function filtroItem(string $item, string $tipo, string $campo, $valor, Request $request) 
    {
        return $this->strategy->filtroItem($item, $tipo, $campo, $valor, $request);
    }
}