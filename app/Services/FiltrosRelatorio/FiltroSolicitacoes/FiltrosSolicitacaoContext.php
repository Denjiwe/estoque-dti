<?php

namespace App\Services\FiltrosRelatorio\FiltroSolicitacoes;

class FiltrosSolicitacaoContext
{
    private FiltrosSolicitacaoInterface $strategy;

    public function __construct(string $tipo)
    {
        $this->strategy = match($tipo) {
            'Orgao'       => new FiltroOrgao(),
            'Diretoria'   => new FiltroDiretoria(),
            'Divisao'     => new FiltroDivisao(),
            'Usuario'     => new FiltroUsuario(),
            'Produto'     => new FiltroProduto(),
            default       => new FiltroDefault(),
        };
    }

    public function filtroTipo(string $campo, $valor, $dados)
    {
        return $this->strategy->filtroTipo($campo, $valor, $dados);
    }
}