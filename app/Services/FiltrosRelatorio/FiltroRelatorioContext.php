<?php

namespace App\Services\FiltrosRelatorio;

class FiltroRelatorioContext
{
    private FiltrosRelatorioInterface $strategy;

    public function __construct(string $tipo)
    {
        $this->strategy = match($tipo) {
            'entregas'       => new FiltroEntregas(),
            'impressoras'   => new FiltroImpressoras(),
            'solicitacoes'     => new FiltroSolicitacoes(),
            'usuarios'     => new FiltroUsuarios(),
            default       => new FiltroDefault(),
        };
    }

    public function filtroItem(string $item, string $tipo, string $campo, $valor, $dados) 
    {
        return $this->strategy->filtroItem($item, $tipo, $campo, $valor, $dados);
    }
}