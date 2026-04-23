<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('is_admin', function ($user) {
            return $user->nivel=='administrador'?true:false;
        });

        Gate::define('is_cliente', function ($user) {
            return $user->nivel=='cliente'?true:false;
        });

        Gate::define('is_laboratorio', function ($user) {
            return $user->nivel=='laboratorio'?true:false;
        });

    }
}
