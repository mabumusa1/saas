<?php

namespace App\Providers;

use App\Core\Adapters\Theme;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $theme = theme();
        // Share theme adapter class
        View::share('theme', $theme);
        $theme->setDemo('skin');

        $theme->initConfig();

        bootstrap()->run();

        if (isRTL()) {
            // RTL html attributes
            Theme::addHtmlAttribute('html', 'dir', 'rtl');
            Theme::addHtmlAttribute('html', 'direction', 'rtl');
            Theme::addHtmlAttribute('html', 'style', 'direction:rtl;');
        }

        Paginator::useBootstrap();

        Cashier::useCustomerModel(Account::class);

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
    }
}
