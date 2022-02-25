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

use App\Http\Controllers\SearchController;

Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@authenticate')->name('post.login');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('site_search', SearchController::class)->name('site.search');
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('{account}')->middleware('can:viewAny,account')->group(function () {
        Route::resource('sites', App\Http\Controllers\SiteController::class)->except([
            'show',
        ]);
        Route::resource('groups', App\Http\Controllers\GroupController::class)->except([
            'show',
        ]);
        Route::resource('users', App\Http\Controllers\UserController::class)->except([
            'show',
        ]);
        Route::resource('contacts', App\Http\Controllers\ContactController::class)->only([
            'index', 'edit', 'update',
        ]);
        Route::post('/form-validation', [App\Http\Controllers\SiteController::class, 'formValidation'])->name('validation');
    });

    Route::prefix('{account}/admin')->middleware('admin')->group(function () {
        Route::resource('dashboard', App\Http\Controllers\Admin\AdminController::class)->only([
            'index',
        ]);

        Route::get('/login-as-client', [App\Http\Controllers\Admin\LoginAsClient::class, 'loginAsClient'])->name('login.as.client');
    });
});
