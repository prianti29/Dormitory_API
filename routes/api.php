<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MealController;
use Tymon\JWTAuth\Contracts\Providers\Auth;


//Memmber
Route::resource('/member', MemberController::class);

//Meal
Route::resource('/meal', MealController::class);
Route::get('/monthly-count', [MealController::class, 'monthlyCount']);
Route::get('/monthly-count-view', [MealController::class, 'monthlyCountView']);

//Cost
Route::resource('/cost', CostController::class);
Route::get('/monthly-cost', [CostController::class, 'monthlyCost']);
Route::get('/monthly-cost-view', [CostController::class, 'monthlyCostView']);

//Accounts
Route::resource('/account', AccountController::class);
Route::get('/perHead-deposit', [AccountController::class, 'perHeadDeposit']);
Route::get('/perHead-deposit-view', [AccountController::class, 'perHeadDepositView']);

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'as' => 'auth.'
], function () {
    Route::get('/dashboard', function (Request $request) {
        return view('dashboard');
    });
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/me', 'AuthController@me');
    Route::post('/payload', 'AuthController@payload');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
