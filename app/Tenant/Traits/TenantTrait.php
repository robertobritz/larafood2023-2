<?php 

namespace App\Tenant\Traits;

use App\Tenant\Observers\TenantObserver;
use App\Tenant\Scopes\TenantScope;

trait TenantTrait
{
        /**
     * The "booted" method of the model.
     */
    // protected static function booted(): void // antigo
    // {
    //     parent::boot();

    //     static::observe(TenantObserver::class);

    //     static::addGlobalScope(new TenantScope);
    // }
    protected static function boot() // igual ao do professor
    {
        parent::boot();

        static::observe(TenantObserver::class);

        static::addGlobalScope(new TenantScope);
    }
}