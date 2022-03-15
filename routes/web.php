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

use App\Http\Controllers\BillingController;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::impersonate();

    /*
     * General route that redirect to the first account
     */
    Route::get('/', function () {
        return redirect(route('dashboard', request()->user()->accounts()->first()->id));
    })->name('home');

    Route::get('site_search', App\Http\Controllers\SearchController::class)->name('site.search');

    Route::prefix('{account}')->middleware('can:viewAny,account')->group(function () {
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
            Route::put('/info', [BillingController::class, 'update'])->name('billing.info.update');
            Route::put('/', [App\Http\Controllers\BillingController::class, 'store'])->name('billing.update');
            Route::get('/mange_subscriptions', [App\Http\Controllers\BillingController::class, 'manageSubscriptions'])->name('billing.manageSubscriptions');
            Route::post('/subscribe/{plan}', [App\Http\Controllers\BillingController::class, 'subscribe'])->name('billing.subscribe');
            Route::get('invoice/{invoice}', [App\Http\Controllers\BillingController::class, 'invoice'])->name('billing.invoice');
            Route::put('subscriptions/{subscription}', [App\Http\Controllers\SubscriptionController::class, 'update'])->name('subscriptions.update');
        });

        Route::resource('logs', App\Http\Controllers\LogController::class)->only([
            'index', 'destroy',
        ]);

        Route::get('subscriptions', [App\Http\Controllers\SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::put('subscriptions/{subscription}', [App\Http\Controllers\SubscriptionController::class, 'update'])->name('subscriptions.update');
        Route::resource('sites', App\Http\Controllers\SiteController::class)->except([
            'show',
        ]);
        Route::resource('groups', App\Http\Controllers\GroupController::class)->except([
            'show',
        ]);
        Route::resource('contacts', App\Http\Controllers\ContactController::class)->only([
            'index', 'edit', 'update',
        ]);
        Route::get('installs/{install}', [App\Http\Controllers\InstallController::class, 'show'])->name('installs.show');
        Route::post('/form-validation', [App\Http\Controllers\SiteController::class, 'formValidation'])->name('validation');
    });
});
