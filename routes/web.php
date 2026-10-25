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
use App\Http\Controllers\DiariasController;

Route::get('/', function () {
    $tenant = \App\Models\Tenant::where('is_active', true)->first();
    if ($tenant) {
        return redirect()->to('/' . $tenant->slug);
    }
    return redirect('/login');
});

Route::get('/login', function () {
    $tenant = \App\Models\Tenant::where('is_active', true)->first();
    if ($tenant) {
        return redirect()->to('/' . $tenant->slug . '/login');
    }
    return redirect('/login');
});

Route::prefix('{tenant}')->group(function () {
    Route::get('/', function () {
        return redirect()->to('/' . request()->route('tenant') . '/login');
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
        Route::get('financeiro/diarias', [DiariasController::class, 'index'])->name('financeiro.diarias.index');
        Route::get('financeiro/diarias/{viagem}/edit', [DiariasController::class, 'edit'])->name('financeiro.diarias.edit');
        Route::put('financeiro/diarias/{viagem}', [DiariasController::class, 'update'])->name('financeiro.diarias.update');
        Route::post('financeiro/diarias/{viagem}/aprovar', [DiariasController::class, 'approve'])->name('financeiro.diarias.approve');
        Route::post('financeiro/diarias/{viagem}/pagar', [DiariasController::class, 'pay'])->name('financeiro.diarias.pay');

        Route::middleware(['admin'])->group(function () {
            Route::resource('users', UserController::class);
        });
    });
});
