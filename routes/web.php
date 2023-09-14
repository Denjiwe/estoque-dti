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
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\AuditoriaController;

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
    Route::get('usuarios/pesquisa', [UsuarioController::class, 'pesquisa'])->name('usuarios.pesquisa');
    Route::resource('usuarios', UsuarioController::class);
    Route::get('orgaos/pesquisa', [OrgaoController::class, 'pesquisa'])->name('orgao.pesquisa');
    Route::resource('orgaos', OrgaoController::class);
    Route::get('diretorias/pesquisa', [DiretoriaController::class, 'pesquisa'])->name('diretorias.pesquisa');
    Route::resource('diretorias', DiretoriaController::class);
    Route::get('divisoes/pesquisa', [DivisaoController::class, 'pesquisa'])->name('divisoes.pesquisa');
    Route::resource('divisao', DivisaoController::class);
    Route::get('produtos/pesquisa', [ProdutoController::class, 'pesquisa'])->name('produtos.pesquisa');
    Route::resource('produtos', ProdutoController::class);
    Route::get('entregas/pesquisa', [EntregaController::class, 'pesquisa'])->name('entregas.pesquisa');
    Route::resource('entregas', EntregaController::class);

    Route::get('solicitacoes/pesquisa', [SolicitacaoController::class, 'pesquisa'])->name('solicitacoes.pesquisa');
    Route::get('solicitacoes', [SolicitacaoController::class, 'index'])->name('solicitacoes.abertas');
    Route::get('solicitacoes/{id}', [SolicitacaoController::class, 'edit'])->name('solicitacoes.edit');
    Route::match(['put', 'patch'], 'solicitacoes/{id}', [SolicitacaoController::class, 'update'])->name('solicitacoes.update');
    Route::delete('solicitacoes/{id}', [SolicitacaoController::class, 'destroy'])->name('solicitacoes.destroy');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('produtos/{id}/locais', [LocalImpressoraController::class, 'create'])->name('locais.create');
    Route::post('produtos/{id}/locais', [LocalImpressoraController::class, 'store'])->name('locais.store');
    Route::match(['put', 'patch'], 'produtos/{id}/locais', [LocalImpressoraController::class, 'update'])->name('locais.update');

    Route::get('produtos/{id}/suprimentos', [ImpressoraController::class, 'create'])->name('suprimentos.create');
    Route::post('produtos/{id}/suprimentos', [ImpressoraController::class, 'store'])->name('suprimentos.store');
    Route::match(['put', 'patch'], 'produtos/{id}/suprimentos', [ImpressoraController::class, 'update'])->name('suprimentos.update');

    Route::get('produtos/{id}/impressoras', [SuprimentoController::class, 'create'])->name('impressoras.create');
    Route::post('produtos/{id}/impressoras', [SuprimentoController::class, 'store'])->name('impressoras.store');
    Route::match(['put', 'patch'], 'produtos/{id}/impressoras', [SuprimentoController::class, 'update'])->name('impressoras.update');

    Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');
    Route::post('/relatorios/pesquisa', [RelatorioController::class, 'pesquisa'])->name('relatorios.pesquisa');
    Route::post('/relatorios/pesquisa', [RelatorioController::class, 'pesquisa'])->name('relatorios.pesquisa');

    Route::get('/auditoria', [AuditoriaController::class, 'index'])->name('auditorias.index');
    Route::post('/auditoria/pesquisa', [AuditoriaController::class, 'pesquisa'])->name('auditorias.pesquisa');
    Route::get('/auditoria/pesquisa', [AuditoriaController::class, 'pesquisa'])->name('auditorias.show');
});

// rotas clientes
Route::group(['middleware' => 'auth'], function () {
    Route::get('solicitar/', [SolicitacaoController::class, 'create'])->name('solicitacoes.create');
    Route::post('solicitar/', [SolicitacaoController::class, 'store'])->name('solicitacoes.store');
    Route::get('minhas-solicitacoes', [SolicitacaoController::class, 'index'])->name('minhas-solicitacoes.index');
    Route::get('/sem-permissao', function() {
        return view('sem-permissao');
    })->name('sem-permissao');
    Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
});

// rotas autenticação
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('minhas-solicitacoes.abertas');
    } else {
        return view('auth.login');
    }
})->name('login');
Route::get('/alterar-senha/{usuarioId}', [UsuarioController::class, 'senhaEdit'])->name('alterar-senha');
Route::patch('/alterar-senha/{usuarioId}', [UsuarioController::class, 'senhaUpdate'])->name('alterar-senha.update');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login.login');
Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('/nojs', function () {
    return view('nojs');
})->name('nojs');
