<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Entrega;
use App\Models\LocalImpressora;
use App\Models\Solicitacao;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RelatorioExport;
use App\Services\FiltrosRelatorio\FiltroRelatorioContext;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function index() {
        return view('relatorio.index');
    }

    public function pesquisa(Request $request) {
        $item = $request->item;
        $tipo = $request->tipo;
        $campo = $request->campo;
        if (isset($request->valor)) {
            $valor = $request->valor;
        } else {
            $valor = null;
        }
        $formato = $request->formato;

        $filtro = new FiltroRelatorioContext($item);
        if ($filtro instanceof \Illuminate\Http\RedirectResponse) return $filtro;

        $dadosFiltrados = $filtro->filtroItem($item, $tipo, $campo, $valor, $request);
        if ($dadosFiltrados instanceof \Illuminate\Http\RedirectResponse) return $dadosFiltrados;

        $nome = $dadosFiltrados->nome;
        $nomeFile = $dadosFiltrados->nomeFile;
        $headers = $dadosFiltrados->headers;
        $dadosExcel = $dadosFiltrados->dadosExcel;
        $dadosAgrupados = $dadosFiltrados->dadosAgrupados;
        $filtro = $dadosFiltrados->filtro;

        if(count($dadosExcel) == 0) {
            session()->flash('mensagem', 'Nenhum resultado encontrado.');
            session()->flash('color', 'warning');
            return redirect()->route('relatorios.index');
        }

        $dataAtual = date('d/m/Y');
        $dataAtualFile = date('d-m-Y');
        $horaAtual = date('H:i:s');
        $horaAtualFile = date('His');

        switch($formato) {
            case 'pdf':
                $pdf = Pdf::loadView('relatorio.pdf', ['dados' =>$dadosAgrupados, 'headers' => $headers, 'nome' => $nome, 'filtro' => $filtro, 'dataAtual' => $dataAtual, 'horaAtual' => $horaAtual])->setPaper('a4', $request->orientacao);
                return $pdf->download('relatorio_'.$nomeFile.'_'.$dataAtualFile.'_'.$horaAtualFile.'.pdf');
                break;
            case 'xslx':
                return Excel::download(new RelatorioExport($dadosExcel, $headers), 'relatorio_'.$nomeFile.'_'.$dataAtualFile.'_'.$horaAtualFile.'.xlsx');
                break;
            case 'csv':
                return Excel::download(new RelatorioExport($dadosExcel, $headers), 'relatorio_'.$nomeFile.'_'.$dataAtualFile.'_'.$horaAtualFile.'.csv', \Maatwebsite\Excel\Excel::CSV);
                break;
        }
    }
}