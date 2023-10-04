<?php

namespace App\Services\FiltrosRelatorio\FiltroUsuarios;

class FiltroDefault implements FiltrosUsuarioInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
        session()->flash('mensagem', 'Informe um filtro de usuários válido.');
        session()->flase('color', 'warning');
        return redirect()->back();
    }
}