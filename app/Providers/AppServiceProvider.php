<?php

namespace App\Providers;

use App\Menu\Filters\TenantPrefixFilter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('current.tenant', function () {
            return null;
        });
    }

    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useBootstrap();

        \Illuminate\Support\Facades\Gate::define('admin', function ($user) {
            return $user->is_admin;
        });

        View::composer('*', function ($view) {
            $tenant = request()->route('tenant');
            if ($tenant) {
                $view->getFactory()->startSection('logout_url', '/' . $tenant . '/logout');
                $view->getFactory()->startSection('dashboard_url', '/' . $tenant . '/home');
                $view->getFactory()->startSection('login_url', '/' . $tenant . '/login');
            }
        });
    }
}
