<?php

namespace App\Services\FiltrosData;

use Illuminate\Http\Request;

class FiltroUltimoMes implements FiltroDataInterface
{
    public function filtroData(Request $request, $dados)
    {
        return $dados->whereMonth('created_at', date('m'));
    }
}