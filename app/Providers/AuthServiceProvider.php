<?php

namespace App\Providers;

use App\Models\Team;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /* define a owner user role */
        Gate::define('isOwner', function ($user) {
            return $user->accountUser->role == 'owner';
        });

        /* define a fb user role */
        Gate::define('isFb', function ($user) {
            return $user->accountUser->role == 'fb';
        });

        /* define a fnb role */
        Gate::define('isFnb', function ($user) {
            return $user->accountUser->role == 'fnb';
        });

        /* define a pb role */
        Gate::define('isPb', function ($user) {
            return $user->accountUser->role == 'pb';
        });

        /* define a pnb role */
        Gate::define('isPnb', function ($user) {
            return $user->accountUser->role == 'pnb';
        });
    }
}
