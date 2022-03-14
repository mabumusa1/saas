<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Group;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use App\Policies\AccountPolicy;
use App\Policies\ContactPolicy;
use App\Policies\GroupPolicy;
use App\Policies\InstallPolicy;
use App\Policies\SitePolicy;
use App\Policies\UserPolicy;
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
        Account::class => AccountPolicy::class,
        Contact::class => ContactPolicy::class,
        Group::class => GroupPolicy::class,
        Site::class => SitePolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function (User $user) {
            /* @phpstan-ignore-next-line */
            return $user->accounts()->first()->pivot->role === 'admin';
        });
    }
}
