<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface FiltroDataInterface
{
    public function filtroData(Request $request, $dados);
}