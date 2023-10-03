<?php

namespace App\Services\FiltrosRelatorio;

use Illuminate\Http\Request;

class FiltroDefault implements FiltroRelatorioInterface
{
    public function filtroItem(string $item, string $tipo, string $campo, $valor, $dados, Request $request) {
            session()->flash('mensagem', 'Informe um item de busca válido.');
            session()->flash('color', 'warning');
            return redirect()->route('relatorios.index');
    }
}