<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenantSlug = $request->route('tenant');

        if ($tenantSlug) {
            try {
                $tenant = Tenant::where('slug', $tenantSlug)->where('is_active', true)->first();
            } catch (\Exception $e) {
                $tenant = null;
            }

            if ($tenant) {
                app()->instance('current.tenant', $tenant);
            }
        }

        return $next($request);
    }
}
