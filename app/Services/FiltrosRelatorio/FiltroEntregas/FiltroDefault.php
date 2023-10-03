<?php

namespace App\Services\FiltrosRelatorio\FiltroEntregas;

use App\Models\Entrega;

class FiltroDefault implements FiltroEntregasInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
        session()->flash('mensagem', 'Informe um filtro de entregas válido.');
        session()->flase('color', 'warning');
        return redirect()->back();
    }
}