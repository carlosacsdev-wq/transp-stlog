<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        static::creating(function ($model) {
            try {
                if (Auth::hasUser() && !$model->tenant_id) {
                    $user = Auth::user();
                    if ($user && $user->tenant_id) {
                        $model->tenant_id = $user->tenant_id;
                    }
                }
            } catch (\Exception $e) {
                // Ignore if auth not available
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            try {
                if (Auth::hasUser()) {
                    $user = Auth::user();
                    if ($user && $user->tenant_id) {
                        $builder->where('tenant_id', $user->tenant_id);
                    }
                }
            } catch (\Exception $e) {
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
