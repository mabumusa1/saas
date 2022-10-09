<?php

namespace App\Providers;

use App\Classes\ActivityLogger as GlobalActivityLogger;
use App\Models\Account;
use App\Models\Subscription;
use App\Resolvers\AccountResolver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
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
        $this->app->singleton(AccountResolver::class);

        // @codeCoverageIgnoreStart
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Amirami\Localizator\ServiceProvider::class);
        }// @codeCoverageIgnoreEnd

        $this->app->bind(ActivityLogger::class, GlobalActivityLogger::class);
        ActivityLogger::macro('onAccount', function ($accountId) {
            /* @phpstan-ignore-next-line */
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
        if (config('services.stripe.api_base')) {
            Cashier::$apiBaseUrl = config('services.stripe.api_base');
            \Stripe\Stripe::$apiBase = config('services.stripe.api_base');
        }

        // Domain check rate limiter
        RateLimiter::for('VerifyDomain', function ($job) {
            return Limit::perHour(50)->by($job->domain->id);
        });

        Http::macro('kub8', function () {
            return Http::withBasicAuth(env('KUB8_USERNAME'), env('KUB8_PASSWORD'))->baseUrl(env('KUB8_API'));
        });
    }
}
