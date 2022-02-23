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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
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
});
