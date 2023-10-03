<?php

namespace App\Services\FiltrosData;

use Illuminate\Http\Request;

class FiltroMes implements FiltroDataInterface
{
    public function filtroData(Request $request, $dados)
    {
        return $dados->whereDate('created_at', '>=', date('Y-m-d', strtotime('-30 days')));
    }
}