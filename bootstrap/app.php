<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        $middleware->web(prepend: [
            \App\Http\Middleware\IdentifyTenant::class,
        ]);

        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            $tenant = $request->route('tenant');
            if ($tenant) {
                return '/' . $tenant . '/login';
            }
            return '/login';
        });

        $middleware->redirectUsersTo(function (\Illuminate\Http\Request $request) {
            $tenant = $request->route('tenant');
            if ($tenant) {
                return '/' . $tenant . '/home';
            }
            return '/home';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
