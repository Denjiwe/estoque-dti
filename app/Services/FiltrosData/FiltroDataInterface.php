<?php

namespace App\Services\FiltrosData;

use Illuminate\Http\Request;

interface FiltroDataInterface
{
    public function filtroData(Request $request, $dados);
}