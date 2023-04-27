<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::group(function () {  middleware('auth:sanctum')
    Route::resource('usuarios', App\Http\Controllers\UsuariosController::class);
    Route::resource('orgaos', App\Http\Controllers\OrgaoController::class);
    Route::resource('diretorias', App\Http\Controllers\DiretoriaController::class);
    Route::resource('divisoes', App\Http\Controllers\DivisaoController::class);
    Route::resource('produtos', App\Http\Controllers\ProdutoController::class);
    Route::resource('entregas', App\Http\Controllers\EntregaController::class);
    Route::resource('solicitar', App\Http\Controllers\SolicitacaoController::class);
    Route::get('solicitar/nova-solicitacao', 'App\Http\Controllers\SolicitacaoController::class@create');
    Route::get('/minhas-solicitacoes', 'App\Http\Controllers\SolicitacaoController@minhasSolicitacoes')->name('minhas-solicitacoes');
// });
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
