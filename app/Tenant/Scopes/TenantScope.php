<?php

namespace App\Tenant\Scopes;

use App\Tenant\ManagerTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    // public function apply(Builder $builder, Model $model): void
    // {
    //     $managerTenant = app(ManagerTenant::class);

    //     $identify = app(ManagerTenant::class)->getTenantIdentify();

    //     if (!$identify)
    //     { 
    //         $builder->where('tenant_id', );
    //     }
    // }
    public function apply(Builder $builder, Model $model)
    {
        $identify = app(ManagerTenant::class)->getTenantIdentify();

        if ($identify)
            $builder->where('tenant_id', $identify);
    }
}

