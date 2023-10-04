<?php

namespace App\Services\FiltrosRelatorio\FiltroSolicitacoes;

class FiltroDefault implements FiltrosSolicitacaoInterface
{
    public function filtroTipo(string $campo, $valor, $dados) 
    {
        session()->flash('mensagem', 'Informe um filtro de solicitações válido.');
        session()->flase('color', 'warning');
        return redirect()->back();
    }
}