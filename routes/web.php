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
use App\Http\Controllers\ChatController;

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

        Route::middleware(['admin'])->group(function () {
            Route::resource('users', UserController::class);
        });
    });
});

Route::middleware(['auth'])->prefix('api/chat')->group(function () {
    Route::get('conversations', [ChatController::class, 'index'])->name('chat.conversations.index');
    Route::post('conversations', [ChatController::class, 'store'])->name('chat.conversations.store');
    Route::get('conversations/{conversation}', [ChatController::class, 'show'])->name('chat.conversations.show');
    Route::get('conversations/{conversation}/messages', [ChatController::class, 'messages'])->name('chat.conversations.messages');
    Route::post('conversations/{conversation}/messages', [ChatController::class, 'sendMessage'])->name('chat.conversations.send');
});
