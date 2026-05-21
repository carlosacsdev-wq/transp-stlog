<?php
 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
 
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\ViagemController;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\CarregamentoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CanhotoController;
 
Route::get('/', function () {
    return redirect('/login');
});
 
Auth::routes(['register' => false]);
 
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
 
    Route::resource('motoristas', MotoristaController::class);
    Route::resource('veiculos', VeiculoController::class);
    Route::resource('cargas', CargaController::class);
    Route::resource('carregamentos', CarregamentoController::class)->parameters([
        'carregamentos' => 'carregamento'
    ])->only(['index', 'edit', 'update']);
    Route::get('carregamentos/{carregamento}/coleta', [CarregamentoController::class, 'coleta'])->name('carregamentos.coleta');
    Route::resource('contas', ContaController::class);
    Route::resource('pagamentos', PagamentoController::class);
    Route::resource('viagens', ViagemController::class)->parameters([
        'viagens' => 'viagem'
    ]);
    Route::resource('canhotos', CanhotoController::class)->only(['index', 'edit', 'update']);
 
    // Somente administradores podem gerenciar usuários
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
 
    // Route::match(['get', 'post'], 'logout', function () {
    //     auth()->logout();
    //     return redirect('/login');
    // })->name('logout');
});
