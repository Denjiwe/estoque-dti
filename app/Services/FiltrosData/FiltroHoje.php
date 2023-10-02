<?php

namespace App\Services\FiltrosData;

use App\Interfaces\FiltroDataInterface;
use Illuminate\Http\Request;

class FiltroHoje implements FiltroDataInterface
{
    public function filtroData(Request $request, $dados)
    {
        return $dados->whereDate('created_at', date('Y-m-d'));
    }
}