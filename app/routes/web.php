<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrgaoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DiretoriaController;
use App\Http\Controllers\DivisaoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\LocalImpressoraController;
use App\Http\Controllers\SuprimentoController;
use App\Http\Controllers\ImpressoraController;
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

// rotas user_interno
Route::middleware(['auth', 'user_interno'])->group(function () {  
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('orgaos', OrgaoController::class);
    Route::resource('diretorias', DiretoriaController::class);
    Route::resource('divisao', DivisaoController::class);
    Route::resource('produtos', ProdutoController::class);
    Route::resource('entregas', EntregaController::class);
    
    Route::get('solicitacoes/', [SolicitacaoController::class, 'index'])->name('solicitacoes.index');
    Route::get('solicitacoes/{id}', [SolicitacaoController::class, 'edit'])->name('solicitacoes.edit');
    Route::match(['put', 'patch'], 'solicitacoes/{id}', [SolicitacaoController::class, 'update'])->name('solicitacoes.update');
    Route::delete('solicitacoes/{id}', [SolicitacaoController::class, 'delete'])->name('solicitacoes.delete');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('produtos/{id}/locais', [LocalImpressoraController::class, 'create'])->name('locais.create');
    Route::post('produtos/{id}/locais', [LocalImpressoraController::class, 'store'])->name('locais.store');
    Route::match(['put', 'patch'], 'produtos/{id}/locais', [LocalImpressoraController::class, 'update'])->name('locais.update');

    Route::get('produtos/{id}/suprimentos', [SuprimentoController::class, 'create'])->name('suprimentos.create');
    Route::post('produtos/{id}/suprimentos', [SuprimentoController::class, 'store'])->name('suprimentos.store');
    Route::match(['put', 'patch'], 'produtos/{id}/suprimentos', [SuprimentoController::class, 'update'])->name('suprimentos.update');

    Route::get('produtos/{id}/impressoras', [ImpressoraController::class, 'create'])->name('impressoras.create');
    Route::post('produtos/{id}/impressoras', [ImpressoraController::class, 'store'])->name('impressoras.store');
    Route::match(['put', 'patch'], 'produtos/{id}/impressoras', [ImpressoraController::class, 'update'])->name('impressoras.update');
});

// rotas clientes
Route::group(['middleware' => 'auth'], function () {
    // Route::get('solicitar/nova-solicitacao', 'App\Http\Controllers\SolicitacaoController::class@create');
    Route::get('solicitar/', [SolicitacaoController::class, 'create'])->name('solicitacoes.create');
    Route::post('solicitar/', [SolicitacaoController::class, 'store'])->name('solicitacoes.store');
    Route::get('/minhas-solicitacoes', 'App\Http\Controllers\SolicitacaoController@minhasSolicitacoes')->name('minhas-solicitacoes');
    Route::get('/sem-permissao', function() {
        return view('sem-permissao');
    })->name('sem-permissao');
    Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
});

// rotas autenticação
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('minhas-solicitacoes');
    } else {
        return view('auth.login');
    }

})->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login.login');
Route::get('/', function () {
    return redirect()->route('home');
});