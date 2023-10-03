<?php

namespace App\Services\FiltrosRelatorio\FiltroImpressoras;

class FiltroDefault implements FiltroImpressorasInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
        session()->flash('mensagem', 'Informe um filtro de impressoras válido.');
        session()->flase('color', 'warning');
        return redirect()->back();
    }
}