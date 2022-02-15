<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('sites', SiteController::class);
    Route::resource('groups', GroupController::class);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('data-center', App\Http\Controllers\DataCenterController::class)->only('index', 'create', 'store');

Route::resource('site', App\Http\Controllers\SiteController::class);

Route::resource('install', App\Http\Controllers\InstallController::class);

Route::resource('domain', App\Http\Controllers\DomainController::class)->only('create', 'store', 'destroy');

Route::resource('group', App\Http\Controllers\GroupController::class);

Route::resource('account', App\Http\Controllers\AccountController::class)->only('index', 'show');
