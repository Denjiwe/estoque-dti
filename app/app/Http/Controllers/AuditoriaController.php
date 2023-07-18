<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
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

        $auditorias = $auditorias->orderBy('created_at', 'desc')->get();

        dd($auditorias);
        return view('auditoria.pesquisa', compact('auditorias'));
    }
}