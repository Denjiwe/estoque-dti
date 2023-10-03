<?php

namespace App\Services\FiltrosRelatorio;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Services\FiltrosData\FiltroDataContext;
use App\Services\FiltrosRelatorio\FiltroUsuarios\FiltrosUsuarioContext;

class FiltroUsuarios implements FiltroRelatorioInterface
{
    public function filtroItem(string $item, string $tipo, string $campo, $valor, $dados, Request $request) {
        $dados = Usuario::with(['diretoria.orgao', 'divisao']);

        $filtroData = new FiltroDataContext($request->data);
        $dados = $filtroData->filtroData($request, $dados);
        if ($dados instanceof \Illuminate\Http\RedirectResponse) {
            return $dados;
        }

        $nome = 'Usuários';
        $nomeFile = 'usuarios';

        $filtroTipo = new FiltrosUsuarioContext($tipo);

        $filtroTipo->filtroTipo($campo, $valor, $dados);

        if ($filtroTipo instanceof \Illuminate\Http\RedirectResponse) {
            return $filtroTipo;
        }

        $dados = $filtroTipo->dados;
        $dadosAgrupados = $filtroTipo->dadosAgrupados;
        $filtro = $filtroTipo->filtro;

        $headers = [
            'ID',
            'Nome',
            'Diretoria',
            'Divisão',
            'CPF',
            'Email',
            'Status',
            'Data de Cadastro'
        ];
        $dadosExcel = [];
        foreach($dados as $dado) {
            $dadosExcel[] = [
                $dado->id,
                $dado->nome,
                $dado->diretoria->nome,
                $dado->divisao != null ? $dado->divisao->nome : 'Nenhuma',
                chunk_split($dado->cpf, 3, '.') . '-' . substr($dado->cpf, 9),
                $dado->email,
                ucfirst(strtolower($dado->status)),
                (date('d/m/Y H:i', strtotime($dado->created_at)))
            ];
        }

        return new \stdClass([
            'nome' => $nome,
            'nomeFile' => $nomeFile,
            'headers' => $headers,
            'dadosExcel' => $dadosExcel,
            'filtro' => $filtro
        ]);
    }
}