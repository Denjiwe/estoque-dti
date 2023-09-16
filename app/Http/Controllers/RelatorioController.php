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

        switch ($item) {
            case 'entregas':
                switch ($tipo) {
                    case 'Orgao':
                        $entregas = Entrega::where('orgao_id', $valor)->get();
                        break;
                    case 'Diretoria':
                        $entregas = Entrega::where('diretoria_id', $valor)->get();
                        break;
                    case 'Divisao':
                        $entregas = Entrega::where('divisao_id', $valor)->get();
                        break;
                    case 'Usuario':
                        $entregas = Entrega::where('usuario_id', $valor)->get();
                        break;
                    case 'Solicitacao':
                        $entregas = Entrega::where('solicitacao_id', $valor)->get();
                        break;
                    case 'Entrega':
                        $entregas = Entrega::where('id', $valor)->get();
                        break;
                    case 'Produto':
                        $entregas = Entrega::where('produto_id', $valor)->get();
                }
                break;
            case 'impressoras':
                break;
            case 'produtos':
                break;
            case 'usuarios':
                break;
            case 'solicitacoes':
                break;
            default:
                break;
        }
    }
}
