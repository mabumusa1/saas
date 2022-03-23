<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\Cashier\Subscription;
use App\Models\Cashier\SubscriptionItem;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Spatie\Activitylog\ActivityLogger;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Amirami\Localizator\ServiceProvider::class);
        }
        ActivityLogger::macro('onAccount', function ($accountId) {
            /* @var mixin $this */
            $this->getActivity()->account()->associate($accountId);

            return $this;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Cashier::useCustomerModel(Account::class);
        Cashier::useSubscriptionModel(Subscription::class);
        Paginator::useBootstrap();
        view()->composer('*', function ($view) {
            if (\Auth::check()) {
                $account = request()->route('account');
                if (is_null($account)) {
                    /** @phpstan-ignore-next-line */
                    $account = \Auth::user()->accounts->first();
                }

                $view->with('currentAccount', $account);
            }
        });
        if ($stripeApiBase = config('services.stripe.api_base')) {            
            \Stripe\Stripe::$apiBase = $stripeApiBase;
        }
    }
}
