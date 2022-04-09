<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/invite/{invite:token}', 'InviteController@index')->name('invites.index');
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('/invite', 'InviteController@accept')->middleware('auth:sanctum')->name('invites.accept');
    Route::impersonate();

    /*
     * General route that redirect to the first account
     */
    Route::get('/', function () {
        return redirect(route('dashboard', request()->user()->accounts()->first()->id));
    })->name('home');

    Route::get('site_search', App\Http\Controllers\SearchController::class)->name('site.search');

    Route::prefix('account/{account}')->middleware('can:viewAny,account')->group(function () {
        /*
         * Account dashboard, accessed by all the users on that account
         */

        Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

        /*
         * The admin dashboard that allows the admin to impersonate other users
         * This route is accessible for admins only
         */
        Route::prefix('admin')->middleware('can:isAdmin,user')->group(function () {
            Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
        });

        /*
         * The Users Route
         * manages the users and their accesses
         */
        Route::resource('users', App\Http\Controllers\UserController::class)->except([
            'show',
        ]);

        /*
         * Billing Routes
         */
        Route::prefix('billing')->middleware(['can:changeBilling,account', 'impersonate.protect'])->group(function () {
            Route::get('/', [App\Http\Controllers\BillingController::class, 'index'])->name('billing.index');
            Route::put('/info', [App\Http\Controllers\BillingController::class, 'update'])->name('billing.info.update');
            Route::put('/', [App\Http\Controllers\BillingController::class, 'store'])->name('billing.update');
            Route::get('/mange_subscriptions', [App\Http\Controllers\BillingController::class, 'manageSubscriptions'])->name('billing.manageSubscriptions');
            Route::post('/subscribe/{plan}', [App\Http\Controllers\BillingController::class, 'subscribe'])->name('billing.subscribe');
            Route::get('invoice/{invoice}', [App\Http\Controllers\BillingController::class, 'invoice'])->name('billing.invoice');
        });

        /*
         * Sites route
         */
        Route::resource('sites', App\Http\Controllers\SiteController::class)->except([
            'show',
        ]);

        /*
        * Logs route
        */
        Route::resource('logs', App\Http\Controllers\LogController::class)->only([
            'index', 'destroy',
        ]);

        /*
         * Groups Route
         */
        Route::resource('groups', App\Http\Controllers\GroupController::class)->except([
            'show',
        ]);

        /*
         * Contacts Route
         */
        Route::resource('contacts', App\Http\Controllers\ContactController::class)->only([
            'index', 'edit', 'update',
        ]);

        /*
         * Install Routes
         */
        Route::prefix('sites/{site}')->group(function () {
            Route::resource('installs', App\Http\Controllers\InstallController::class)->only([
                'create', 'store', 'show', 'destroy',
            ]);
            Route::resource('{install}/domains', App\Http\Controllers\DomainController::class)->only([
                'index', 'store', 'destroy',
            ]);
            Route::post('{install}/domain/redirect', [App\Http\Controllers\DomainController::class, 'redirect'])->name('domains.redirect');
            Route::post('{install}/domain/{domain}/setPrimary', [App\Http\Controllers\DomainController::class, 'setPrimary'])->name('domains.setPrimary');
            Route::put('{install}/copy', [App\Http\Controllers\InstallController::class, 'copy'])->name('installs.copy');

            /*
            * Transfer Routes within an install
            */
            Route::prefix('{install}/transfer')->group(function () {
                Route::post('start', [App\Http\Controllers\TransferController::class, 'start'])->name('transfer.start');
            });
        });

        /*
         * Independent transfer operations
         */
        Route::prefix('transfer')->group(function () {
            Route::post('check', [App\Http\Controllers\TransferController::class, 'check'])->name('transfer.check');
            Route::get('{transfer}', [App\Http\Controllers\TransferController::class, 'show'])->name('transfer.show');
            Route::post('{transfer}/accept', [App\Http\Controllers\TransferController::class, 'accept'])->name('transfer.accept');
        });
    });
});
