<?php

use App\Http\Controllers\AbonentsController;
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

//Admin


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');


    // basic bills actions
    Route::get('bills', [BillsController::class, 'index'])
        ->name('bills');
    Route::get('bills/{account}/create', [BillsController::class, 'create'])
        ->name('bills.create');
    Route::post('bills/{account}/store', [BillsController::class, 'store'])
        ->name('bills.store');


    // create bills from meters
    Route::get('bills/{meter}/meters/create', [BillsController::class, 'createFromMeters'])
        ->name('bills.create.meters');
    Route::post('bills/{meter}/meters/store', [BillsController::class, 'storeFromMeters'])
        ->name('bills.store.meters');



    // Meters from user dashboard
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




    // Abonents from admin dashboard


    Route::get('abonents', [AbonentsController::class, 'index'])
        ->name('abonents');
    Route::get('abonents/{account}/meters', [AbonentsController::class, 'abonentMeters'])
        ->name('abonents.meters');
    Route::get('abonents/{account}/bills', [AbonentsController::class, 'abonentBills'])
        ->name('abonents.bills');
    Route::get('abonents/{account}/bills/{bill}/delete', [BillsController::class, 'abonentBillsDelete'])
        ->name('abonents.bills.delete');
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

