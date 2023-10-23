<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Orgao;
use App\Models\Diretoria;
use App\Models\Divisao;
use App\Models\Usuario;
use App\Models\Solicitacao;
use App\Models\Entrega;

class BuscaController extends Controller
{
    /**
     * Realiza a busca de vários dados
     */
    public function busca($item, $valor)
    {
        $tabelas = ['Orgao', 'Diretoria', 'Divisao', 'Usuario', 'Produto'];

        if(in_array($item, $tabelas)) {
            switch($item) {
                case 'Orgao':
                    $busca = Orgao::where('nome', 'like', '%'.$valor.'%')->get();
                    break;
                case 'Diretoria':
                    $busca = Diretoria::where('nome', 'like', '%'.$valor.'%')->get();
                    break;
                case 'Divisao':
                    $busca = Divisao::where('nome', 'like', '%'.$valor.'%')->get();
                    break;
                case 'Usuario':
                    $busca = Usuario::where('nome', 'like', '%'.$valor.'%')->get();
                    break;
                case 'Produto':
                    $busca = Produto::where('modelo_produto', 'like', '%'.$valor.'%')->get();
                    foreach($busca as $b) {
                        $b->nome = $b->modelo_produto;
                    }
                    break;
            }
        } else {
            $busca = null;
        }

        return response()->json($busca);
    }
}
