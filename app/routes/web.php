<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrgaoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DiretoriaController;
use App\Http\Controllers\DivisaoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\SolicitacaoController;
use App\Http\Controllers\EntregaController;




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

Route::group(['middleware' => 'auth'], function () {  
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('orgaos', OrgaoController::class);
    Route::resource('diretorias', DiretoriaController::class);
    Route::resource('divisao', DivisaoController::class);
    Route::resource('produtos', ProdutoController::class);
    Route::resource('entregas', EntregaController::class);
    Route::resource('solicitar', SolicitacaoController::class);
    // Route::get('solicitar/nova-solicitacao', 'App\Http\Controllers\SolicitacaoController::class@create');
    // Route::get('/minhas-solicitacoes', 'App\Http\Controllers\SolicitacaoController@minhasSolicitacoes')->name('minhas-solicitacoes');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login.login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
