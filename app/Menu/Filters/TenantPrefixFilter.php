<?php

namespace App\Menu\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class TenantPrefixFilter implements FilterInterface
{
    public function transform($item)
    {
        if (isset($item['prefix']) && $item['prefix'] === 'tenant' && isset($item['url'])) {
            $tenant = request()->route('tenant');
            if ($tenant) {
                $item['url'] = '/' . $tenant . '/' . ltrim($item['url'], '/');
            }
        }

        return $item;
    }
}
