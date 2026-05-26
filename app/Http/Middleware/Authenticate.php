<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            $tenant = $request->route('tenant');
            if ($tenant) {
                return '/' . $tenant . '/login';
            }
            return route('login');
        }

        return null;
    }
}
