<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AuditoriaController extends Controller
{
    public function __construct(Auditoria $auditoria)
    {
        $this->auditoria = $auditoria;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auditoria.index');
    }

    public function pesquisa(Request $request)
    {
        $auditorias = $this->auditoria;

        if($request->tipo != 'Todos') {
            $auditorias = $auditorias->where('auditable_type', 'like', '%'.$request->tipo);	
        }

        if($request->acao != 'Todos') {
            $auditorias = $auditorias->where('event', $request->acao);	
        }

        switch ($request->data) {
            case 'hoje':
                $auditorias = $auditorias->whereDate('created_at', date('Y-m-d'));
                break;
            case 'ontem':
                $auditorias = $auditorias->whereDate('created_at', date('Y-m-d', strtotime('-1 days')));
                break;
            case 'semana':
                $auditorias = $auditorias->whereDate('created_at', '>=', date('Y-m-d', strtotime('-7 days')));
                break;
            case 'mes':
                $auditorias = $auditorias->whereDate('created_at', '>=', date('Y-m-d', strtotime('-30 days')));
                break;
            case 'ultimo_mes':
                $auditorias = $auditorias->whereMonth('created_at', date('m'));
                break;
            case 'personalizado':
                if($request->data_inicio > $request->data_final) {
                    return redirect()->route('auditorias.index')->with('error', 'A data inicial deve ser menor que a data final!');
                }

                $auditorias = $auditorias->whereBetween('created_at', [$request->data_inicio, $request->data_final]);
                break;
            default:
                return redirect()->route('auditorias.index')->with('error', 'Selecione uma data válida!');
                break;
        }

        $auditorias = $auditorias->with('usuario')->orderBy('created_at', 'desc')->get();

        $mensagens = array();

        foreach ($auditorias as $key => $auditoria) {
            $model = explode("\\" ,$auditoria->auditable_type)[2];

            switch ($model) {
                case 'Usuario':
                    $usuario = Usuario::find($auditoria->auditable_id);
                    $model = 'o usuário '.$usuario->nome.', id';
                    break;
                case 'Solicitacao':
                    $model = 'a solicitação';
                    break;
                case 'Orgao':
                    $model = 'o órgão';
                    break;
                case 'Diretoria':
                    $model = 'a diretoria';
                    break;
                case 'Divisao':
                    $model = 'a divisão';
                    break;
                case 'Entrega':
                    $model = 'a entrega';
                    break;
                case 'Produto':
                    $model = 'o produto';
                    break;
            }

            if($auditoria->new_values != '[]') {
                $auditoria->new_values = json_decode($auditoria->new_values);
            } else {
                $auditoria->new_values = '{}';
                $auditoria->new_values = json_decode($auditoria->new_values);
            }

            if($auditoria->old_values != '[]') {
                $auditoria->old_values = json_decode($auditoria->old_values);
            } else {
                $auditoria->old_values = '{}';
                $auditoria->old_values = json_decode($auditoria->old_values);
            }

            switch ($auditoria->event) {
                case 'created':
                    $acao = 'criou';
                    $campos = '';
                    foreach ($auditoria->new_values as $campo => $valor) {
                        if($valor != end($auditoria->new_values)) {
                            $campos .= $campo. ' com o valor "' .$valor. '", ';
                        } else {
                            $campos .= $campo. ' com o valor "' .$valor.'"';
                        }
                    }
                    break;
                case 'updated':
                    $acao = 'alterou';
                    $campos = '';
                    foreach ($auditoria->old_values as $campo => $valor) {
                        if($valor != end($auditoria->old_values)) {
                            $campos .= $campo. ' de "' .$valor. '" para "' .$auditoria->new_values->$campo.'", ';
                        } else {
                            $campos .= $campo. ' de "' .$valor. '" para "' .$auditoria->new_values->$campo.'"';
                        }
                    }
                    break;
                case 'deleted':
                    $acao = 'excluiu';
                    $campos = '';
                    foreach ($auditoria->old_values as $campo => $valor) {
                        if($valor != end($auditoria->old_values)) {
                            $campos .= $campo. ' com o valor "' .$valor. '", ';
                        } else {
                            $campos .= $campo. ' com o valor "' .$valor.'"';
                        }
                    }
                    break;
            }

            $mensagens[$key] = '- '.$auditoria->usuario->nome.' '.$acao.' '.$model.' '.$auditoria->auditable_id.' com '.$campos.' em '.Carbon::parse($auditoria->created_at)->format('d/m/Y H:i:s');
        }

        $mensagensFormatadas = array();
        foreach ($mensagens as $mensagem) {
            $mensagem = str_replace('qntde_estoque', 'quantidade estoque', $mensagem);
            $mensagem = str_replace('qntde_solicitada', 'quantidade solicitada', $mensagem);
            $mensagem = str_replace('qntde', 'quantidade', $mensagem);
            $mensagem = str_replace('senha_provisoria', 'senha provisória', $mensagem);
            $mensagem = str_replace('valor "",', 'valor vazio,', $mensagem);
        
            $mensagensFormatadas[] = $mensagem;
        }
        
        return view('auditoria.pesquisa', ['mensagens' => $mensagensFormatadas, 'auditorias' => $auditorias]);
    }
}