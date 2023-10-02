<?php

namespace App\Services\FiltrosData;

use App\Interfaces\FiltroDataInterface;
use Illuminate\Http\Request;

class FiltroQualquer implements FiltroDataInterface
{
    public function filtroData(Request $request, $dados)
    {
        return $dados;
    }
}