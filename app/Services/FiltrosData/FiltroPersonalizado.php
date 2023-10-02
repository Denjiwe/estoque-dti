<?php

namespace App\Services\FiltrosData;

use App\Interfaces\FiltroDataInterface;
use Illuminate\Http\Request;

class FiltroPersonalizado implements FiltroDataInterface
{
    public function filtroData(Request $request, $dados)
    {
        if (!isset($request->data_inicio) || !isset($request->data_final)) {
            session()->flash('mensagem', 'Informe uma data válida.');
            session()->flash('color', 'danger');
            return redirect()->route('relatorios.index');
        }

        if($request->data_inicio > $request->data_final) {
            session()->flash('mensagem', 'A data inicial deve ser menor que a data final!');
            session()->flash('color', 'danger');
            return redirect()->route('relatorios.index');
        }

        return $dados->whereBetween('created_at', [$request->data_inicio, $request->data_final]);
    }
}