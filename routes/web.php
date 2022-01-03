<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BillsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MetersController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
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

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Dashboard


//Admin


//Route::prefix('admin')->middleware('auth')->group(function () {
//
//});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');
//    Route::get('/dashboard', [DashboardController::class, 'index'])
//        ->name('dashboard');

    Route::get('bills', [BillsController::class, 'index'])
        ->name('bills');

    Route::get('bills/create', [BillsController::class, 'create'])
        ->name('bills.create');

    Route::get('meters', [MetersController::class, 'index'])
        ->name('meters');

    Route::get('meters/create', [MetersController::class, 'create'])
        ->name('meters.create');

    Route::get('meters/{meter}/edit', [MetersController::class, 'edit'])
        ->name('meters.edit');

    Route::get('meters/{meter}', [MetersController::class, 'update'])
        ->name('meters.update');

    Route::post('meters', [MetersController::class, 'store'])
        ->name('meters.store');

    Route::get('reports', [ReportsController::class, 'index'])
        ->name('reports');


});

//
// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');


// Reports


// bills


//Route::get('organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
//    ->name('organizations.edit')
//    ->middleware('auth');
//
//Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
//    ->name('organizations.update')
//    ->middleware('auth');
//
//Route::delete('organizations/{organization}', [OrganizationsController::class, 'destroy'])
//    ->name('organizations.destroy')
//    ->middleware('auth');
//
//Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
//    ->name('organizations.restore')
//    ->middleware('auth');
