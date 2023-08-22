<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Diretoria;
use App\Models\Divisao;
use App\Models\Entrega;
use App\Models\LocalImpressora;
use App\Models\Produto;
use App\Models\Orgao;
use App\Models\Suprimento;
use App\Models\Solicitacao;
use Barryvdh\DomPDF\Facade\PDF;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\RelatorioExport;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function index() {
        return view('relatorio.index');
    }

    public function pesquisa(Request $request) {
        dd($request->all());
        $item = $request->item;
        $tipo = $request->tipo;
        $campo = $request->campo;
        if (isset($request->valor)) {
            $valor = $request->valor;
        } else {
            $valor = null;
        }
        $data = $request->data;
        if($data == 'personalizado') {
            $data_inicial = $request->data_inicial;
            $data_final = $request->data_final;
        } else {
            $data_inicial = null;
            $data_final = null;
        }
        $formato = $request->formato;
    }
}
