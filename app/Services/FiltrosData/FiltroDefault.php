<?php

namespace App\Services\FiltrosData;

use Illuminate\Http\Request;

class FiltroDefault implements FiltroDataInterface
{
    public function filtroData(Request $request, $dados)
    {
        session()->flash('color', 'warning');
        session()->flash('mensagem', 'Informe um filtro de data válido.');
        return redirect()->back();
    }
}