<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) return; 
        
        $permissions = Permission::all(); //retorna todas as pemissões

        foreach ($permissions as $permission) { //verifica se o usuário tem a permissão
            Gate::define($permission->name, function(User $user) use ($permission){
                return $user->hasPermission($permission->name);
            });
        }

        Gate::define('owner', function(User $user, $object){
            return $user->id === $object->user_id;
        });
        
        Gate::before(function (User $user){
            if ($user->isAdmin()){
            return true;
            }
        });
    }
}
