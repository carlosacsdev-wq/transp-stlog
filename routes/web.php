<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\ViagemController;

use App\Http\Controllers\ContaController;

Route::get('/', function () {
    return redirect('/login');
});

Route::resource('motoristas', MotoristaController::class);
Route::resource('veiculos', VeiculoController::class);
Route::resource('cargas', CargaController::class);
Route::resource('contas', ContaController::class);
Route::resource('pagamentos', PagamentoController::class);
Route::resource('viagens', ViagemController::class)->parameters([
    'viagens' => 'viagem'
]);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::match(['get', 'post'], 'logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');
