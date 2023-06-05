<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\DivisaoController;
use App\Http\Controllers\DiretoriaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/toners', [ProdutoController::class, 'toners']);
Route::get('/toner-por-impressora/{impressoraId}', [ProdutoController::class, 'tonerPorImpressora']);
Route::get('/cilindros', [ProdutoController::class, 'cilindros']);
Route::get('/cilindro-por-impressora/{impressoraId}', [ProdutoController::class, 'cilindroPorImpressora']);
Route::get('/diretorias', [DiretoriaController::class, 'diretorias']);
Route::get('/divisoes', [DivisaoController::class, 'divisoes']);
Route::get('/divisoes-por-diretoria/{diretoriaId}', [DivisaoController::class, 'divisoesPorDiretoria']);