<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function __construct() {
        
    }

    public function index() {
        return view('relatorio.index');
    }
}
