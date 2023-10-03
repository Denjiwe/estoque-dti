<?php

namespace App\Services\FiltrosRelatorio\FiltroSolicitacoes;

interface FiltrosSolicitacaoInterface
{
    public function filtroTipo(string $campo, $valor, $dados);
}